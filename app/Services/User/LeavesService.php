<?php

namespace App\Services\User;

use App\Models\SettingsLeaveType;
use App\Models\SettingsSalarySetEmployee;
use App\Models\SettingsSalarySetLeaveType;
use App\Models\UserLeave;
use Carbon\Carbon;

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

    public function getIndexFilteredData($request)
    {
        try {
            $leaveStatus = $request->leave_status??null;
            $auth_user = auth()->user();
            $data['userLeaves'] = UserLeave::with('user')
                ->where('user_id', $auth_user->id)
                ->where(function ($query) use ($leaveStatus) {
                    if ($leaveStatus != null || $leaveStatus != '') {
                        $query->where('leave_status', $leaveStatus);
                    }
                })
                ->where('deleted', UserLeave::DELETED_NO)
                ->where('status', UserLeave::STATUS_ACTIVE)
                ->orderBy('id', 'desc')
                ->paginate($this->paginate_limit);

            return $data;
        }catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }
    }

    public function store($request)
    {
        try {
            $auth_user = auth()->user();

            $userLeave = new UserLeave();
            $userLeave->user_id = $auth_user->id;
            $userLeave->settings_leave_type_id = $request->settings_leave_type_id;
            $userLeave->start_date = $request->start_date;
            $userLeave->end_date = $request->end_date;
            $userLeave->number_of_days = $request->number_of_days;
            $userLeave->leave_status = UserLeave::LEAVE_STATUS_PENDING;
            $userLeave->approve_start_date = $request->start_date;
            $userLeave->approve_end_date = $request->end_date;
            $userLeave->approved_number_of_days = $request->number_of_days;
            $userLeave->reason = $request->reason;
            $userLeave->save();

            return $userLeave;
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

}
