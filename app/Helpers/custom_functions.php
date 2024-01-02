<?php

use Carbon\Carbon;

if (!function_exists('getFormattedDate')) {
    function getFormattedDate($date, $format = null)
    {
        if($format == null) {
            $format = 'Y-m-d';
        }
        if ($date !=''){
            return Carbon::make($date)->format($format);
        }
        return $date;
    }
}

// get time format

if (!function_exists('getFormattedTime')) {
    function getFormattedTime($date, $format = null)
    {
        if($format == null) {
            $format = 'H:i:s';
        }
        if ($date !=''){
            return Carbon::make($date)->format($format);
        }
        return $date;
    }
}

// get date time format

if (!function_exists('getFormattedDateTime')) {
    function getFormattedDateTime($date, $format = null)
    {
        if($format == null) {
            $format = 'Y-m-d H:i:s';
        }
        if ($date !=''){
            return Carbon::make($date)->format($format);
        }
        return $date;
    }
}

// description character limit

if (!function_exists('getSubStr')) {
    function getSubStr($description, $limit = 100, $extra = '...')
    {
        if (strlen($description) > $limit) {
            return substr($description, 0, $limit) . $extra;
        }
        return $description;
    }
}

//get real string substr with remove html tags
if (!function_exists('getRealSubStr')) {
    function getRealSubStr($description, $limit = 100, $extra = '...')
    {
        $description = strip_tags($description);
        return getSubStr($description, $limit, $extra);
    }
}

// show amount
if (!function_exists('showAmount')) {
    function showAmount($amount, $decimal = 2)
    {
        return number_format($amount, $decimal);
    }
}

// get currency symbol
if (!function_exists('getCurrencySymbol')) {
    function getCurrencySymbol()
    {
        return "₱";
    }
}

if (!function_exists('hasUserPermission')) {
    function hasUserPermission(...$permissions)
    {
        return in_array(auth()->user()->type, $permissions);
    }
}
