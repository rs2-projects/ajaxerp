<?php

namespace App\Helpers;

use App\Models\AttendanceHistory;
use App\Models\AttendanceReport;
use App\Models\SettingsHoliday;
use Carbon\Carbon;

class AttendanceHistoryHelper
{
    public static function attendanceReportCreateOrUpdate($employee_id, $date, $inputted_by_type)
    {
        try{
            $date_format = Carbon::parse($date)->format('Y-m-d');

            $attendanceReport = AttendanceReport::where('employee_id', $employee_id)
                ->where('date', $date_format)
                ->first();

            if (empty($attendanceReport)){
                $attendanceReport = new AttendanceReport();
                $attendanceReport->created_at = Carbon::now();
                $attendanceReport->created_by = ($inputted_by_type != AttendanceReport::INPUTTED_BY_TYPE_CRON) ? auth()->user()->id : null;
                $attendanceReport->inputted_by_type = $inputted_by_type;
            }

            $salarySet = SalarySetHelper::getEmployeeSalarySet($employee_id, $date_format);

            $employeeAttendanceDetails =  AttendanceHelper::employeeAttendanceDetails($employee_id, $date_format, $salarySet);

            $is_present = $employeeAttendanceDetails['lateEarlyTimeDetails']['is_present'];
            $is_late = $employeeAttendanceDetails['lateEarlyTimeDetails']['is_late'];
            $is_early = $employeeAttendanceDetails['lateEarlyTimeDetails']['is_early'];
            $punch_in_time = $employeeAttendanceDetails['lateEarlyTimeDetails']['punch_in_time'];
            $punch_out_time = $employeeAttendanceDetails['lateEarlyTimeDetails']['punch_out_time'];
            $late_hour = $employeeAttendanceDetails['lateEarlyTimeDetails']['late_hour'];
            $early_hour = $employeeAttendanceDetails['lateEarlyTimeDetails']['early_hour'];
            $dayType = $employeeAttendanceDetails['day_type'];
            $normal_day_overtime_hour = $employeeAttendanceDetails['overtimeDetails']['normal_day_overtime_hour'];
            $special_day_overtime_hour = $employeeAttendanceDetails['overtimeDetails']['special_day_overtime_hour'];
            $total_overtime_hour = $employeeAttendanceDetails['overtimeDetails']['total_overtime_hour'];
            $working_hour = $employeeAttendanceDetails['workingTimeDetails']['working_hour'];
            $break_hour = $employeeAttendanceDetails['workingTimeDetails']['break_hour'];
            $userLeaveDetails = $employeeAttendanceDetails['userLeaveDetails'];
            if(empty($userLeaveDetails)){
                $is_leave = AttendanceReport::IS_LEAVE_NOT_LEAVE;
                $leave_type = AttendanceReport::LEAVE_TYPE_NOT_SET;
                $settings_leave_type_id = null;
            }else{
                $is_leave = AttendanceReport::IS_LEAVE_LEAVE;
                $leave_type = ($userLeaveDetails['is_paid'] == 1) ? AttendanceReport::LEAVE_TYPE_PAID : AttendanceReport::LEAVE_TYPE_UNPAID;
                $settings_leave_type_id = $userLeaveDetails['settings_leave_type_id'];
            }

            if ($punch_in_time == null){
                $time_in_status = AttendanceReport::TIME_IN_STATUS_NOT_SET;
            }else{
                $time_in_status = ($is_late == true) ? AttendanceReport::TIME_IN_STATUS_LATE : AttendanceReport::TIME_IN_STATUS_ON_TIME;
            }

            if ($punch_out_time == null){
                $time_out_status = AttendanceReport::TIME_OUT_STATUS_NOT_SET;
            }else{
                $time_out_status = ($is_early == true) ? AttendanceReport::TIME_OUT_STATUS_EARLY : AttendanceReport::TIME_OUT_STATUS_ON_TIME;
            }

            $attendanceReport->employee_id = $employee_id;
            $attendanceReport->settings_salary_set_id = $salarySet->id;
            $attendanceReport->date = $date_format;
            $attendanceReport->time_in = $punch_in_time;
            $attendanceReport->time_out = $punch_out_time;
            $attendanceReport->time_in_status = $time_in_status;
            $attendanceReport->time_out_status = $time_out_status;
            $attendanceReport->is_present = $is_present;
            $attendanceReport->is_holiday = ($dayType == 'holiday') ? AttendanceReport::IS_HOLIDAY_HOLIDAY : AttendanceReport::IS_HOLIDAY_NOT_HOLIDAY;
            $attendanceReport->is_weekend = ($dayType == 'weekend') ? AttendanceReport::IS_WEEKEND_WEEKEND : AttendanceReport::IS_WEEKEND_NOT_WEEKEND;
            $attendanceReport->is_leave = $is_leave;
            $attendanceReport->leave_type = $leave_type;
            $attendanceReport->settings_leave_type_id = $settings_leave_type_id;
            $attendanceReport->total_work_time = $working_hour;
            $attendanceReport->total_overtime = $total_overtime_hour;
            $attendanceReport->normal_day_overtime = $normal_day_overtime_hour;
            $attendanceReport->special_day_overtime = $special_day_overtime_hour;
            $attendanceReport->total_break_time = $break_hour;
            $attendanceReport->late_time = $late_hour;
            $attendanceReport->early_leaving_time = $early_hour;
            $attendanceReport->updated_at = Carbon::now();
            $attendanceReport->updated_by = ($inputted_by_type != AttendanceReport::INPUTTED_BY_TYPE_CRON) ? auth()->user()->id : null;
            $attendanceReport->save();

            return $attendanceReport;
        }catch (\Exception $e){
            throw $e;
        }
    }
}
