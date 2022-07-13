<?php

if (!function_exists('getAmountFromVNPay')) {
    function getAmountFromVNPay($amount)
    {
        $amount = (int)$amount / 100;
        return $amount;
    }
}

if (!function_exists('setAmountToVNPay')) {
    function setAmountToVNPay($amount)
    {
        $amount = (int)$amount * 100;
        return $amount;
    }
}

if (!function_exists('getValueByKeyFromArray')) {
    function getValueByKeyFromArray($arr, $key, $default = '')
    {
        if (array_key_exists($key, $arr)) {
            return $arr[$key];
        }
        return $default;
    }
}

if (!function_exists('filterVNPayParams')) {
    function filterVNPayParams($data)
    {
        $inputData = [];
        foreach ($data as $key => $value) {
            if (substr($key, 0, 4) == 'vnp_') {
                $inputData[$key] = $value;
            }
        }
        return $inputData;
    }
}

if (!function_exists('buildHashAndQuery')) {
    function buildHashQuery($data)
    {
        ksort($data);
        return http_build_query($data);
    }
}

if (!function_exists('getIP')) {
    function getIP()
    {
        $keys = [
            'HTTP_CLIENT_IP',
            'HTTP_X_FORWARDED_FOR',
            'HTTP_X_FORWARDED',
            'HTTP_FORWARDED_FOR',
            'HTTP_FORWARDED',
            'REMOTE_ADDR',
        ];
        $ip = '127.0.0.1';
        foreach ($keys as $key):
            if (array_key_exists($_SERVER, $key)):
                $ip = $_SERVER[$key];
                break;
            endif;
        endforeach;

        return $ip;
    }
}