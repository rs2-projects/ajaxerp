<?php

namespace App\Services\Payroll\Traits;

use App\Models\AttendanceReport;
use App\Models\Salary;
use App\Models\SalaryDetails;
use App\Models\SalarySettingsSalarySets;
use App\Models\SettingsSalarySet;
use App\Models\SettingsSalarySetEmployee;
use Carbon\Carbon;

trait GenerateSalaryTrait
{
    use GetSalaryResources;

    private $settingsSalaryType;
    private $settingsOvertimeType;
    private $settingsAbsentPenalty;
    private $settingsLatePenalty;
    private $settingsOfficeTimeType;
    private $settingsSalarySet;
    /**
     * @throws \Exception
     */
    public function generateSalarySetSalary($salary_set_id, $salary)
    {
        $salary_generate_type = $salary->salary_generate_type;


        $this->settingsSalarySet = $this->getSettingsSalarySet($salary_set_id, $salary_generate_type);
        if(empty($this->settingsSalarySet)) {
            throw new \Exception("Invalid Salary Set!");
        }

        $salarySettingsSalarySet = new SalarySettingsSalarySets();
        $salarySettingsSalarySet->salary_id = $salary->id;
        $salarySettingsSalarySet->settings_salary_set_id = $this->settingsSalarySet->id;
        $salarySettingsSalarySet->status = SalarySettingsSalarySets::STATUS_ACTIVE;
        $salarySettingsSalarySet->created_by = auth()->user()->id;
        $salarySettingsSalarySet->created_at = Carbon::now();
        $salarySettingsSalarySet->updated_by = auth()->user()->id;
        $salarySettingsSalarySet->updated_at = Carbon::now();
        $salarySettingsSalarySet->save();

        //find employees
        $employees = $this->getSalarySetEmployees($this->settingsSalarySet->id);

        $this->settingsSalaryType = $this->getSettingsSalaryType($this->settingsSalarySet); //with salaryTypeDetails
        $this->settingsOvertimeType = $this->getSettingsOvertimeType($this->settingsSalarySet);
        $this->settingsAbsentPenalty = $this->getSettingsAbsentPenalty($this->settingsSalarySet);
        $this->settingsLatePenalty = $this->getSettingsLatePenalty($this->settingsSalarySet);
        $this->settingsOfficeTimeType = $this->getSettingsOfficeTimeType($this->settingsSalarySet); //with officeTimes

        $total_salary_amount = 0;
        $total_bonus_amount = 0;
        $total_deduction_amount = 0;
        foreach ($employees as $employee) {

            $this->generateEmployeeSalary($employee, $salary);
        }
    }

    /**
     * @throws \Exception
     */
    public function generateEmployeeSalary($employee, $salary)
    {
        $basic_salary = $employee->basic_salary;

        $salaryDetails = new SalaryDetails();
        $salaryDetails->salary_id = $salary->id;
        $salaryDetails->employee_id = $employee->employee_id;
        $salaryDetails->settings_salary_set_id = $this->settingsSalarySet->id;
        $salaryDetails->settings_salary_type_id = $this->settingsSalaryType->id ?? null;
        $salaryDetails->settings_overtime_type_id = $this->settingsOvertimeType->id ?? null;
        $salaryDetails->settings_absent_penalty_id = $this->settingsAbsentPenalty->id ?? null;
        $salaryDetails->settings_late_penalty_id = $this->settingsLatePenalty->id ?? null;
        $salaryDetails->settings_office_time_type_id = $this->settingsOfficeTimeType->id ?? null;
        $salaryDetails->status = SalaryDetails::STATUS_ACTIVE;
        $salaryDetails->created_by = auth()->id();
        $salaryDetails->created_at = Carbon::now();
        $salaryDetails->updated_by = auth()->id();
        $salaryDetails->updated_at = Carbon::now();
        $salaryDetails->save();

        $startDate = Carbon::parse($salary->start_date);
        $endDate = Carbon::parse($salary->end_date);
        $totalDays = $endDate->diffInDays($startDate);


        $total_working_days = 0;
        $total_weekend_days = 0;
        $holiday_days = 0;
        $total_present_days = 0;
        $perfect_present_days = 0;
        $late_present_days = 0;
        $early_departure_days = 0;
        $absent_days = 0;
        $total_leave_days = 0;
        $paid_leave_days = 0;
        $extra_leave_days = 0;

        $total_normal_day_overtime_minutes = 0;
        $total_special_day_overtime_minutes = 0;
        $total_late_minutes = 0;
        $total_early_departure_minutes = 0;

        while ($startDate->lte($endDate)) {

            $attendanceReport = $this->getAttendanceReport($employee->employee_id, $startDate->format('Y-m-d'));

            if (empty($attendanceReport)) {
                throw new \Exception("Attendance Report Not Found!");
            }

            if ($attendanceReport->is_holiday == AttendanceReport::IS_HOLIDAY_HOLIDAY) {
                $holiday_days++;
            } elseif ($attendanceReport->is_weekend == AttendanceReport::IS_WEEKEND_WEEKEND) {
                $total_weekend_days++;
            } elseif ($attendanceReport->is_leave == AttendanceReport::IS_LEAVE_LEAVE) {
                $total_working_days++;
                $total_leave_days++;
                if ($attendanceReport->leave_type == AttendanceReport::LEAVE_TYPE_PAID) {
                    $paid_leave_days++;
                } elseif ($attendanceReport->leave_type == AttendanceReport::LEAVE_TYPE_UNPAID) {
                    $extra_leave_days++;
                }
            } elseif ($attendanceReport->is_present == AttendanceReport::IS_PRESENT_PRESENT) {
                $total_working_days++;
                $total_present_days++;
                if ($attendanceReport->time_in_status == AttendanceReport::TIME_IN_STATUS_ON_TIME && $attendanceReport->time_out_status == AttendanceReport::TIME_OUT_STATUS_ON_TIME) {
                    $perfect_present_days++;
                } else {
                    if ($attendanceReport->time_in_status == AttendanceReport::TIME_IN_STATUS_LATE) {
                        $late_present_days++;
                    }
                    if ($attendanceReport->time_out_status == AttendanceReport::TIME_OUT_STATUS_EARLY) {
                        $early_departure_days++;
                    }
                }
            } else {
                $absent_days++;
            }

            $normal_day_overtime_hour = $attendanceReport->normal_day_overtime;
            if(($normal_day_overtime_hour != '00:00') && ($normal_day_overtime_hour != '0:00')) {
                $total_normal_day_overtime_minutes += hoursToMinutes($normal_day_overtime_hour);
            }
            $special_day_overtime_hour = $attendanceReport->special_day_overtime;
            if(($special_day_overtime_hour != '00:00') && ($special_day_overtime_hour != '0:00')) {
                $total_special_day_overtime_minutes += hoursToMinutes($special_day_overtime_hour);
            }
            $late_hour = $attendanceReport->late_time;
            if(($late_hour != '00:00') && ($late_hour != '0:00')) {
                $total_late_minutes += hoursToMinutes($late_hour);
            }
            $early_hour = $attendanceReport->early_leaving_time;
            if(($early_hour != '00:00') && ($early_hour != '0:00')) {
                $total_early_departure_minutes += hoursToMinutes($early_hour);
            }

            $startDate->addDay();
        }

        $monthly_basic_salary = $basic_salary;
        $daily_basic_salary = $monthly_basic_salary / $total_working_days;
        $hourly_basic_salary = $daily_basic_salary / 8;


    }

}
