<?php

namespace App\Services\User;

use App\Models\SettingsLeaveType;
use App\Models\SettingsSalarySetEmployee;
use App\Models\SettingsSalarySetLeaveType;

class LeavesService
{
    public function __construct()
    {
        $this->paginate_limit = config('commonData.paginate_limit');
    }

    public function getIndexData($request)
    {
        $auth_user = auth()->user();

        $salarySetEmployee = SettingsSalarySetEmployee::where('employee_id', $auth_user->id)
            ->where('deleted', SettingsSalarySetEmployee::DELETED_NO)
            ->where('status', SettingsSalarySetEmployee::STATUS_ACTIVE)
            ->first();
        if (empty($salarySetEmployee)) {
            throw new \Exception("Please Contact with Admin For Your Salary Set");
        }

        $salarySetLeaveTypes = SettingsSalarySetLeaveType::where('settings_salary_set_id', $salarySetEmployee->settings_salary_set_id)
            ->where('deleted', SettingsSalarySetLeaveType::DELETED_NO)
            ->where('status', SettingsSalarySetLeaveType::STATUS_ACTIVE)
            ->pluck('settings_leave_type_id')->toArray();

        $data['settings_leave_types'] = SettingsLeaveType::whereIn('id', $salarySetLeaveTypes)
            ->where('deleted', SettingsLeaveType::DELETED_NO)
            ->where('status', SettingsLeaveType::STATUS_ACTIVE)
            ->orderBy('title', 'asc')
            ->get();

        return $data;
    }


}
