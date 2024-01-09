<?php

namespace App\Helpers\AttendanceHelper;

use App\Models\AttendanceHistory;
use App\Models\SettingsHoliday;
use Carbon\Carbon;

class AttendanceOvertimeHelper
{
    public static function getOvertimeDetails($office_time, $attendance_activity_history, $day_type)
    {
        $overtime_minutes = self::getOvertimeMinutesFromActivity($attendance_activity_history, $office_time->end_time, $day_type);

        $normal_day_overtime_minutes = $overtime_minutes['normal_day_overtime_minutes'];
        $special_day_overtime_minutes = $overtime_minutes['special_day_overtime_minutes'];

        $normal_day_overtime_hour_string = minutesToHourString($normal_day_overtime_minutes);
        $special_day_overtime_hour_string = minutesToHourString($special_day_overtime_minutes);

        $total_overtime_minutes = $normal_day_overtime_minutes + $special_day_overtime_minutes;
        $total_overtime_hour = minutesToHourString($total_overtime_minutes);

        return [
            'normal_day_overtime_minutes' => $normal_day_overtime_minutes,
            'normal_day_overtime_hour' => $normal_day_overtime_hour_string,
            'special_day_overtime_minutes' => $special_day_overtime_minutes,
            'special_day_overtime_hour' => $special_day_overtime_hour_string,
            'total_overtime_minutes' => $total_overtime_minutes,
            'total_overtime_hour' => $total_overtime_hour,
        ];
    }

    public static function getOvertimeMinutesFromActivity($list, $min_out_time, $type='general')
    {
        $total_normal_day_overtime_minutes = 0;
        $total_special_day_overtime_minutes = 0;

        $lastInTime = null;
        if ($type == 'general') {
            foreach ($list as $data) {
                if ($data->type == AttendanceHistory::TYPE_IN) {
                    $lastInTime = Carbon::parse($data->datetime);
                    continue;
                }
                if ($lastInTime == null) {
                    continue;
                }
                if (Carbon::make($data->datetime)->format('H:i') >= Carbon::make($min_out_time)->format('H:i')) {
                    if ($lastInTime->format('H:i') < Carbon::make($min_out_time)->format('H:i')) {
                        $total_normal_day_overtime_minutes += Carbon::parse(Carbon::parse($data->datetime)->format('H:i'))->diffInMinutes(Carbon::parse($min_out_time));
                    } else {
                        $total_normal_day_overtime_minutes += Carbon::parse(Carbon::parse($data->datetime)->format('H:i'))->diffInMinutes(Carbon::parse($lastInTime->format('H:i')));
                    }
                }
            }
        } else {
            foreach ($list as $data) {
                if ($data->type == AttendanceHistory::TYPE_IN) {
                    $lastInTime = Carbon::parse($data->datetime);
                    continue;
                }
                if ($lastInTime == null) {
                    continue;
                }
                $total_special_day_overtime_minutes += Carbon::parse(Carbon::parse($data->datetime)->format('H:i'))->diffInMinutes(Carbon::parse($lastInTime->format('H:i')));
            }
        }

        return [
            'normal_day_overtime_minutes' => $total_normal_day_overtime_minutes,
            'special_day_overtime_minutes' => $total_special_day_overtime_minutes,
        ];
    }
}
