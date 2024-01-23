<?php

namespace App\Services\Payroll\Traits;

use App\Models\AttendanceReport;
use App\Models\Salary;
use App\Models\SalaryDetails;
use App\Models\SalaryDetailsAdditionDeductions;
use App\Models\SalaryDetailsBonuses;
use App\Models\SalaryDetailsLeaves;
use App\Models\SalarySettingsSalarySets;
use App\Models\SettingsAbsentPenalty;
use App\Models\SettingsBonusTypeSalaryBonus;
use App\Models\SettingsLatePenalty;
use App\Models\SettingsLeaveType;
use App\Models\SettingsOvertimeType;
use App\Models\SettingsSalaryDeductionType;
use App\Models\SettingsSalarySet;
use App\Models\SettingsSalarySetEmployee;
use App\Models\SettingsSalaryTypeDetails;
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
    private $salarySettingsSalarySet;
    private $settingsSalaryDeductionType;
    private $salary;
    private $salary_bonuses;
    /**
     * @throws \Exception
     */
    public function generateSalarySetSalary($salary_set_id, $salary, $salary_bonuses)
    {
        $this->salary = $salary;
        $this->salary_bonuses = $salary_bonuses;

        $salary_generate_type = $this->salary->salary_generate_type;

        $this->settingsSalarySet = $this->getSettingsSalarySet($salary_set_id, $salary_generate_type);
        if(empty($this->settingsSalarySet)) {
            throw new \Exception("Invalid Salary Set!");
        }

        $salarySettingsSalarySet = new SalarySettingsSalarySets();
        $salarySettingsSalarySet->salary_id = $this->salary->id;
        $salarySettingsSalarySet->settings_salary_set_id = $this->settingsSalarySet->id;
        $salarySettingsSalarySet->status = SalarySettingsSalarySets::STATUS_ACTIVE;
        $salarySettingsSalarySet->created_by = auth()->user()->id;
        $salarySettingsSalarySet->created_at = Carbon::now();
        $salarySettingsSalarySet->updated_by = auth()->user()->id;
        $salarySettingsSalarySet->updated_at = Carbon::now();
        $salarySettingsSalarySet->save();

        $this->salarySettingsSalarySet = $salarySettingsSalarySet;

        $this->settingsSalaryType = $this->getSettingsSalaryType($this->settingsSalarySet); //with salaryTypeDetails
        $this->settingsOvertimeType = $this->getSettingsOvertimeType($this->settingsSalarySet);
        $this->settingsAbsentPenalty = $this->getSettingsAbsentPenalty($this->settingsSalarySet);
        $this->settingsLatePenalty = $this->getSettingsLatePenalty($this->settingsSalarySet);
        $this->settingsOfficeTimeType = $this->getSettingsOfficeTimeType($this->settingsSalarySet); //with officeTimes

        if($salary->settings_salary_deduction_type_id != null) {
            $this->settingsSalaryDeductionType = $this->getSettingsSalaryDeductionType($salary->settings_salary_deduction_type_id);
        } else {
            $this->settingsSalaryDeductionType = null;
        }

        $total_salary_amount = $this->salary->total_salary_amount ?? 0;
        $total_bonus_amount = $this->salary->total_bonus_amount ?? 0;
        $total_deduction_amount = $this->salary->total_deduction_amount ?? 0;

        //find employees
        $employees = $this->getSalarySetEmployees($this->settingsSalarySet->id);

        foreach ($employees as $employee) {
            $salaryDetail = $this->generateEmployeeSalary($employee);
            $total_salary_amount += $salaryDetail->net_payable_salary;
            $total_bonus_amount += $salaryDetail->total_bonus_amount;
            $total_deduction_amount += $salaryDetail->deduction_amount;
        }

        $salarySettingsSalarySet->total_salary_amount = $total_salary_amount;
        $salarySettingsSalarySet->total_bonus_amount = $total_bonus_amount;
        $salarySettingsSalarySet->total_deduction_amount = $total_deduction_amount;
        $salarySettingsSalarySet->total_amount_to_pay = $total_salary_amount + $total_bonus_amount - $total_deduction_amount;
        $salarySettingsSalarySet->save();

        return $salarySettingsSalarySet;
    }

    /**
     * @throws \Exception
     */
    public function generateEmployeeSalary($employee)
    {
        $salary = $this->salary;

        $basic_salary = $employee->basic_salary;

        $salaryDetails = new SalaryDetails();
        $salaryDetails->salary_id = $salary->id;
        $salaryDetails->employee_id = $employee->employee_id;
        $salaryDetails->settings_salary_set_id = $this->settingsSalarySet->id;
        $salaryDetails->salary_settings_salary_set_id = $this->salarySettingsSalarySet->id;
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


        $monthly_basic_salary = $basic_salary;

        $default_added_salary = 0;
        $default_deducted_salary = 0;

        if($salary->salary_generate_type == Salary::SALARY_GENERATE_TYPE_HALF_MONTH) {
            $net_basic_salary = $monthly_basic_salary / 2;
        } else {
            $net_basic_salary = $monthly_basic_salary;
        }

        if(!empty($this->settingsSalaryType->salaryTypeDetails)) {
            foreach ($this->settingsSalaryType->salaryTypeDetails as $salaryTypeDetail) {

                $additionDeduction = new SalaryDetailsAdditionDeductions();
                $additionDeduction->salary_id = $salary->id;
                $additionDeduction->salary_details_id = $salaryDetails->id;
                $additionDeduction->settings_salary_type_details_id = $salaryTypeDetail->id;

                $additionDeduction->type = $salaryTypeDetail->type;
                $additionDeduction->rate = $salaryTypeDetail->value;

                $value = ($net_basic_salary * $salaryTypeDetail->value) / 100;

                $additionDeduction->amount = $value;

                if ($salaryTypeDetail->type == SettingsSalaryTypeDetails::TYPE_EARNING) {
                    $default_added_salary += $value;
                } else {
                    $default_deducted_salary += $value;
                }

                $additionDeduction->status = SalaryDetailsAdditionDeductions::STATUS_ACTIVE;
                $additionDeduction->created_by = auth()->id();
                $additionDeduction->created_at = Carbon::now();
                $additionDeduction->updated_by = auth()->id();
                $additionDeduction->updated_at = Carbon::now();
                $additionDeduction->save();
            }
        }

        $monthly_gross_salary = $monthly_basic_salary + $default_added_salary - $default_deducted_salary;


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
        $total_extra_leave_amounts = 0;

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
                $salaryDetailsLeave = new SalaryDetailsLeaves();
                $salaryDetailsLeave->salary_id = $salary->id;
                $salaryDetailsLeave->salary_details_id = $salaryDetails->id;
                $salaryDetailsLeave->employee_id = $employee->employee_id;
                $salaryDetailsLeave->date = $attendanceReport->date;
                $salaryDetailsLeave->leave_type = $attendanceReport->leave_type;
                $salaryDetailsLeave->settings_leave_type_id = $attendanceReport->settings_leave_type_id;

                $salaryDetailsLeave->salary_type = $attendanceReport->settingsLeaveType->salary_type;
                $salaryDetailsLeave->rate = $attendanceReport->settingsLeaveType->rate;

                if ($attendanceReport->leave_type == AttendanceReport::LEAVE_TYPE_UNPAID) {
                    if ($attendanceReport->settingsLeaveType->salary_type == SettingsLeaveType::SALARY_TYPE_GROSS_SALARY) {
                        $extra_leave_deduct_amount = ($monthly_gross_salary * $attendanceReport->settingsLeaveType->rate) / 100;
                    } else {
                        $extra_leave_deduct_amount = ($monthly_basic_salary * $attendanceReport->settingsLeaveType->rate) / 100;
                    }
                } else {
                    $extra_leave_deduct_amount = 0;
                }
                $salaryDetailsLeave->amount = $extra_leave_deduct_amount;
                $total_extra_leave_amounts += $extra_leave_deduct_amount;

                $salaryDetailsLeave->status = SalaryDetailsLeaves::STATUS_ACTIVE;
                $salaryDetailsLeave->created_by = auth()->id();
                $salaryDetailsLeave->created_at = Carbon::now();
                $salaryDetailsLeave->updated_by = auth()->id();
                $salaryDetailsLeave->updated_at = Carbon::now();
                $salaryDetailsLeave->save();

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

        $daily_basic_salary = $monthly_basic_salary / (($total_working_days != '0') ? $total_working_days : 1);
        $hourly_basic_salary = $daily_basic_salary / (($this->settingsOfficeTimeType->working_hour != '0') ? $this->settingsOfficeTimeType->working_hour : 1);
        $minute_basic_salary = $hourly_basic_salary / 60;



        $daily_gross_salary = $monthly_gross_salary / (($total_working_days != '0') ? $total_working_days : 1);
        $hourly_gross_salary = $daily_gross_salary / (($this->settingsOfficeTimeType->working_hour != '0') ? $this->settingsOfficeTimeType->working_hour : 1);

        $minute_gross_salary = $hourly_gross_salary / 60;

        if($salary->salary_generate_type == Salary::SALARY_GENERATE_TYPE_HALF_MONTH) {
            $current_period_salary = $monthly_gross_salary / 2;
        } else {
            $current_period_salary = $monthly_gross_salary;
        }

        if($this->settingsOvertimeType->salary_type == SettingsOvertimeType::SALARY_TYPE_GROSS_SALARY) {
            $normal_day_overtime_rate_per_hour = ($hourly_gross_salary * $this->settingsOvertimeType->rate) / 100;
            $normal_day_overtime_rate_per_minute = ($minute_gross_salary * $this->settingsOvertimeType->rate) / 100;
            $special_day_overtime_rate_per_hour = ($hourly_gross_salary * $this->settingsOvertimeType->special_rate) / 100;
            $special_day_overtime_rate_per_minute = ($minute_gross_salary * $this->settingsOvertimeType->special_rate) / 100;
        } else {
            $normal_day_overtime_rate_per_hour = ($hourly_basic_salary * $this->settingsOvertimeType->rate) / 100;
            $normal_day_overtime_rate_per_minute = ($minute_basic_salary * $this->settingsOvertimeType->rate) / 100;
            $special_day_overtime_rate_per_hour = ($hourly_basic_salary * $this->settingsOvertimeType->special_rate) / 100;
            $special_day_overtime_rate_per_minute = ($minute_basic_salary * $this->settingsOvertimeType->special_rate) / 100;
        }

        $normal_day_overtime_amount = $total_normal_day_overtime_minutes * $normal_day_overtime_rate_per_minute;
        $special_day_overtime_amount = $total_special_day_overtime_minutes * $special_day_overtime_rate_per_minute;

        if($this->settingsLatePenalty->salary_type == SettingsLatePenalty::SALARY_TYPE_GROSS_SALARY) {
            $late_rate_per_hour = ($hourly_gross_salary * $this->settingsLatePenalty->rate) / 100;
            $late_rate_per_minute = ($minute_gross_salary * $this->settingsLatePenalty->rate) / 100;
        } else {
            $late_rate_per_hour = ($hourly_basic_salary * $this->settingsLatePenalty->rate) / 100;
            $late_rate_per_minute = ($minute_basic_salary * $this->settingsLatePenalty->rate) / 100;
        }

        $late_amount = $total_late_minutes * $late_rate_per_minute;
        $early_departure_amount = $total_early_departure_minutes * $late_rate_per_minute;

        $salaryDetails->total_days = $totalDays;
        $salaryDetails->total_working_days = $total_working_days;
        $salaryDetails->total_weekend_days = $total_weekend_days;
        $salaryDetails->holiday_days = $holiday_days;
        $salaryDetails->total_present_days = $total_present_days;
        $salaryDetails->perfect_present_days = $perfect_present_days;
        $salaryDetails->late_present_days = $late_present_days;
        $salaryDetails->early_departure_days = $early_departure_days;
        $salaryDetails->absent_days = $absent_days;
        $salaryDetails->total_leave_days = $total_leave_days;
        $salaryDetails->paid_leave_days = $paid_leave_days;
        $salaryDetails->extra_leave_days = $extra_leave_days;

        $salaryDetails->monthly_basic_salary = $monthly_basic_salary;
        $salaryDetails->daily_basic_salary = $daily_basic_salary;
        $salaryDetails->net_basic_salary = $net_basic_salary;
        $salaryDetails->total_added_salary = $default_added_salary;
        $salaryDetails->total_deducted_salary = $default_deducted_salary;
        $salaryDetails->monthly_salary = $monthly_gross_salary;
        $salaryDetails->daily_salary = $daily_gross_salary;
        $salaryDetails->current_period_salary = $current_period_salary;

        $salaryDetails->normal_day_overtime_minutes = $total_normal_day_overtime_minutes;
        $salaryDetails->normal_day_overtime_rate_per_hour = $normal_day_overtime_rate_per_hour;
        $salaryDetails->normal_day_overtime_rate_per_minute = $normal_day_overtime_rate_per_minute;
        $salaryDetails->normal_day_overtime_amount = $normal_day_overtime_amount;
        $salaryDetails->special_day_overtime_minutes = $total_special_day_overtime_minutes;
        $salaryDetails->special_day_overtime_rate_per_hour = $special_day_overtime_rate_per_hour;
        $salaryDetails->special_day_overtime_rate_per_minute = $special_day_overtime_rate_per_minute;
        $salaryDetails->special_day_overtime_amount = $special_day_overtime_amount;

        $salaryDetails->late_minutes = $total_late_minutes;
        $salaryDetails->late_rate_per_hour = $late_rate_per_hour;
        $salaryDetails->late_rate_per_minute = $late_rate_per_minute;
        $salaryDetails->late_amount = $late_amount;

        $salaryDetails->early_departure_minutes = $total_early_departure_minutes;
        $salaryDetails->early_departure_rate_per_hour = $late_rate_per_hour;
        $salaryDetails->early_departure_rate_per_minute = $late_rate_per_minute;
        $salaryDetails->early_departure_amount = $early_departure_amount;

        //calculate Absent Penalty
        $salaryDetails->absent_day_rate_type = $this->settingsAbsentPenalty->rate_type;
        $salaryDetails->absent_day_salary_type = $this->settingsAbsentPenalty->salary_type;
        $salaryDetails->absent_day_rate = $this->settingsAbsentPenalty->rate;

        if($this->settingsAbsentPenalty->rate_type == SettingsAbsentPenalty::RATE_TYPE_PERCENT) {
            if($this->settingsAbsentPenalty->salary_type == SettingsAbsentPenalty::SALARY_TYPE_GROSS_SALARY) {
                $per_day_absent_amount = ($daily_gross_salary * $this->settingsAbsentPenalty->rate) / 100;
            } else {
                $per_day_absent_amount = ($daily_basic_salary * $this->settingsAbsentPenalty->rate) / 100;
            }
        } else {
            $per_day_absent_amount = $this->settingsAbsentPenalty->rate;
        }
        $total_absent_penalty_amount = $per_day_absent_amount * $absent_days;
        $salaryDetails->absent_day_amount_per_day = $per_day_absent_amount;
        $salaryDetails->absent_day_amount = $total_absent_penalty_amount;

        //calculate leave deduction
        $salaryDetails->extra_leave_amount = $total_extra_leave_amounts;

        //selected bonuses add
        $employee_total_bonus_amount = 0;
        foreach ($this->salary_bonuses as $salary_bonus) {
            $settingsBonusTypeSalaryBonus = SettingsBonusTypeSalaryBonus::where('settings_bonus_type_id', $salary_bonus->settings_bonus_type_id)
                ->where('settings_salary_type_id', $this->settingsSalaryType->id)
                ->first();
            if (empty($settingsBonusTypeSalaryBonus)) {
                continue;
            }
            $salary_details_bonus = new SalaryDetailsBonuses();
            $salary_details_bonus->salary_id = $salary->id;
            $salary_details_bonus->salary_details_id = $salaryDetails->id;
            $salary_details_bonus->salary_bonus_type_id = $salary_bonus->id;
            $salary_details_bonus->settings_bonus_type_id = $salary_bonus->settings_bonus_type_id;

            $salary_details_bonus->settings_bonus_type_salary_bonus_id = $settingsBonusTypeSalaryBonus->id;
            $salary_details_bonus->bonus_rate_type = $settingsBonusTypeSalaryBonus->rate_type;
            $salary_details_bonus->bonus_salary_type = $settingsBonusTypeSalaryBonus->salary_type;
            $salary_details_bonus->bonus_rate = $settingsBonusTypeSalaryBonus->rate;

            if($settingsBonusTypeSalaryBonus->rate_type == SettingsBonusTypeSalaryBonus::RATE_TYPE_PERCENT) {
                if($settingsBonusTypeSalaryBonus->salary_type == SettingsBonusTypeSalaryBonus::SALARY_TYPE_GROSS_SALARY) {
                    $bonus_amount = ($monthly_gross_salary * $settingsBonusTypeSalaryBonus->rate) / 100;
                } else {
                    $bonus_amount = ($monthly_basic_salary * $settingsBonusTypeSalaryBonus->rate) / 100;
                }
            } else {
                $bonus_amount = $settingsBonusTypeSalaryBonus->rate;
            }

            $salary_details_bonus->bonus_amount = $bonus_amount;

            $salary_details_bonus->status = SalaryDetailsBonuses::STATUS_ACTIVE;
            $salary_details_bonus->created_at = Carbon::now();
            $salary_details_bonus->created_by = auth()->id();
            $salary_details_bonus->updated_at = Carbon::now();
            $salary_details_bonus->updated_by = auth()->id();
            $salary_details_bonus->save();

            $salary_bonus->total_bonus_amount += $bonus_amount;
            $salary_bonus->save();
            $employee_total_bonus_amount += $bonus_amount;
        }

        $salaryDetails->total_bonus_amount = $employee_total_bonus_amount;

        //selected deduction minus
        $deduction_amount = 0;
        if($this->settingsSalaryDeductionType != null) {
            $salaryDetails->deduction_rate_type = $this->settingsSalaryDeductionType->rate_type;
            $salaryDetails->deduction_salary_type = $this->settingsSalaryDeductionType->salary_type;
            $salaryDetails->deduction_rate = $this->settingsSalaryDeductionType->rate;

            if($this->settingsSalaryDeductionType->rate_type == SettingsSalaryDeductionType::RATE_TYPE_PERCENT) {
                if($this->settingsSalaryDeductionType->salary_type == SettingsSalaryDeductionType::SALARY_TYPE_GROSS_SALARY) {
                    $deduction_amount = ($monthly_gross_salary * $this->settingsSalaryDeductionType->rate) / 100;
                } else {
                    $deduction_amount = ($monthly_basic_salary * $this->settingsSalaryDeductionType->rate) / 100;
                }
            } else {
                $deduction_amount = $this->settingsSalaryDeductionType->rate;
            }
        }

        $salaryDetails->deduction_amount = $deduction_amount;

        $net_payable_salary = $current_period_salary
            + $normal_day_overtime_amount
            + $special_day_overtime_amount
            + $employee_total_bonus_amount
            - $late_amount
            - $early_departure_amount
            - $deduction_amount;

        $salaryDetails->net_payable_salary = $net_payable_salary;
        $salaryDetails->save();

        return $salaryDetails;
    }

}
