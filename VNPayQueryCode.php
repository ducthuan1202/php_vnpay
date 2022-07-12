<?php

/**
 * VNPayQueryCode class
 */
class VNPayQueryCode
{
    const
        MERCHANT_INVALID = "02",
        DATA_FORMAT_INVALID = "03",
        TRANSACTION_NOT_FOUND = "91",
        DUPLICATE_REQUEST = "94",
        SIGNATURE_INVALID = "97",
        UNKNOWN_ERROR = "99";

    const labels = [
        self::MERCHANT_INVALID => "Merchant không hợp lệ (kiểm tra lại vnp_TmnCode)",
        self::DATA_FORMAT_INVALID => "Dữ liệu gửi sang không đúng định dạng.",
        self::TRANSACTION_NOT_FOUND => "Không tìm thấy giao dịch yêu cầu.",
        self::DUPLICATE_REQUEST => "Yêu cầu bị trùng lặp trong thời gian giới hạn của API (Giới hạn trong 5 phút).",
        self::SIGNATURE_INVALID => "Chữ ký không hợp lệ.",
        self::UNKNOWN_ERROR => "Lỗi không xác định.",
    ];

    static function getStatusText($code)
    {
        return getValueByKeyFromArray(self::labels, $code);
    }
}
