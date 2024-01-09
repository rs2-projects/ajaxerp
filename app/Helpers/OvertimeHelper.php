<?php

namespace App\Helpers;


use App\Models\AttendanceHistory;
use App\Models\SettingsHoliday;
use App\Models\SettingsOfficeTime;
use App\Models\SettingsOfficeTimeType;
use App\Models\SettingsSalarySet;
use App\Models\SettingsSalarySetEmployee;
use Carbon\Carbon;

class OvertimeHelper
{
    public static function getOvertime($employee_id, $date)
    {
        $overtime = self::getOvertimeMinutes($employee_id, $date);
        $details['status'] = $overtime['status'];
        if ($overtime['overtime'] > 0) {
            $hours = floor($overtime['overtime'] / 60);
            $minutes = $overtime['overtime'] % 60;
            $details['overtime'] = $hours . ':' .$minutes;
        } else {
            $details['overtime'] = 0;
        }

        return $details;
    }

    public static function getCompanyOvertime($company_id, $start_date, $end_date)
    {
        $startDate = new Carbon($start_date);
        $endDate = new Carbon($end_date);

        $total_overtime_min = 0;
        $employee_data = array();
        $overtime_employee = array();
        while ($startDate->lte($endDate)){

            $employees = Employee::where('company_id', $company_id)
                ->where('status', 1)
                ->where('resigned', 0)
                ->where('terminated', 0)
                ->where('deleted', 0)
                ->get();

            if (!empty($employees)) {
                foreach ($employees as $employee) {
                    $overtime_data = self::getOvertimeMinutes($company_id,$employee->id,$startDate->format('Y-m-d'));
                    $total_overtime_min += $overtime_data['overtime'];
                    if (!isset($employee_data[$employee->id])) {
                        $employee_data[$employee->id] = 0;
                    }
                    $employee_data[$employee->id] += $overtime_data['overtime'];
                    if ($overtime_data['overtime'] > 0) {
                        $overtime_employee[] = $employee->id;
                    }
                }
            }
            $startDate->addDay();
        }

        $employee_data = array_flip($employee_data);
        krsort($employee_data);
        $employee_data = array_slice($employee_data,0,5);
        $overtime_employee = array_unique($overtime_employee);
        $overtime_employee = count($overtime_employee);

        if ($total_overtime_min > 0) {
            $hours = floor($total_overtime_min / 60);
            $minutes = $total_overtime_min % 60;
            $overtime = $hours . ':' .$minutes;
        } else {
            $overtime = 0;
        }
        $data = [
            'total_overtime' => $overtime,
            'employee_id' => $employee_data,
            'overtime_employee' => $overtime_employee
        ];
        return $data;
    }

    public static function getOvertimeMinutes($employee_id, $date)
    {
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

        $timing = SettingsOfficeTime::where('office_time_type_id', $office_time_type->id)
            ->where('day', $day)
            ->first();

        if (empty($timing)) {
            $details['status'] = 'invalid_timing';
            $details['overtime'] = 0;
            return $details;
        }

        $day_end_time = $timing->end_time;

        $attendance_history_table = new AttendanceHistory();

        $min_out_time = Carbon::parse($day_end_time)->format('H:i');
        $min_out_time = $min_out_time . ":00";


        /*check weekend*/
        $weekend = $timing->is_weekend;

        $getHoliday = SettingsHoliday::where('deleted', SettingsHoliday::DELETED_NO)
            ->where('start_date', '>=', $date)
            ->where('end_date', '<=', $date)
            ->where('status', SettingsHoliday::STATUS_ACTIVE)
            ->get();

        $activity_history = $attendance_history_table->where('employee_id', $employee_id)
            ->whereDate('datetime', $date)
            ->get();
        if ($weekend == $timing::IS_WEEKEND_YES) {
           $day_type = 'weekend';
        } elseif (count($getHoliday) > 0) {
            $day_type = 'holiday';
        } else {
            $day_type = 'general';
        }
//        dd($activity_history->pluck('datetime'));
        return self::getOvertimeMinutesFromActivity($activity_history, $timing->end_time, $day_type);
    }

    public static function getOvertimeMinutesFromActivity($list, $min_out_time, $type='general')
    {
        $details['status'] = 'ok';
        $details['overtime'] = 0;

        foreach ($list as $data) {
            if ($data->type == AttendanceHistory::TYPE_IN) {
                $lastInTime = Carbon::parse($data->datetime);
                continue;
            }
            if ($type == 'general') {
                if (Carbon::make($data->datetime)->format('H:i:s') >= Carbon::make($min_out_time)->format('H:i:s')) {
                    if ($lastInTime->format('H:i:s') < Carbon::make($min_out_time)->format('H:i:s')) {
                        $details['overtime'] += Carbon::parse(Carbon::parse($data->datetime)->format('H:i:s'))->diffInMinutes(Carbon::parse($min_out_time));
                    } else {
                        $details['overtime'] += Carbon::parse(Carbon::parse($data->datetime)->format('H:i:s'))->diffInMinutes(Carbon::parse($lastInTime->format('H:i:s')));
                    }
                }
            } else {
                $details['overtime'] += Carbon::parse(Carbon::parse($data->datetime)->format('H:i:s'))->diffInMinutes(Carbon::parse($lastInTime->format('H:i:s')));
            }
        }
        return $details;
    }

    public function calculateOvertime($employeeId, $day, $start_time, $end_time)
    {
        // Convert start_time and end_time to Carbon instances for easy comparison
        $startTime = Carbon::parse($start_time);
        $endTime = Carbon::parse($end_time);

        // Get attendance records for the specified day and employee
        $attendanceRecords = AttendanceHistory::where('employee_id', $employeeId)
            ->where('datetime', '>=', $day . ' 00:00:00')
            ->where('datetime', '<=', $day . ' 23:59:59')
            ->get();

        // Calculate total overtime minutes
        $overtimeMinutes = 0;

        foreach ($attendanceRecords as $record) {
            $recordTime = Carbon::parse($record->datetime);

            // Check if the record time is outside of the regular office hours
            if ($recordTime < $startTime || $recordTime > $endTime) {
                // Calculate overtime for this record
                $overtimeMinutes += $recordTime->diffInMinutes($endTime);
            }
        }

        return $overtimeMinutes;
    }




    public static function overtimeMinuteToHour($overtime)
    {
        if ($overtime > 0) {
            $hours = floor($overtime / 60);
            $minutes = $overtime % 60;
            $format = $hours . ':' .$minutes;
        } else {
            $format = '00:00';
        }
        return $format;
    }

}
