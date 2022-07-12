<?php

/**
 * VNPayRefundCode class
 */
class VNPayRefundCode
{
    const
        REFUND_GREAT_ORIGIN = "02",
        DATA_FORMAT_INVALID = "03",
        NOT_ALLOW_FULL_REFUND_AFTER_PARTIAL_REFUND = "04",
        ALLOW_PARTIAL_REFUND_ONLY = "13",
        TRANSACTION_REFUND_NOT_FOUND = "91",
        AMOUNT_REFUND_INVALID = "93",
        DUPLICATE_REQUEST_REFUND = "94",
        TRANSACTION_FAILURE_ON_VNPAY = "95",
        SIGNATURE_INVALID = "97",
        TIMEOUT_EXCEPTION = "98",
        UNKNOWN_ERROR = "99";

    const labels = [
        self::REFUND_GREAT_ORIGIN => "Tổng số tiền hoản trả lớn hơn số tiền gốc",
        self::DATA_FORMAT_INVALID => "Dữ liệu gửi sang không đúng định dạng.",
        self::NOT_ALLOW_FULL_REFUND_AFTER_PARTIAL_REFUND => "Không cho phép hoàn trả toàn phần sau khi hoàn trả một phần.",
        self::ALLOW_PARTIAL_REFUND_ONLY => "Chỉ cho phép hoàn trả một phần.",
        self::TRANSACTION_REFUND_NOT_FOUND => "Không tìm thấy giao dịch yêu cầu hoàn trả.",
        self::AMOUNT_REFUND_INVALID => "Số tiền hoàn trả không hợp lệ. Số tiền hoàn trả phải nhỏ hơn hoặc bằng số tiền thanh toán.",
        self::DUPLICATE_REQUEST_REFUND => "Yêu cầu bị trùng lặp trong thời gian giới hạn của API (Giới hạn trong 5 phút).",
        self::TRANSACTION_FAILURE_ON_VNPAY => "Giao dịch này không thành công bên VNPAY. VNPAY từ chối xử lý yêu cầu.",
        self::SIGNATURE_INVALID => "Chữ ký không hợp lệ.",
        self::TIMEOUT_EXCEPTION => "Timeout Exception.",
        self::UNKNOWN_ERROR => "Lỗi không xác định.",
    ];

    static function getStatusText($code)
    {
        return getValueByKeyFromArray(self::labels, $code);
    }
}
