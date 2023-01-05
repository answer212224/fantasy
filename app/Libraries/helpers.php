<?php
if (!function_exists('getIp')) {
    function getIp()
    {
        if (!empty($_SERVER['HTTP_AKACIP'])) {
            $IP = $_SERVER['HTTP_AKACIP'];
        } else if (!empty($_SERVER['HTTP_L7CIP'])) {
            $IP = $_SERVER['HTTP_L7CIP'];
        } else if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $IP = $_SERVER['HTTP_CLIENT_IP'];
        } else if (!empty($_SERVER['REMOTE_ADDR'])) {
            $IP = $_SERVER['REMOTE_ADDR'];
        } else {
            $IP = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        return $IP;
    }
}
