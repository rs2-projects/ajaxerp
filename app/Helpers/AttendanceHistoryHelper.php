<?php

namespace App\Helpers;

use App\Models\AttendanceReport;
use App\Models\SettingsHoliday;

class AttendanceHistoryHelper
{
    public static function attendanceReportCreateOrUpdate($employee_id, $date)
    {
        $checkAttendanceReport = AttendanceReport::where('employee_id', $employee_id)
            ->where('date', $date)
            ->first();



        return 'test';
    }
}
