<?php

namespace App\Helpers;

use Carbon\Carbon;

class SalaryGenerateDateHelper
{
    /*
     * 2024-04-26 - 2024-05-25
     * 2024-05-26 - 2024-06-25
     * */

    /*
     * 2024-04-26 -> 2024-04-26
     * 2024-04-25 -> 2024-03-26
     * 2024-04-27 -> 2024-04-26
     * 2024-04-01 -> 2024-03-26
     *
     * */

    /*
     * TODO: need to calculate month start and end date properly
     * */
    public static function monthStartDate()
    {
        $today = Carbon::now()->format('Y-m-d');
        $monthStartDate = Carbon::now()->format('Y-m-26');
        if ($today < $monthStartDate) {
            $monthStartDate = Carbon::now()->subMonth()->format('Y-m-26');
        }

        return $monthStartDate;
    }

    public static function monthEndDate()
    {
        $monthStartDate = self::monthStartDate();
        $monthEndDate = Carbon::make($monthStartDate)->addMonth()->format('Y-m-25');
        return $monthEndDate;
    }

    public static function previousMonthEndDate()
    {
        $monthStartDate = self::monthStartDate();
        $monthEndDate = Carbon::make($monthStartDate)->format('Y-m-25');
        return $monthEndDate;
    }

    public static function monthStartDateByRequest($request)
    {
        return Carbon::make($request->year.'-'.$request->month.'-26')->subMonth()->format('Y-m-d');
    }
    public static function monthEndDateByRequest($request)
    {
        return Carbon::make($request->year.'-'.$request->month.'-25')->format('Y-m-25');
    }
}
