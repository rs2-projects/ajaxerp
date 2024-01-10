<?php

namespace App\Helpers\AttendanceHelper;

use App\Models\UserLeave;
use Carbon\Carbon;

class AttendanceLeaveHelper
{
    public static function getLeaveDetails($employee_id, $date)
    {
        $check_leave = UserLeave::where('user_id', $employee_id)
            ->where('status', UserLeave::STATUS_ACTIVE)
            ->where('deleted', UserLeave::DELETED_NO)
            ->where('leave_status', UserLeave::LEAVE_STATUS_APPROVED)
            ->where('start_date', '<=', $date)
            ->where('end_date', '>=', $date)
            ->first();
        if (!empty($check_leave)) {
            return true;
        }
        return false;
    }

    public static function getUserRemainingLeaves($user_id, $leave_type_id, $user_leave_id = null)
    {
        $startOfYear = Carbon::now()->startOfYear()->format('Y-m-d');
        $endOfYear = Carbon::now()->endOfYear()->format('Y-m-d');

        $user_leaves = UserLeave::where('user_id', $user_id)
            ->where('leave_type_id', $leave_type_id)
            ->where('status', UserLeave::STATUS_ACTIVE)
            ->where('deleted', UserLeave::DELETED_NO)
            ->where('leave_status', UserLeave::LEAVE_STATUS_APPROVED)
            ->where('approve_start_date', '>=', $startOfYear)
            ->where('approve_end_date', '<=', $endOfYear)
            ->where(function ($query) use ($user_leave_id) {
                if (!empty($user_leave_id)) {
                    $query->where('id', '!=', $user_leave_id);
                }
            })
            ->get();

        $total_leave = 0;
        foreach ($user_leaves as $leave) {
            $total_leave += $leave->approved_number_of_days;
        }

        return $total_leave;

    }

}
