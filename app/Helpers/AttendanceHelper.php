<?php

namespace App\Helpers;

use App\Helpers\AttendanceHelper\AttendanceLateEarlyHelper;
use App\Helpers\AttendanceHelper\AttendanceLeaveHelper;
use App\Helpers\AttendanceHelper\AttendanceOvertimeHelper;
use App\Helpers\AttendanceHelper\AttendanceWorkingTimeHelper;
use App\Models\AttendanceHistory;
use App\Models\AttendanceReport;
use App\Models\SettingsHoliday;
use App\Models\SettingsOfficeTime;
use App\Models\SettingsOfficeTimeType;
use App\Models\SettingsSalarySet;
use App\Models\SettingsSalarySetEmployee;
use App\Models\User;
use App\Models\UserLeave;
use App\Models\UserLeaveDetail;
use Carbon\Carbon;

class AttendanceHelper
{
    public static function employeeAttendanceDetails($employee_id, $date):array
    {
        $employee = User::where('id', $employee_id)
            ->where('status', User::STATUS_ACTIVE)
            ->where('deleted', User::DELETED_NO)
            ->first();
        $day = strtolower(Carbon::make($date)->format('l'));
        $salary_set_employee = SettingsSalarySetEmployee::where('employee_id', $employee_id)
            ->where('status', SettingsSalarySetEmployee::STATUS_ACTIVE)
            ->where('deleted', SettingsSalarySetEmployee::DELETED_NO)
            ->first();
        $salary_set = SettingsSalarySet::where('id', $salary_set_employee->settings_salary_set_id)
            ->where('status', SettingsSalarySet::STATUS_ACTIVE)
            ->where('deleted', SettingsSalarySet::DELETED_NO)
            ->first();
        $office_time_type = SettingsOfficeTimeType::with('officeTimes')
            ->where('id', $salary_set->settings_office_time_type_id)
            ->where('status', SettingsOfficeTimeType::STATUS_ACTIVE)
            ->where('deleted', SettingsOfficeTimeType::DELETED_NO)
            ->first();

        $office_time = SettingsOfficeTime::where('office_time_type_id', $office_time_type->id)
            ->where('day', $day)
            ->first();

        $attendance_activity_history = AttendanceHistory::where('employee_id', $employee_id)
            ->whereDate('datetime', $date)
            ->get();

        //check if the day is holiday
        $isHoliday = SettingsHoliday::where('deleted', SettingsHoliday::DELETED_NO)
            ->where('start_date', '>=', $date)
            ->where('end_date', '<=', $date)
            ->where('status', SettingsHoliday::STATUS_ACTIVE)
            ->first();

        if ($office_time->is_weekend == $office_time::IS_WEEKEND_YES) {
            $day_type = 'weekend';
        } elseif (!empty($isHoliday)) {
            $day_type = 'holiday';
        } else {
            $day_type = 'general';
        }

        $leaveDetails = UserLeave::where('user_id', $employee_id)
            ->where('status', UserLeave::STATUS_ACTIVE)
            ->where('deleted', UserLeave::DELETED_NO)
            ->where('leave_status', UserLeave::LEAVE_STATUS_APPROVED)
            ->where('approve_start_date', '<=', $date)
            ->where('approve_start_date', '>=', $date)
            ->first();

        $userLeaveDetails = UserLeaveDetail::where('user_id', $employee_id)
            ->where('status', UserLeaveDetail::STATUS_ACTIVE)
            ->where('deleted', UserLeaveDetail::DELETED_NO)
            ->where('leave_status', UserLeaveDetail::LEAVE_STATUS_APPROVED)
            ->where('date', $date)
            ->orderBy('id', 'desc')
            ->first();

        //check and get total overtime
        $overtimeDetails = AttendanceOvertimeHelper::getOvertimeDetails($office_time, $attendance_activity_history, $day_type);

        //check and get total working time
        $workingTimeDetails = AttendanceWorkingTimeHelper::getWorkingTimeDetails($attendance_activity_history);

        //check and get late time
        $lateEarlyTimeDetails = AttendanceLateEarlyHelper::getLateEarlyDetails($office_time, $attendance_activity_history, $day_type);



        return [
            'employee' => $employee,
            'office_time' => $office_time,
            'attendance_activity_history' => $attendance_activity_history,
            'day_type' => $day_type,
            'leaveDetails' => $leaveDetails,
            'userLeaveDetails' => $userLeaveDetails,
            'overtimeDetails' => $overtimeDetails,
            'workingTimeDetails' => $workingTimeDetails,
            'lateEarlyTimeDetails' => $lateEarlyTimeDetails,
        ];
        //return total history


//        dd('EOF');
    }

    public static function getAllDatesBetweenTowDates($start_date, $end_date)
    {
        $startDate = new Carbon($start_date);
        $endDate = new Carbon($end_date);

        $all_dates = array();
        while ($startDate->lte($endDate)){
            $all_dates[] = $startDate->toDateString();
            $startDate->addDay();
        }
        return $all_dates;
    }

    public static function getAttendanceReport($employee_id, $date)
    {

        $attendance_report = AttendanceReport::where('status', AttendanceReport::STATUS_ACTIVE)
            ->where('deleted', AttendanceReport::DELETED_NO)
            ->where('employee_id', $employee_id)
            ->where('date', $date)
            ->first();

        $day = strtolower(Carbon::make($date)->format('l'));
        $salary_set_employee = SettingsSalarySetEmployee::where('employee_id', $employee_id)
            ->where('status', SettingsSalarySetEmployee::STATUS_ACTIVE)
            ->where('deleted', SettingsSalarySetEmployee::DELETED_NO)
            ->first();
        if (empty($salary_set_employee)){
             $show_status = 'absent';
             $icon_status = '<i class="fa fa-close text-white"></i>';

             return  [
                    'show_status' => $show_status,
                    'icon_status' => $icon_status,
            ];
        }
        $salary_set = SettingsSalarySet::where('id', $salary_set_employee->settings_salary_set_id)
            ->where('status', SettingsSalarySet::STATUS_ACTIVE)
            ->where('deleted', SettingsSalarySet::DELETED_NO)
            ->first();
        if (empty($salary_set)){
            $show_status = 'absent';
            $icon_status = '<i class="fa fa-close text-white"></i>';

            return  [
                'show_status' => $show_status,
                'icon_status' => $icon_status,
            ];
        }
        $office_time_type = SettingsOfficeTimeType::with('officeTimes')
            ->where('id', $salary_set->settings_office_time_type_id)
            ->where('status', SettingsOfficeTimeType::STATUS_ACTIVE)
            ->where('deleted', SettingsOfficeTimeType::DELETED_NO)
            ->first();
        if (empty($office_time_type)){
            $show_status = 'absent';
            $icon_status = '<i class="fa fa-close text-white"></i>';

            return  [
                'show_status' => $show_status,
                'icon_status' => $icon_status,
            ];
        }
        $office_time = SettingsOfficeTime::where('office_time_type_id', $office_time_type->id)
            ->where('day', $day)
            ->first();
        if (empty($office_time)){
            $show_status = 'absent';
            $icon_status = '<i class="fa fa-close text-white"></i>';

            return  [
                'show_status' => $show_status,
                'icon_status' => $icon_status,
            ];
        }

        //check if the day is holiday
        $isHoliday = SettingsHoliday::where('deleted', SettingsHoliday::DELETED_NO)
            ->where('start_date', '>=', $date)
            ->where('end_date', '<=', $date)
            ->where('status', SettingsHoliday::STATUS_ACTIVE)
            ->first();



        $userLeaveDetails = UserLeaveDetail::where('user_id', $employee_id)
            ->where('status', UserLeaveDetail::STATUS_ACTIVE)
            ->where('deleted', UserLeaveDetail::DELETED_NO)
            ->where('leave_status', UserLeaveDetail::LEAVE_STATUS_APPROVED)
            ->where('date', $date)
            ->orderBy('id', 'desc')
            ->first();

        $show_status = 'absent';
        $icon_status = '<i class="fa fa-close text-white"></i>';

        if (!empty($attendance_report)){

             if ($attendance_report->is_holiday == 1){
                 $show_status = 'holiday';
                 $icon_status = '<span class="attd-badge">H</span>';
                }elseif ($attendance_report->is_weekend == 1){
                    $show_status = 'weekend';
                    $icon_status = '<i class="fa fa-check "></i>';
                }elseif ($attendance_report->is_leave == 1){
                    $show_status = 'leave';
                    $icon_status = '<span class="attd-badge">L</span>';
                }elseif ($attendance_report->is_present == 1) {
                 $show_status = 'present';
                 $icon_status = '<i class="fa fa-check text-white"></i>';
                 if ($attendance_report->time_in_status == 1 && $attendance_report->time_out_status == 1) {
                     $show_status = 'intime';
                     $icon_status = '<i class="fa fa-check text-white"></i>';
                 }else{
                     $show_status = 'due-time';
                     $icon_status = '<i class="fa fa-check text-white"></i>';
                 }
             }else{
                    $show_status = 'absent';
                    $icon_status = '<i class="fa fa-close text-white"></i>';
             }

        }else{

            if ($office_time->is_weekend == $office_time::IS_WEEKEND_YES) {
                $show_status = 'weekend';
                $icon_status = '<i class="fa fa-check "></i>';
            } elseif (!empty($isHoliday)) {
                $show_status = 'holiday';
                $icon_status = '<span class="attd-badge">H</span>';
            } else {
                if (!empty($userLeaveDetails)){
                    $show_status = 'leave';
                    $icon_status = '<span class="attd-badge">L</span>';
                }else{
                    $show_status = 'absent';
                    $icon_status = '<i class="fa fa-close text-white"></i>';
                }
            }

        }



        return [
            'show_status' => $show_status,
            'icon_status' => $icon_status,
        ];
    }

}
