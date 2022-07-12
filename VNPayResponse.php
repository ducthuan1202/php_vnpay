<?php

/**
 * VNPayResponse class
 * Một số tên biến đặt không theo quy tắc do sử dụng lại code demo của VNPay
 * trách ai bây giờ :))
 */
class VNPayResponse
{

    private $response = [];
    private $valid = false;
    private $success = false;

    public function computed($data)
    {

        $vnp_SecureHash = getValueByKeyFromArray($data, 'vnp_SecureHash');
        $inputData = filterVNPayParams($data);
        unset($inputData['vnp_SecureHash']);

        $data = buildHashAndQuery($inputData);
        $hashData = $data[0];
        $secureHash = hash_hmac(VNPAY_ALGORITHM, $hashData, VNPAY_SECRET_KEY);

        $this->success = getValueByKeyFromArray($inputData, 'vnp_ResponseCode') === VNPayResponseCode::SUCCESS;
        $this->valid = $secureHash === $vnp_SecureHash;
        $this->response = $inputData;
    }

    public function isValid()
    {
        return $this->valid;
    }

    public function isSuccess()
    {
        return $this->success;
    }

    public function getAmount()
    {
        $amount = getValueByKeyFromArray($this->response, 'vnp_Amount', 0);
        return (int)$amount / 100;
    }

    public function getBankCode()
    {
        return getValueByKeyFromArray($this->response, 'vnp_BankCode', '');
    }

    public function getBankTransactionNumber()
    {
        return getValueByKeyFromArray($this->response, 'vnp_BankTranNo', '');
    }

    public function getTransactionNumber()
    {
        return getValueByKeyFromArray($this->response, 'vnp_TransactionNo', '');
    }

    public function getCartType()
    {
        return getValueByKeyFromArray($this->response, 'vnp_CardType', '');
    }

    public function getTransactionStatus()
    {
        return getValueByKeyFromArray($this->response, 'vnp_ResponseCode', '');
    }

    public function getTransactionStatusText()
    {
        return VNPayResponseCode::getStatusText($this->getTransactionStatus());
    }

    public function getStatusCode()
    {
        return getValueByKeyFromArray($this->response, 'vnp_ResponseCode', '');
    }

    public function getOrderID()
    {
        return getValueByKeyFromArray($this->response, 'vnp_TxnRef', '');
    }

    public function getOrderInfo()
    {
        return getValueByKeyFromArray($this->response, 'vnp_OrderInfo', '');
    }

    public function getTmnCode()
    {
        return getValueByKeyFromArray($this->response, 'vnp_TmnCode', '');
    }

    public function getPayDate()
    {
        return getValueByKeyFromArray($this->response, 'vnp_PayDate', '');
    }
}
