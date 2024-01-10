<?php

namespace App\Helpers;

use App\Models\SettingsHoliday;
use App\Models\SettingsLeaveType;
use App\Models\SettingsOfficeTime;
use App\Models\UserLeave;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class LeaveHelper
{
    public static function holidayCount($start_date, $end_date)
    {
        $start_date = Carbon::make($start_date);
        $end_date = Carbon::make($end_date);
        $holidayCount = 0;

        while ($start_date->lte($end_date)) {
            if (self::checkDateIsHoliday($start_date->format('Y-m-d'))) {
                $holidayCount++;
            }
            $start_date->addDay();
        }

        return $holidayCount;
    }

    public static function checkDateIsHoliday($date)
    {
        $isHoliday = SettingsHoliday::where('deleted', SettingsHoliday::DELETED_NO)
            ->where('start_date', '>=', $date)
            ->where('end_date', '<=', $date)
            ->where('status', SettingsHoliday::STATUS_ACTIVE)
            ->first();

        if (!empty($isHoliday)) {
            return true;
        }
        return false;
    }

    public static function countEmployeeWeekendDays($employee_id, $start_date, $end_date)
    {
        $start_date = Carbon::make($start_date);
        $end_date = Carbon::make($end_date);
        $weekendCount = 0;

        $salary_set = SalarySetHelper::getEmployeeSalarySet($employee_id);

        while ($start_date->lte($end_date)) {
            if (self::checkDateIsWeekend($salary_set->settings_office_time_type_id, $start_date->format('Y-m-d'))) {
                $weekendCount++;
            }
            $start_date->addDay();
        }

        return $weekendCount;
    }

    public static function checkDateIsWeekend($office_time_type_id, $date)
    {
        $day = strtolower(Carbon::make($date)->format('l'));

        $office_time = SettingsOfficeTime::where('office_time_type_id', $office_time_type_id)
            ->where('day', $day)
            ->first();
        if ($office_time->is_weekend == $office_time::IS_WEEKEND_YES) {
            return true;
        }
        return false;
    }


    public static function countEmployeeGeneralDays($employee_id, $start_date, $end_date)
    {
        $start_date = Carbon::make($start_date);
        $end_date = Carbon::make($end_date);
        $generalCount = 0;

        $salary_set = SalarySetHelper::getEmployeeSalarySet($employee_id);

        while ($start_date->lte($end_date)) {
            /*Log::info($start_date->format('Y-m-d'));*/
            if (!self::checkDateIsHoliday($start_date->format('Y-m-d')) && !self::checkDateIsWeekend($salary_set->settings_office_time_type_id, $start_date->format('Y-m-d'))) {
                $generalCount++;
            }
            $start_date->addDay();
        }

        return $generalCount;
    }

    public static function countPaidLeave($employee_id, $leave_type_id, $start_date, $end_date)
    {
        $start_date = Carbon::make($start_date);
        $end_date = Carbon::make($end_date);
        $paidLeaveCount = 0;

        $leave_type = self::leaveType($leave_type_id);
        $monthly_max_leave = $leave_type->max_leave_per_month;
        $have_paid_leave = $leave_type->annual_leave_days - self::countEmployeeUsedLeave($employee_id, $leave_type_id, $start_date, $end_date);


    }

    public static function countEmployeeUsedLeave($employee_id, $leave_type_id, $start_date, $end_date)
    {
        $start_date = Carbon::make($start_date)->startOfYear();
        $end_date = Carbon::make($start_date)->endOfYear();

        $userUsedLeaves = UserLeave::where('user_id', $employee_id)
            ->where('settings_leave_type_id', $leave_type_id)
            ->where('status', UserLeave::STATUS_ACTIVE)
            ->where('deleted', UserLeave::DELETED_NO)
            ->whereIn('leave_status', [UserLeave::LEAVE_STATUS_APPROVED, UserLeave::LEAVE_STATUS_PENDING])
            ->whereDate('approve_start_date', '>=', $start_date)
            ->whereDate('approve_end_date', '<=', $end_date)
            ->sum('paid_leave_number_of_days');

        return $userUsedLeaves;
    }
    public static function countEmployeeUsedLeaveMonth($employee_id, $leave_type_id, $start_date, $end_date)
    {
        $start_date = Carbon::make($start_date)->startOfMonth();
        $end_date = Carbon::make($start_date)->endOfMonth();

        $userUsedLeaves = UserLeave::where('user_id', $employee_id)
            ->where('settings_leave_type_id', $leave_type_id)
            ->where('status', UserLeave::STATUS_ACTIVE)
            ->where('deleted', UserLeave::DELETED_NO)
            ->whereIn('leave_status', [UserLeave::LEAVE_STATUS_APPROVED, UserLeave::LEAVE_STATUS_PENDING])
            ->whereDate('approve_start_date', '>=', $start_date)
            ->whereDate('approve_end_date', '<=', $end_date)
            ->sum('paid_leave_number_of_days');

        return $userUsedLeaves;
    }

    public static function leaveType($leave_type_id)
    {
        $leave_type = SettingsLeaveType::where('id', $leave_type_id)
            ->where('status', SettingsLeaveType::STATUS_ACTIVE)
            ->where('deleted', SettingsLeaveType::DELETED_NO)
            ->first();

        return $leave_type;

    }
}
