<?php

require_once("./VNPayResponse.php");
require_once("./VNPayResponseCode.php");
require_once("./VNPayQueryCode.php");
require_once("./VNPayRefundCode.php");

/**
 * VNPay class
 * Một số tên biến đặt không theo quy tắc do sử dụng lại code demo của VNPay
 * trách ai bây giờ :))
 */
class VNPay
{
    const
        VNP_COMMAND_PAY = 'pay',
        VNP_COMMAND_REFUND = 'refund',
        VNP_COMMAND_QUERY = 'querydr';

    private $vnpVersion = "2.1.0";

    private $vnpCurrCode = "VND";

    private function buildEndpoint($url, $inputData)
    {
        $query = buildHashQuery($inputData);
        $vnpSecureHash = hash_hmac(VNPAY_ALGORITHM, $query, VNPAY_SECRET_KEY);

        $inputData['vnp_SecureHash'] = $vnpSecureHash;
        $query = buildHashQuery($inputData);
        return $url . '?' .$query;
    }

    /**
     * @return stdClass
     */
    private function mockFindOrderFromDatabase()
    {
        return null;
    }

    private function mockUpdateOrderStatusIPN($orderId, $status)
    {
        // do something
    }

    /**
     * Tạo giao dịch
     *
     * @param $data
     */
    public function payment($data)
    {
        $startTime = date("YmdHis");
        $expire = date('YmdHis', strtotime('+15 minutes', strtotime($startTime)));

        $fullName = trim(getValueByKeyFromArray($data, 'txt_billing_fullname'));
        $vnpBillFirstName = "";
        $vnpBillLastName = "";
        if (!empty($fullName)) {
            $name = explode(' ', $fullName);
            $vnpBillFirstName = array_shift($name);
            $vnpBillLastName = array_pop($name);
        }

        $amount = getValueByKeyFromArray($data, 'amount', 0);
        $amount = setAmountToVNPay($amount);
        $inputData = array(
            "vnp_ReturnUrl" => VNPAY_URL_CALLBACK,
            "vnp_TmnCode" => VNPAY_WEBSITE_ID,
            "vnp_Command" => self::VNP_COMMAND_PAY,
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_Version" => $this->vnpVersion,
            "vnp_CurrCode" => $this->vnpCurrCode,
            "vnp_Amount" => $amount,
            "vnp_IpAddr" => getIP(),
            "vnp_Locale" => getValueByKeyFromArray($data, 'language'),
            "vnp_OrderInfo" => getValueByKeyFromArray($data, 'order_desc'),
            "vnp_OrderType" => getValueByKeyFromArray($data, 'order_type'),
            "vnp_TxnRef" => getValueByKeyFromArray($data, 'order_id'),

            // Add Params of 2.0.1 Version
            "vnp_ExpireDate" => getValueByKeyFromArray($data, 'txtexpire', $expire),

            // Thông tin hóa đơn (Billing)
            "vnp_Bill_Mobile" => getValueByKeyFromArray($data, 'txt_billing_mobile'),
            "vnp_Bill_Email" => getValueByKeyFromArray($data, 'txt_billing_email'),
            "vnp_Bill_FirstName" => $vnpBillFirstName,
            "vnp_Bill_LastName" => $vnpBillLastName,
            "vnp_Bill_Address" => getValueByKeyFromArray($data, 'txt_inv_addr1'),
            "vnp_Bill_City" => getValueByKeyFromArray($data, 'txt_bill_city'),
            "vnp_Bill_Country" => getValueByKeyFromArray($data, 'txt_bill_country'),

            // Thông tin gửi Hóa đơn điện tử (Invoice)
            "vnp_Inv_Phone" => getValueByKeyFromArray($data, 'txt_inv_mobile'),
            "vnp_Inv_Email" => getValueByKeyFromArray($data, 'txt_inv_email'),
            "vnp_Inv_Customer" => getValueByKeyFromArray($data, 'txt_inv_customer'),
            "vnp_Inv_Address" => getValueByKeyFromArray($data, 'txt_inv_addr1'),
            "vnp_Inv_Company" => getValueByKeyFromArray($data, 'txt_inv_company'),
            "vnp_Inv_Taxcode" => getValueByKeyFromArray($data, 'txt_inv_taxcode'),
            "vnp_Inv_Type" => getValueByKeyFromArray($data, 'cbo_inv_type')
        );

        $vnpBankCode = getValueByKeyFromArray($data, 'bank_code');
        if (!empty($vnpBankCode)) {
            $inputData['vnp_BankCode'] = $vnpBankCode;
        }

        $vnpBillState = getValueByKeyFromArray($data, 'txt_bill_state');
        if (!empty($vnpBillState)) {
            $inputData['vnp_Bill_State'] = $vnpBillState;
        }

        $endpoint = $this->buildEndpoint(VNPAY_PAYMENT_URL, $inputData);
        header('Location: ' . $endpoint);
        exit();
    }

    /**
     * Lấy dữ liệu của từng phiên thanh toán
     * @param $data
     * @return bool|string
     */
    public function tracking($data)
    {
        $inputData = [
            "vnp_Command" => self::VNP_COMMAND_QUERY,
            "vnp_TmnCode" => VNPAY_WEBSITE_ID,
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_Version" => $this->vnpVersion,
            "vnp_TxnRef" => getValueByKeyFromArray($data, 'order_id'),
            "vnp_OrderInfo" => getValueByKeyFromArray($data, 'order_desc'),
            "vnp_TransDate" => getValueByKeyFromArray($data, 'payment_date'),
            "vnp_IpAddr" => getIP()
        ];

        $endpoint = $this->buildEndpoint(VNPAY_MERCHANT_URL, $inputData);

        $ch = curl_init($endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $data = curl_exec($ch);
        curl_close($ch);

        return $data;
    }

    /**
     * VNPAY sẽ call tới đây và lấy response để cập nhật cho payment transaction
     * do đó, cần chú ý trả đúng các mã lỗi theo mô tả.
     *
     *
     * IPN URL: Ghi nhận kết quả thanh toán từ VNPAY
     * Các bước thực hiện:
     * Kiểm tra checksum
     * Tìm giao dịch trong database
     * Kiểm tra số tiền giữa hai hệ thống
     * Kiểm tra tình trạng của giao dịch trước khi cập nhật
     * Cập nhật kết quả vào Database
     * Trả kết quả ghi nhận lại cho VNPAY
     *
     * @param $data
     * @return false|string
     */
    public function confirm($data)
    {
        $resp = new VNPayResponse();
        $resp->computed($data);

        // Là trạng thái thanh toán của giao dịch chưa có IPN lưu tại hệ thống của merchant chiều khởi tạo URL thanh toán.
        // 0: chưa có IPN, 1: thành công, 2: thất bại

        try {

            // checksum
            if (!$resp->isValid()) {
                return json_encode(VNPayIPNCode::buildResponse(VNPayIPNCode::SIGNATURE_INVALID));
            }

            // get thông tin order từ database để check
            $order = $this->mockFindOrderFromDatabase();
            if (!$order) {
                return json_encode(VNPayIPNCode::buildResponse(VNPayIPNCode::AMOUNT_INVALID));
            }

            // Kiểm tra số tiền thanh toán của giao dịch: giả sử số tiền kiểm tra là đúng.
            if ($order->amount !== $resp->getAmount()) {
                return json_encode(VNPayIPNCode::buildResponse(VNPayIPNCode::AMOUNT_INVALID));
            }

            // Kiểm tra trạng thái đơn hàng với IPN status
            if ($order->ipnStatus !== 0) {
                return json_encode(VNPayIPNCode::buildResponse(VNPayIPNCode::ORDER_ALREADY_CONFIRMED));
            }

            $isSuccess = $resp->getResponseCode() === VNPayResponseCode::SUCCESS && $resp->getTransactionStatus() === VNPayResponseCode::SUCCESS;
            $statusIPN = $isSuccess ? 1 : 2;
            $this->mockUpdateOrderStatusIPN($order->id, $statusIPN);

            // return success
            return json_encode(VNPayIPNCode::buildResponse(VNPayIPNCode::SUCCESS));

        } catch (Exception $e) {
            return json_encode(VNPayIPNCode::buildResponse(VNPayIPNCode::UNKNOWN_ERROR));
        }
    }

    /**
     * Thực hiện refund tiền sau khi đã payment thành công
     * @param $data
     * @return bool|string
     */
    public function refund($data)
    {
        $amount = getValueByKeyFromArray($data, 'amount', 0);
        $amount = setAmountToVNPay($amount);
        $inputData = array(
            "vnp_TmnCode" => VNPAY_WEBSITE_ID,
            "vnp_Command" => self::VNP_COMMAND_REFUND,
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_Version" => $this->vnpVersion,
            "vnp_TransactionType" => getValueByKeyFromArray($data, 'trantype'),
            "vnp_CreateBy" => getValueByKeyFromArray($data, 'mail'),
            "vnp_TxnRef" => getValueByKeyFromArray($data, 'order_id'),
            "vnp_Amount" => $amount,
            "vnp_OrderInfo" => getValueByKeyFromArray($data, 'order_desc'),
            "vnp_TransDate" => getValueByKeyFromArray($data, 'payment_date'),
            "vnp_IpAddr" => getIP(),
        );

        $endpoint = $this->buildEndpoint(VNPAY_MERCHANT_URL, $inputData);

        $ch = curl_init($endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $data = curl_exec($ch);
        curl_close($ch);

        return $data;
    }

    /**
     * Parse dữ liệu ở trang return để hiển thị nhanh kết quả thanh toán cho người dùng
     * @param $data
     * @return VNPayResponse
     */
    public function parse($data)
    {
        $resp = new VNPayResponse();
        $resp->computed($data);
        return $resp;
    }
}
