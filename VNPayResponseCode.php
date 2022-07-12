<?php

/**
 * VNPayResponseCode class
 */
class VNPayResponseCode
{
    const
        SUCCESS = "00",
        SUCCESS_SUSPECT_CHEAT = "07",
        FAILURE_UNREGISTER = "09",
        FAILURE_VERIFY_CART_NOT_SUCCESS = "10",
        FAILURE_PAYMENT_EXPIRED = "11",
        FAILURE_CARD_BLOCKED = "12",
        FAILURE_INCORRECT_OTP = "13",
        FAILURE_CUSTOMER_CANCEL = "24",
        FAILURE_NOT_ENOUGH_MONEY = "51",
        FAILURE_EXCEED_THE_DAILY_TRANSACTION_LIMIT = "65",
        FAILURE_BANK_MAINTENANCE = "75",
        FAILURE_INCORRECT_PASSWORD_MANY = "79",
        UNKNOWN_ERROR = "99";

    const labels = [
        self::SUCCESS => "Giao dịch thành công.",
        self::SUCCESS_SUSPECT_CHEAT => "Trừ tiền thành công. Giao dịch bị nghi ngờ (liên quan tới lừa đảo, giao dịch bất thường).",
        self::FAILURE_UNREGISTER => "Giao dịch không thành công do: Thẻ/Tài khoản của khách hàng chưa đăng ký dịch vụ InternetBanking tại ngân hàng.",
        self::FAILURE_VERIFY_CART_NOT_SUCCESS => "Giao dịch không thành công do: Khách hàng xác thực thông tin thẻ/tài khoản không đúng quá 3 lần.",
        self::FAILURE_PAYMENT_EXPIRED => "Giao dịch không thành công do: Đã hết hạn chờ thanh toán. Xin quý khách vui lòng thực hiện lại giao dịch.",
        self::FAILURE_CARD_BLOCKED => "Giao dịch không thành công do: Thẻ/Tài khoản của khách hàng bị khóa.",
        self::FAILURE_INCORRECT_OTP => "Giao dịch không thành công do Quý khách nhập sai mật khẩu xác thực giao dịch (OTP). Xin quý khách vui lòng thực hiện lại giao dịch.",
        self::FAILURE_CUSTOMER_CANCEL => "Giao dịch không thành công do: Khách hàng hủy giao dịch.",
        self::FAILURE_NOT_ENOUGH_MONEY => "Giao dịch không thành công do: Tài khoản của quý khách không đủ số dư để thực hiện giao dịch.",
        self::FAILURE_EXCEED_THE_DAILY_TRANSACTION_LIMIT => "Giao dịch không thành công do: Tài khoản của Quý khách đã vượt quá hạn mức giao dịch trong ngày.",
        self::FAILURE_BANK_MAINTENANCE => "Ngân hàng thanh toán đang bảo trì.",
        self::FAILURE_INCORRECT_PASSWORD_MANY => "Giao dịch không thành công do: KH nhập sai mật khẩu thanh toán quá số lần quy định. Xin quý khách vui lòng thực hiện lại giao dịch.",
        self::UNKNOWN_ERROR => "Lỗi không xác định.",
    ];

    static function getStatusText($code)
    {
        return getValueByKeyFromArray(self::labels, $code);
    }
}
