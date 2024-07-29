<?php

namespace App\Helpers;

use App\Exceptions\InvalidSalarySetException;
use App\Models\SettingsSalarySet;
use App\Models\SettingsSalarySetEmployee;

class SalarySetHelper
{
    public static function getEmployeeSalarySet($employee_id, $date = null)
    {
        if ($date === null) {
            $salary_set_employee = SettingsSalarySetEmployee::where('employee_id', $employee_id)
                ->where('status', SettingsSalarySetEmployee::STATUS_ACTIVE)
                ->where('deleted', SettingsSalarySetEmployee::DELETED_NO)
                ->orderBy('id', 'DESC')
                ->first();
            if (empty($salary_set_employee)) {
                throw new InvalidSalarySetException();
            }
            $salary_set = SettingsSalarySet::where('id', $salary_set_employee->settings_salary_set_id)
                ->where('status', SettingsSalarySet::STATUS_ACTIVE)
                ->where('deleted', SettingsSalarySet::DELETED_NO)
                ->first();
            if (empty($salary_set)) {
                throw new InvalidSalarySetException();
            }
        } else {
            $employee_salary_set_ids = SettingsSalarySetEmployee::where('employee_id', $employee_id)
                ->where('status', SettingsSalarySetEmployee::STATUS_ACTIVE)
                ->where('deleted', SettingsSalarySetEmployee::DELETED_NO)
                ->pluck('settings_salary_set_id')
                ->toArray();

            if(count($employee_salary_set_ids) <= 0) {
                throw new InvalidSalarySetException();
            }

            $salary_set = SettingsSalarySet::whereIn('id', $employee_salary_set_ids)
                ->where('deleted', SettingsSalarySet::DELETED_NO)
                ->where('start_date', '<=', $date)
                ->where(function ($q) use ($date) {
                    $q->where(function ($j) use ($date) {
                        $j->where('status', SettingsSalarySet::STATUS_INACTIVE)
                            ->where('end_date', '>=', $date);
                    })
                        ->orWhere(function ($j) use ($date) {
                            $j->where('status', SettingsSalarySet::STATUS_ACTIVE)
                                ->where('end_date', null);
                        });
                })
                ->orderBy('id', 'DESC')
                ->first();
            if (empty($salary_set)) {
                throw new InvalidSalarySetException();
            }
        }

        return $salary_set;

    }

    public static function getEmployeeCurrentSalary($employee_id) {
        $salary_set_employee = SettingsSalarySetEmployee::where('employee_id', $employee_id)
                ->where('status', SettingsSalarySetEmployee::STATUS_ACTIVE)
                ->where('deleted', SettingsSalarySetEmployee::DELETED_NO)
                ->whereHas('salarySet', function($q) {
                    $q->where('status', SettingsSalarySet::STATUS_ACTIVE)
                        ->where('end_date', null);
                })
                ->orderBy('id', 'DESC')
                ->first();
        if (empty($salary_set_employee)) {
            throw new InvalidSalarySetException();
        }

        return $salary_set_employee;
    }
}
