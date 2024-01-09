<?php

namespace App\Helpers\AttendanceHelper;

class AttendanceLateEarlyHelper
{
    public static function getLateEarlyDetails($office_time, $attendance_activity_history, $day_type)
    {
        $late_early_minutes = self::getLateEarlyMinutesFromActivity($office_time, $attendance_activity_history, $day_type);

        $late_early_hour_string = minutesToHourString($late_early_minutes);

        return [
            'minutes' => $late_early_minutes,
            'hour' => $late_early_hour_string
        ];
    }

    public static function getLateEarlyMinutesFromActivity($office_time, $attendance_activity_history, $day_type) {
        $total_late_minutes = 0;
        $total_early_minutes = 0;

        // $attendance_activity_history get first in and last out
        $first_in = null;
        $last_out = null;

        foreach ($attendance_activity_history as $data) {
            if ($data->type == $data::TYPE_IN) {
                if ($first_in == null) {
                    $first_in = $data;
                } else {
                    if (Carbon::parse($data->datetime)->format('H:i') < Carbon::parse($first_in->datetime)->format('H:i')) {
                        $first_in = $data;
                    }
                }
            } elseif ($data->type == $data::TYPE_OUT) {
                if ($last_out == null) {
                    $last_out = $data;
                } else {
                    if (Carbon::parse($data->datetime)->format('H:i') > Carbon::parse($last_out->datetime)->format('H:i')) {
                        $last_out = $data;
                    }
                }
            }
        }

        if ($first_in != null && $last_out != null) {
            if ($day_type == 'general') {
                if (Carbon::parse($first_in->datetime)->format('H:i') > Carbon::parse($office_time->start_time)->format('H:i')) {
                    $total_late_minutes += Carbon::parse(Carbon::parse($first_in->datetime)->format('H:i'))->diffInMinutes(Carbon::parse($office_time->start_time));
                }
                if (Carbon::parse($last_out->datetime)->format('H:i') < Carbon::parse($office_time->end_time)->format('H:i')) {
                    $total_early_minutes += Carbon::parse(Carbon::parse($office_time->end_time)->format('H:i'))->diffInMinutes(Carbon::parse($last_out->datetime));
                }
            } else {
                if (Carbon::parse($first_in->datetime)->format('H:i') > Carbon::parse($office_time->start_time)->format('H:i')) {
                    $total_late_minutes += Carbon::parse(Carbon::parse($first_in->datetime)->format('H:i'))->diffInMinutes(Carbon::parse($office_time->start_time));
                }
                if (Carbon::parse($last_out->datetime)->format('H:i') < Carbon::parse($office_time->end_time)->format('H:i')) {
                    $total_early_minutes += Carbon::parse(Carbon::parse($office_time->end_time)->format('H:i'))->diffInMinutes(Carbon::parse($last_out->datetime));
                }
            }
        }


    }
}
