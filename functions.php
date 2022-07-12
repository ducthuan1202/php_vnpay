<?php

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
    function buildHashAndQuery($data)
    {
        ksort($data);
        $query = '';
        $hash = '';
        $i = 0;
        foreach ($data as $key => $value) {
            if ($i === 1) {
                $hash .= '&' . urlencode($key) . '=' . urlencode($value);
            } else {
                $hash .= urlencode($key) . '=' . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . '=' . urlencode($value) . '&';
        }
        return [$hash, $query];
    }
}
