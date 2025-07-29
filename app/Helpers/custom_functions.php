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
if (!function_exists('getFormattedTime2')) {
    function getFormattedTime2($date, $format = null)
    {
        if($format == null) {
            $format = 'H:i A';
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
    function getCurrencySymbol($type = null)
    {
        if(($type == 'USD') || ($type == 'usd')) {
            return "$";
        }
        return "₱";
    }
}

if (!function_exists('minutesToHourString')) {
    function minutesToHourString($minutes)
    {
        $hour_string = '00:00';
        if ($minutes > 0) {
            $hours = floor($minutes / 60);
            $minutes = $minutes % 60;
            $hour_string = $hours . ':' .$minutes;
        }
        return $hour_string;
    }
}


if (!function_exists('hoursToMinutes')) {
    function hoursToMinutes($hour)
    {
        list($hour, $minute) = explode(':', $hour);
        $totalMinutes = (intval($hour) * 60) + intval($minute);
        return $totalMinutes;
    }
}

if (!function_exists('getExactFilePath')) {
    function getExactFilePath($path)
    {
        if($path == '') {
            return '';
        }
        $path = substr($path, 8);
        return storage_path('app/public/'.$path);
    }
}

function ____($string)
{
    return strlen($string);
}

if (!function_exists('formatNumber')) {
    function formatNumber($number) {
        if (is_nan($number) || $number == 0) {
            return '0';
        }

        $formatted = number_format($number, 6, '.', '');

        $formatted = rtrim(rtrim($formatted, '0'), '.');

        if (strpos($formatted, '.') !== false) {
            $parts = explode('.', $formatted);
            if (strlen($parts[1]) === 1) {
                $formatted .= '0';
            }
        } 
        else {
            $formatted .= '.00';
        }

        return $formatted;
    }
}

if (!function_exists('strToClassName')) {
    function strToClassName($string) {
        return str_replace(' ', '-', strtolower($string));
    }
}

if (!function_exists('showDateFormat')) {
    function showDateFormat($date, $format='M d, Y', $default='') {
        if ($date != '') {
            $user_timezone = config('app.user_timezone');
            $date = Carbon::parse($date)->timezone($user_timezone)->format($format);
        } else {
            $date = $default;
        }
        return $date;
    }
}







