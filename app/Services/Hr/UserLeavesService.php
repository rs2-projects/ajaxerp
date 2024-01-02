<?php

namespace App\Services\Hr;

use App\Models\SettingsLeaveType;
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
            ->get();

        return $data;
    }

    public function getIndexFilteredData($request)
    {
        $data['userLeaves'] = UserLeave::with('user')
            ->where('deleted', UserLeave::DELETED_NO)
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

}
