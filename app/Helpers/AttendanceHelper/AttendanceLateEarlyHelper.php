<?php

namespace App\Helpers\AttendanceHelper;

use App\Models\AttendanceHistory;
use Carbon\Carbon;

class AttendanceLateEarlyHelper
{
    public static function getLateEarlyDetails($office_time, $attendance_activity_history, $day_type)
    {
        $late_early_minutes = self::getLateEarlyMinutesFromActivity($office_time, $attendance_activity_history, $day_type);

        $late_early_minutes['late_hour'] = minutesToHourString($late_early_minutes['late_minutes']);
        $late_early_minutes['early_hour'] = minutesToHourString($late_early_minutes['early_minutes']);

        return $late_early_minutes;
    }

    public static function getLateEarlyMinutesFromActivity($office_time, $attendance_activity_history, $day_type) {
        $is_present = false;
        $is_late = true;
        $is_early = true;
        $total_late_minutes = 0;
        $total_early_minutes = 0;
        $punch_in_time = null;
        $punch_out_time = null;

        if ($day_type == 'general') {
            $first_in = $attendance_activity_history->where('type', AttendanceHistory::TYPE_IN)->first();
            $last_out = $attendance_activity_history->where('type', AttendanceHistory::TYPE_OUT)->last();
            if (!empty($first_in)) {
                $is_present = true;
                $punch_in_time = $first_in->datetime;
                if (Carbon::parse($first_in->datetime)->format('H:i') > Carbon::parse($office_time->start_time)->format('H:i')) {
                    $total_late_minutes += Carbon::parse(Carbon::parse($first_in->datetime)->format('H:i'))->diffInMinutes(Carbon::parse(Carbon::parse($office_time->start_time)->format('H:i')));
                    $is_late = true;
                } else {
                    $is_late = false;
                }

                if (!empty($last_out)) {
                    $punch_out_time = $last_out->datetime;
                    if (Carbon::parse($last_out->datetime)->format('H:i') < Carbon::parse($office_time->end_time)->format('H:i')) {
                        $total_early_minutes += Carbon::parse(Carbon::parse($office_time->end_time)->format('H:i'))->diffInMinutes(Carbon::parse(Carbon::parse($last_out->datetime)->format('H:i')));
                        $is_early = true;
                    } else {
                        $is_early = false;
                    }
                } else{
                    $is_early = true;
                }
            }
        }


        return [
            'is_present' => $is_present,
            'is_late' => $is_late,
            'is_early' => $is_early,
            'late_minutes' => $total_late_minutes,
            'early_minutes' => $total_early_minutes,
            'punch_in_time' => $punch_in_time,
            'punch_out_time' => $punch_out_time,
        ];

    }

    public static function getLateEarlyMinutesFromActivity1($office_time, $attendance_activity_history, $day_type) {
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

        return [
            'late_minutes' => $total_late_minutes,
            'early_minutes' => $total_early_minutes,
        ];

    }
}
