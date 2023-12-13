<?php

namespace App\Helpers;

use Carbon\Carbon;

class DateTimeHelpers
{
    public static function getDateTimeFormat($date, $format = 'Y-m-d H:i:s')
    {
        if ($date !=''){
             Carbon::make($date)->format($format);
        }
        return $date;
    }

    public static function getDateFormat($date, $format = 'Y-m-d')
    {
        if ($date !=''){
            Carbon::make($date)->format($format);
        }
        return $date;
    }

    public static function getTimeFormat($date, $format = 'H:i:s')
    {
        if ($date !=''){
            Carbon::make($date)->format($format);
        }
        return $date;
    }

}
