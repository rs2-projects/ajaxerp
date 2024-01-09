<?php

namespace App\Helpers\AttendanceHelper;

use Carbon\Carbon;

class AttendanceWorkingTimeHelper
{
    public static function getWorkingTimeDetails($attendance_activity_history)
    {
        $total_working_break_minutes = self::getWorkingTimeMinutes($attendance_activity_history);

        $total_working_minutes = $total_working_break_minutes['working_minutes'];
        $total_break_minutes = $total_working_break_minutes['break_minutes'];

        $total_working_hour_string = minutesToHourString($total_working_minutes);
        $total_break_hour_string = minutesToHourString($total_break_minutes);

        return [
            'working_minutes' => $total_working_minutes,
            'working_hour' => $total_working_hour_string,
            'break_minutes' => $total_break_minutes,
            'break_hour' => $total_break_hour_string,
        ];
    }

    public static function getWorkingTimeMinutes($attendance_activity_history)
    {
        $total_working_minutes = 0;
        $total_break_minutes = 0;

        $lastInTime = null;
        $lastOutTime = null;

        foreach ($attendance_activity_history as $data) {

            if ($data->type == $data::TYPE_IN) {
                $lastInTime = Carbon::parse($data->datetime);
                if ($lastOutTime != null) {
                    $total_break_minutes += Carbon::parse(Carbon::parse($data->datetime)->format('H:i'))->diffInMinutes(Carbon::parse($lastOutTime->format('H:i')));
                }
            } elseif ($data->type == $data::TYPE_OUT) {
                $lastOutTime = Carbon::parse($data->datetime);
                if ($lastInTime != null){
                    $total_working_minutes += Carbon::parse(Carbon::parse($data->datetime)->format('H:i'))->diffInMinutes(Carbon::parse($lastInTime->format('H:i')));
                }
            }
        }

        return [
            'working_minutes' => $total_working_minutes,
            'break_minutes' => $total_break_minutes,
        ];
    }
}
