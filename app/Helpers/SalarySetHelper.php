<?php

namespace App\Helpers;

use App\Models\SettingsSalarySet;
use App\Models\SettingsSalarySetEmployee;

class SalarySetHelper
{
    public static function getEmployeeSalarySet($employee_id)
    {
        $salary_set_employee = SettingsSalarySetEmployee::where('employee_id', $employee_id)
            ->where('status', SettingsSalarySetEmployee::STATUS_ACTIVE)
            ->where('deleted', SettingsSalarySetEmployee::DELETED_NO)
            ->first();
        if (empty($salary_set_employee)) {
            throw new \Exception("Please Contact with Admin For Your Salary Set");
        }
        $salary_set = SettingsSalarySet::where('id', $salary_set_employee->settings_salary_set_id)
            ->where('status', SettingsSalarySet::STATUS_ACTIVE)
            ->where('deleted', SettingsSalarySet::DELETED_NO)
            ->first();
        if (empty($salary_set)) {
            throw new \Exception("Please Contact with Admin For Your Salary Set");
        }
        return $salary_set;

    }
}
