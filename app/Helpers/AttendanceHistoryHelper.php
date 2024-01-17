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
            $data_format = Carbon::parse($date)->format('Y-m-d');
            $attendance_report = AttendanceReport::where('employee_id', $employee_id)
                ->where('date', $data_format)
                ->first();

            $salarySet = SalarySetHelper::getEmployeeSalarySet($employee_id);

            $employeeAttendanceDetails =  AttendanceHelper::employeeAttendanceDetails($employee_id, $data_format);
            dd($employeeAttendanceDetails);
            $is_present = $employeeAttendanceDetails['lateEarlyTimeDetails']['is_present'];
            $is_late = $employeeAttendanceDetails['lateEarlyTimeDetails']['is_late'];
            $is_early = $employeeAttendanceDetails['lateEarlyTimeDetails']['is_early'];
            $late_minutes = $employeeAttendanceDetails['lateEarlyTimeDetails']['late_minutes'];
            $early_minutes = $employeeAttendanceDetails['lateEarlyTimeDetails']['early_minutes'];
            $punch_in_time = $employeeAttendanceDetails['lateEarlyTimeDetails']['punch_in_time'];
            $punch_out_time = $employeeAttendanceDetails['lateEarlyTimeDetails']['punch_out_time'];
            $late_hour = $employeeAttendanceDetails['lateEarlyTimeDetails']['late_hour'];
            $early_hour = $employeeAttendanceDetails['lateEarlyTimeDetails']['early_hour'];

            $dayType = $employeeAttendanceDetails['day_type'];

            $normal_day_overtime_minutes = $employeeAttendanceDetails['overtimeDetails']['normal_day_overtime_minutes'];
            $normal_day_overtime_hour = $employeeAttendanceDetails['overtimeDetails']['normal_day_overtime_hour'];
            $special_day_overtime_minutes = $employeeAttendanceDetails['overtimeDetails']['special_day_overtime_minutes'];
            $special_day_overtime_hour = $employeeAttendanceDetails['overtimeDetails']['special_day_overtime_hour'];
            $total_overtime_minutes = $employeeAttendanceDetails['overtimeDetails']['total_overtime_minutes'];
            $total_overtime_hour = $employeeAttendanceDetails['overtimeDetails']['total_overtime_hour'];

            $working_minutes = $employeeAttendanceDetails['workingTimeDetails']['working_minutes'];
            $working_hour = $employeeAttendanceDetails['workingTimeDetails']['working_hour'];
            $break_minutes = $employeeAttendanceDetails['workingTimeDetails']['break_minutes'];
            $break_hour = $employeeAttendanceDetails['workingTimeDetails']['break_hour'];

            if (empty($attendance_report)){
                $attendanceReport = new AttendanceReport();
                $attendanceReport->created_at = Carbon::now();
                $attendanceReport->created_by = ($inputted_by_type !=0) ? auth()->user()->id : null;
            }
            $attendanceReport->employee_id = $employee_id;
            $attendanceReport->settings_salary_set_id = $salarySet->id;
            $attendanceReport->date = $data_format;
            $attendanceReport->time_in = $punch_in_time;
            $attendanceReport->time_out = $punch_out_time;
            $attendanceReport->time_in_status = $is_late;
            $attendanceReport->time_out_status = $is_early;
            $attendanceReport->is_present = $is_present;
            $attendanceReport->is_holiday = ;
            $attendanceReport->is_weekend = ;
            $attendanceReport->is_leave = ;
            $attendanceReport->leave_type = ;
            $attendanceReport->settings_leave_type_id = ;
            $attendanceReport->total_work_time = $working_minutes;
            $attendanceReport->total_overtime = $total_overtime_minutes;
            $attendanceReport->normal_day_overtime = $normal_day_overtime_minutes;
            $attendanceReport->special_day_overtime = $special_day_overtime_minutes;
            $attendanceReport->total_break_time = $total_overtime_minutes;
            $attendanceReport->late_time = $late_minutes;
            $attendanceReport->early_leaving_time = $early_minutes;
            $attendanceReport->inputted_by_type = $inputted_by_type;
            $attendanceReport->updated_at = Carbon::now();
            $attendanceReport->updated_by = ($inputted_by_type !=0) ? auth()->user()->id : null;

            return 'test';
        }catch (\Exception $e){
            dd($e->getMessage());
        }
    }
}
