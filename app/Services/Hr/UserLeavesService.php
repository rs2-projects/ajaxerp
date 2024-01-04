<?php

namespace App\Services\Hr;

use App\Models\SettingsLeaveType;
use App\Models\SettingsSalarySetEmployee;
use App\Models\SettingsSalarySetLeaveType;
use App\Models\User;
use App\Models\UserLeave;
use Carbon\Carbon;

class UserLeavesService
{
    public function __construct()
    {
        $this->paginate_limit = config('commonData.paginate_limit');
    }

    public function getIndexData($request)
    {
        $data['settingsLeaveTypes'] = SettingsLeaveType::where('deleted', SettingsLeaveType::DELETED_NO)
            ->where('status', SettingsLeaveType::STATUS_ACTIVE)
            ->get();

        $data['employees'] = User::where('deleted', User::DELETED_NO)
            ->where('status', User::STATUS_ACTIVE)
            ->where('type', User::TYPE_EMPLOYEE)
            ->where('role', User::ROLE_EMPLOYEE)
            ->where(function ($q) {
                $q->where('terminated', User::TERMINATED_NO)
                    ->orWhere('terminate_date', '>', Carbon::now());
            })
            ->where(function ($q) {
                $q->where('resigned', User::RESIGNED_NO)
                    ->orWhere('resign_date', '>', Carbon::now());
            })
            ->get();

        return $data;
    }

    public function getIndexFilteredData($request)
    {
        $leaveStatus = $request->leave_status??null;

        $data['userLeaves'] = UserLeave::with('user')
            ->where('deleted', UserLeave::DELETED_NO)
            ->where(function ($query) use ($leaveStatus) {
                if ($leaveStatus != null || $leaveStatus != '') {
                    $query->where('leave_status', $leaveStatus);
                }
            })
            ->orderBy('id', 'desc')
            ->paginate($this->paginate_limit);

        return $data;
    }

    public function store($request)
    {
        try {
            $check_user = User::where('id', $request->user_id)->first();
            if (!$check_user) {
                throw new \Exception('User not found.');
            }
            $check_leave_type = SettingsLeaveType::where('id', $request->settings_leave_type_id)->first();
            if (!$check_leave_type) {
                throw new \Exception('Leave type not found.');
            }

            $userLeave = new UserLeave();
            $userLeave->user_id = $request->user_id;
            $userLeave->settings_leave_type_id = $request->settings_leave_type_id;
            $userLeave->start_date = $request->start_date;
            $userLeave->end_date = $request->end_date;
            $userLeave->number_of_days = $request->number_of_days;
            $userLeave->reason = $request->reason;
            $userLeave->leave_status = UserLeave::LEAVE_STATUS_APPROVED;
            $userLeave->accepted_at = Carbon::now();
            $userLeave->accepted_by = auth()->user()->id;
            $userLeave->approve_start_date = $request->start_date;
            $userLeave->approve_end_date = $request->end_date;
            $userLeave->approved_number_of_days = $request->number_of_days;
            $userLeave->created_by = auth()->user()->id;
            $userLeave->created_at = Carbon::now();
            $userLeave->updated_by = auth()->user()->id;
            $userLeave->updated_at = Carbon::now();
            $userLeave->save();
        }catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }
    }

    public function edit($id)
    {
        try {
            $data['userLeave'] = UserLeave::with('user', 'settingsLeaveType')
                ->where('id', $id)
                ->where('deleted', UserLeave::DELETED_NO)
                ->first();
            if (!$data['userLeave']) {
                throw new \Exception('Leave not found.');
            }

            $salarySetEmployee = SettingsSalarySetEmployee::where('employee_id', $data['userLeave']->user_id)
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

            $data['settingsLeaveTypes'] = SettingsLeaveType::whereIn('id', $salarySetLeaveTypes)
                ->where('deleted', SettingsLeaveType::DELETED_NO)
                ->where('status', SettingsLeaveType::STATUS_ACTIVE)
                ->orderBy('title', 'asc')
                ->get();

            return $data;
        }catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }
    }

    public function update($id, $request)
    {
        try {
            $userLeave = UserLeave::where('id', $id)
                ->where('deleted', UserLeave::DELETED_NO)
                ->first();
            if (!$userLeave) {
                throw new \Exception('Leave not found.');
            }
            $check_leave_type = SettingsLeaveType::where('id', $request->settings_leave_type_id)->first();
            if (!$check_leave_type) {
                throw new \Exception('Leave type not found.');
            }

            $userLeave->settings_leave_type_id = $request->settings_leave_type_id;
            $userLeave->start_date = $request->start_date;
            $userLeave->end_date = $request->end_date;
            $userLeave->number_of_days = $request->number_of_days;
            $userLeave->reason = $request->reason;
//            $userLeave->leave_status = UserLeave::LEAVE_STATUS_APPROVED;
//            $userLeave->accepted_at = Carbon::now();
//            $userLeave->accepted_by = auth()->user()->id;
            $userLeave->approve_start_date = $request->start_date;
            $userLeave->approve_end_date = $request->end_date;
            $userLeave->approved_number_of_days = $request->number_of_days;
            $userLeave->updated_by = auth()->user()->id;
            $userLeave->updated_at = Carbon::now();
            $userLeave->save();
        }catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $userLeave = UserLeave::where('id', $id)
                ->where('deleted', UserLeave::DELETED_NO)
                ->first();
            if (!$userLeave) {
                throw new \Exception('Leave not found.');
            }

            $userLeave->deleted = UserLeave::DELETED_YES;
            $userLeave->deleted_at = Carbon::now();
            $userLeave->deleted_by = auth()->user()->id;
            $userLeave->save();
        }catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }
    }

    public function statusApprove($id)
    {
        try {
            $data['userLeave'] = UserLeave::with('user', 'settingsLeaveType')
                ->where('id', $id)
                ->where('deleted', UserLeave::DELETED_NO)
                ->first();
            if (!$data['userLeave']) {
                throw new \Exception('Leave not found.');
            }

            $salarySetEmployee = SettingsSalarySetEmployee::where('employee_id', $data['userLeave']->user_id)
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

            $data['settingsLeaveTypes'] = SettingsLeaveType::whereIn('id', $salarySetLeaveTypes)
                ->where('deleted', SettingsLeaveType::DELETED_NO)
                ->where('status', SettingsLeaveType::STATUS_ACTIVE)
                ->orderBy('title', 'asc')
                ->get();

            return $data;
        }catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }
    }

    public function statusApproveUpdate($id, $request)
    {
        try {
            $userLeave = UserLeave::where('id', $id)
                ->where('deleted', UserLeave::DELETED_NO)
                ->first();
            if (!$userLeave) {
                throw new \Exception('Leave not found.');
            }

            $userLeave->leave_status = UserLeave::LEAVE_STATUS_APPROVED;
            $userLeave->accepted_at = Carbon::now();
            $userLeave->accepted_by = auth()->user()->id;
            $userLeave->approve_start_date = $request->start_date;
            $userLeave->approve_end_date = $request->end_date;
            $userLeave->approved_number_of_days = $request->number_of_days;
            $userLeave->save();
        }catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }
    }

    public function statusReject($id)
    {
        try {
            $data['userLeave'] = UserLeave::with('user', 'settingsLeaveType')
                ->where('id', $id)
                ->where('deleted', UserLeave::DELETED_NO)
                ->first();
            if (!$data['userLeave']) {
                throw new \Exception('Leave not found.');
            }
            return $data;
        }catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }
    }

    public function statusRejectUpdate($id, $request)
    {
        try {
            $userLeave = UserLeave::where('id', $id)
                ->where('deleted', UserLeave::DELETED_NO)
                ->first();
            if (!$userLeave) {
                throw new \Exception('Leave not found.');
            }

            if ($request->reject_reason == null || $request->reject_reason == ''){
                throw new \Exception('Reject reason is required.');
            }

            $userLeave->leave_status = UserLeave::LEAVE_STATUS_REJECTED;
            $userLeave->rejected_at = Carbon::now();
            $userLeave->rejected_by = auth()->user()->id;
            $userLeave->reject_reason = $request->reject_reason;
            $userLeave->save();
        }catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }
    }
}
