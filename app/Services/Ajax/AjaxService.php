<?php

namespace App\Services\Ajax;

use App\Models\Designation;
use App\Models\SalarySettingsSalarySets;
use App\Models\SettingsLeaveType;
use App\Models\SettingsSalarySetEmployee;
use App\Models\SettingsSalarySetLeaveType;
use App\Models\User;
use App\Models\UserLeave;
use Carbon\Carbon;

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
            ->where('is_contracted', User::CONTRACTED_NO)
            ->where(function ($q) {
                $q->where('terminated', User::TERMINATED_NO)
                    ->orWhere('terminate_date', '>', Carbon::now());
            })
            ->where(function ($q) {
                $q->where('resigned', User::RESIGNED_NO)
                    ->orWhere('resign_date', '>', Carbon::now());
            })
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

    public function getLeaveTypeByUser($request)
    {
        try {
            if ($request->user_id == '' || $request->user_id == null) {
                throw new \Exception("Please Select Employee");
            }

            $salarySetEmployee = SettingsSalarySetEmployee::where('employee_id', $request->user_id)
                ->where('deleted', SettingsSalarySetEmployee::DELETED_NO)
                ->where('status', SettingsSalarySetEmployee::STATUS_ACTIVE)
                ->first();
            if (empty($salarySetEmployee)) {
                throw new \Exception("Please Set Salary Set For This Employee");
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

        }catch (\Exception $exception) {
           throw new \Exception($exception->getMessage());
        }
    }

    public function getEmployeeTotalLeaveByLeaveType($request)
    {
        try {
            $user_id = $request->user_id;
            $leave_type_id = $request->leave_type_id;
            if ($user_id == '' || $user_id == null) {
                throw new \Exception("Please Select Employee");
            }
            if ($leave_type_id == '' || $leave_type_id == null) {
                throw new \Exception("Please Select Leave Type");
            }
            $check_user = User::where('id', $user_id)
                ->where('deleted', User::DELETED_NO)
                ->where('status', User::STATUS_ACTIVE)
                ->first();
            if(empty($check_user)) {
                throw new \Exception("Invalid User");
            }

            $check_leave_type = SettingsLeaveType::where('id', $leave_type_id)
                ->where('deleted', SettingsLeaveType::DELETED_NO)
                ->where('status', SettingsLeaveType::STATUS_ACTIVE)
                ->first();
            if(empty($check_leave_type)) {
                throw new \Exception("Invalid Leave Type");
            }
            $startOfYear = Carbon::now()->startOfYear()->format('Y-m-d');
            $endOfYear = Carbon::now()->endOfYear()->format('Y-m-d');
            $usedLeaves = UserLeave::where('user_id', $user_id)
                ->where('settings_leave_type_id', $leave_type_id)
                ->where('deleted', UserLeave::DELETED_NO)
                ->where('status', UserLeave::STATUS_ACTIVE)
                ->whereIn('leave_status',[UserLeave::LEAVE_STATUS_APPROVED, UserLeave::LEAVE_STATUS_PENDING])
                ->whereDate('approve_start_date', '>=', $startOfYear)
                ->whereDate('approve_end_date', '<=', $endOfYear)
                ->sum('approved_number_of_days');

            $data['remaining_leaves'] = $check_leave_type->annual_leave_days - $usedLeaves;

            return $data;
        }catch (\Exception $exception) {
           throw new \Exception($exception->getMessage());
        }
    }
    public function getEmployeeTotalLeaveByLeaveTypeEdit($request)
    {
        try {
            $user_id = $request->user_id;
            $leave_type_id = $request->leave_type_id;
            $userLeaveId = $request->userLeaveId;
            $userLeave = UserLeave::where('id', $userLeaveId)
                ->where('deleted', UserLeave::DELETED_NO)
                ->first();
            if(empty($userLeave)) {
                throw new \Exception($userLeave);
            }
            if ($user_id == '' || $user_id == null) {
                throw new \Exception("Please Select Employee");
            }
            if ($leave_type_id == '' || $leave_type_id == null) {
                throw new \Exception("Please Select Leave Type");
            }
            $check_user = User::where('id', $user_id)
                ->where('deleted', User::DELETED_NO)
                ->where('status', User::STATUS_ACTIVE)
                ->first();
            if(empty($check_user)) {
                throw new \Exception("Invalid User");
            }

            $check_leave_type = SettingsLeaveType::where('id', $leave_type_id)
                ->where('deleted', SettingsLeaveType::DELETED_NO)
                ->where('status', SettingsLeaveType::STATUS_ACTIVE)
                ->first();
            if(empty($check_leave_type)) {
                throw new \Exception("Invalid Leave Type");
            }
            $startOfYear = Carbon::now()->startOfYear()->format('Y-m-d');
            $endOfYear = Carbon::now()->endOfYear()->format('Y-m-d');
            $usedLeaves = UserLeave::where('id', '!=', $userLeaveId)
                ->where('user_id', $user_id)
                ->where('settings_leave_type_id', $leave_type_id)
                ->where('deleted', UserLeave::DELETED_NO)
                ->where('status', UserLeave::STATUS_ACTIVE)
                ->whereIn('leave_status',[UserLeave::LEAVE_STATUS_APPROVED, UserLeave::LEAVE_STATUS_PENDING])
                ->whereDate('approve_start_date', '>=', $startOfYear)
                ->whereDate('approve_end_date', '<=', $endOfYear)
                ->sum('approved_number_of_days');

            $data['remaining_leaves'] = $check_leave_type->annual_leave_days - $usedLeaves;

            return $data;
        }catch (\Exception $exception) {
           throw new \Exception($exception->getMessage());
        }
    }
}
