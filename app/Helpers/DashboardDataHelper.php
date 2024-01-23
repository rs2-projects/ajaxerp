<?php

namespace App\Helpers;

use App\Models\Department;
use App\Models\SettingsHoliday;
use App\Models\User;
use Carbon\Carbon;

class DashboardDataHelper
{
    public function getTotalDepartmentCount()
    {
        return Department::where('deleted', Department::DELETED_NO)
            ->where('status', Department::STATUS_ACTIVE)
            ->count();
    }

    public function getTotalEmployeeCount()
    {
        return User::where('deleted', User::DELETED_NO)
            ->where('status', User::STATUS_ACTIVE)
            ->whereIn('type',[User::TYPE_EMPLOYEE])
            ->where(function ($q) {
                $q->where('terminated', User::TERMINATED_NO)
                    ->orWhere('terminate_date', '>', Carbon::now());
            })
            ->where(function ($q) {
                $q->where('resigned', User::RESIGNED_NO)
                    ->orWhere('resign_date', '>', Carbon::now());
            })
            ->count();
    }

    public function getNewEmployeeCount($day)
    {
        $old_date = Carbon::now()->subDays($day)->startOfDay();
        return User::where('deleted', User::DELETED_NO)
            ->where('status', User::STATUS_ACTIVE)
            ->whereIn('type',[User::TYPE_EMPLOYEE])
            ->where(function ($q) {
                $q->where('terminated', User::TERMINATED_NO)
                    ->orWhere('terminate_date', '>', Carbon::now());
            })
            ->where(function ($q) {
                $q->where('resigned', User::RESIGNED_NO)
                    ->orWhere('resign_date', '>', Carbon::now());
            })
            ->where('created_at', '>=', $old_date)
            ->count();
    }

    public function getRemainingHolidayCount()
    {
        $start_date = Carbon::now()->format('Y-m-d');
        $end_date = Carbon::now()->endOfYear()->format('Y-m-d');
        return SettingsHoliday::where('deleted', SettingsHoliday::DELETED_NO)
            ->where('status', SettingsHoliday::STATUS_ACTIVE)
            ->where('start_date', '>=', $start_date)
            ->where('end_date', '<=', $end_date)
            ->count();
    }
}
