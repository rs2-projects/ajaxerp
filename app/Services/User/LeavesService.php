<?php

namespace App\Services\User;

use App\Helpers\AttendanceHelper;
use App\Helpers\LeaveHelper;
use App\Helpers\SalarySetHelper;
use App\Models\SettingsHoliday;
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

            $checkUserLeave = UserLeave::where('user_id', $auth_user->id)
                ->where('deleted', UserLeave::DELETED_NO)
                ->whereIn('leave_status', [UserLeave::LEAVE_STATUS_APPROVED, UserLeave::LEAVE_STATUS_PENDING])
                ->where(function ($q) use ($request) {
                    $q->where(function ($q) use ($request) {
                            $q->whereDate('approve_start_date', '>=', $request->start_date)
                                ->whereDate('approve_end_date', '<=', $request->start_date);
                        })
                        ->orWhere(function ($q) use ($request) {
                            $q->whereDate('approve_start_date', '>=', $request->end_date)
                                ->whereDate('approve_end_date', '<=', $request->end_date);
                        })
                        ->orWhere(function ($q) use ($request) {
                            $q->whereDate('approve_start_date', '>=', $request->start_date)
                                ->whereDate('approve_end_date', '<=', $request->end_date);
                        });
                })

                ->first();
            if ($checkUserLeave) {
                throw new \Exception('You have already applied for leave in this date range.');
            }

            $general_number_of_days =  LeaveHelper::countEmployeeGeneralDays($auth_user->id, $request->start_date, $request->end_date);
            $salary_set = SalarySetHelper::getEmployeeSalarySet($auth_user->id);


            $userLeave = new UserLeave();
            $userLeave->user_id = $auth_user->id;
            $userLeave->settings_leave_type_id = $request->settings_leave_type_id;
            $userLeave->start_date = $request->start_date;
            $userLeave->end_date = $request->end_date;
            $userLeave->number_of_days = $general_number_of_days;
            $userLeave->leave_status = UserLeave::LEAVE_STATUS_PENDING;
            $userLeave->approve_start_date = $request->start_date;
            $userLeave->approve_end_date = $request->end_date;
            $userLeave->approved_number_of_days = $general_number_of_days;
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

    public function getUserLeaveNumberOfDays($request)
    {
        try {

            $user_id = $request->user_id??null;
            $start_date = $request->start_date??null;
            $end_date = $request->end_date??null;
            if ($user_id == null){
                throw new \Exception('User not found.');
            }
            if ($start_date == null){
                throw new \Exception('Start date not found.');
            }
            if ($end_date == null){
                throw new \Exception('End date not found.');
            }

            $data['general_days_number'] = LeaveHelper::countEmployeeGeneralDays($user_id, $start_date, $end_date);
            return $data;


        }catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }
    }

}
