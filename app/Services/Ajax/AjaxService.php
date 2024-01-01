<?php

namespace App\Services\Ajax;

use App\Models\Designation;
use App\Models\SettingsSalarySetEmployee;
use App\Models\User;

class AjaxService
{
    public function getDesignationByDepartment($request)
    {
        $data['designations'] = Designation::where('deleted', Designation::DELETED_NO)
            ->where('status', Designation::STATUS_ACTIVE)
            ->where('department_id', $request->department_id)
            ->orderBy('name', 'asc')
            ->get();

        return $data;

    }

    public function getEmployees($request)
    {
        $keyword = $request->keyword ?? null;
        $department_id = $request->department_id?? null;
        $designation_id = $request->designation_id?? null;
        $data['getEmployees'] = User::where('deleted', User::DELETED_NO)
            ->where('status', User::STATUS_ACTIVE)
            ->where('role', User::ROLE_EMPLOYEE)
            ->where('type', User::TYPE_EMPLOYEE)
            ->where(function ($q) use ($keyword) {
                if (!empty($keyword)) {
                    $q->where('first_name', 'like', '%' . $keyword . '%')
                        ->orWhere('last_name', 'like', '%' . $keyword . '%')
                        ->orWhere('employee_id', 'like', '%' . $keyword . '%');
                }
            })
            ->where(function ($q) use ($department_id) {
                if (!empty($department_id)) {
                    $q->where('department_id', $department_id);
                }
            })
            ->where(function ($q) use ($designation_id) {
                if (!empty($designation_id)) {
                    $q->where('designation_id', $designation_id);
                }
            })
            ->orderBy('first_name', 'asc')
            ->get();

        return $data;
    }
    public function salarySetGetEmployees($request)
    {
        if(isset($request->salary_set_id)) {
            $salary_set_id = $request->salary_set_id;
            $salary_set_employees = SettingsSalarySetEmployee::where('settings_salary_set_id', $salary_set_id)
                ->where('status', SettingsSalarySetEmployee::STATUS_ACTIVE)
                ->where('deleted', SettingsSalarySetEmployee::DELETED_NO)
                ->pluck('basic_salary', 'employee_id')->toArray();

            $removed_employee_ids = SettingsSalarySetEmployee::where('settings_salary_set_id', '!=', $salary_set_id)
                ->where('status', SettingsSalarySetEmployee::STATUS_ACTIVE)
                ->where('deleted', SettingsSalarySetEmployee::DELETED_NO)
                ->pluck('employee_id')->toArray();
        } else {
            $salary_set_employees = [];
            $removed_employee_ids = [];
        }


//        return $salary_set_employees;
        $keyword = $request->keyword ?? null;
        $department_id = $request->department_id?? null;
        $designation_id = $request->designation_id?? null;
        $data['getEmployees'] = User::with('designation', 'department')
            ->whereNotIn('id', $removed_employee_ids)
            ->where('deleted', User::DELETED_NO)
            ->where('status', User::STATUS_ACTIVE)
            ->where('role', User::ROLE_EMPLOYEE)
            ->where('type', User::TYPE_EMPLOYEE)
            ->where(function ($q) use ($keyword) {
                if (!empty($keyword)) {
                    $q->where('first_name', 'like', '%' . $keyword . '%')
                        ->orWhere('last_name', 'like', '%' . $keyword . '%')
                        ->orWhere('employee_id', 'like', '%' . $keyword . '%');
                }
            })
            ->where(function ($q) use ($department_id) {
                if (!empty($department_id)) {
                    $q->where('department_id', $department_id);
                }
            })
            ->where(function ($q) use ($designation_id) {
                if (!empty($designation_id)) {
                    $q->where('designation_id', $designation_id);
                }
            })
            ->orderBy('first_name', 'asc')
            ->get()
            ->map(function ($employee) use ($salary_set_employees) {
                $selected_employee_ids = array_keys($salary_set_employees);
                if(in_array($employee->id, $selected_employee_ids)) {
                    $employee->is_selected = true;
                    $employee->basic_salary = $salary_set_employees[$employee->id];
                } else {
                    $employee->is_selected = false;
                    $employee->basic_salary = 0;
                }
                return $employee;
            });

        return $data;
    }
}
