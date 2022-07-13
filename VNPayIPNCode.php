<?php

/**
 * VNPayIPNCode class
 */
class VNPayIPNCode
{
    const
        SUCCESS = "00",
        ORDER_NOT_FOUND = "01",
        ORDER_ALREADY_CONFIRMED = "02",
        AMOUNT_INVALID = "04",
        SIGNATURE_INVALID = "97",
        UNKNOWN_ERROR = "99";

    const labels = [
        self::SUCCESS => "Confirm Success.",
        self::ORDER_NOT_FOUND => "Order not found.",
        self::ORDER_ALREADY_CONFIRMED => "Order already confirmed.",
        self::AMOUNT_INVALID => "invalid amount.",
        self::SIGNATURE_INVALID => "Invalid signature.",
        self::UNKNOWN_ERROR => "Unknown error.",
    ];

    static function getStatusText($code)
    {
        return getValueByKeyFromArray(self::labels, $code);
    }

    static function buildResponse($code){
        return [
            'RspCode' => $code,
            'Message' => self::getStatusText($code),
        ];
    }
}
