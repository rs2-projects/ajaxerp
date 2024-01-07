<?php

namespace App\Services\User;

use App\Models\SettingsSalarySet;
use App\Models\SettingsSalarySetEmployee;

class AttendanceService
{
    public function __construct()
    {
        $this->paginate_limit = config('commonData.paginate_limit');
    }

    public function punch($request)
    {
        $auth_user = auth()->user();
        $actionType = $request->action??null;
        if ($actionType == null || $actionType == '') {
            throw new \Exception("Invalid Action");
        }
        $getEmployeeSalarySet = SettingsSalarySetEmployee::where('employee_id', $auth_user->id)
            ->where('deleted', SettingsSalarySetEmployee::DELETED_NO)
            ->where('status', SettingsSalarySetEmployee::STATUS_ACTIVE)
            ->first();
        if (empty($getEmployeeSalarySet)) {
            throw new \Exception("Please Contact with Admin For Your Salary Set");
        }

        $getSalarySet = SettingsSalarySet::where('id', $getEmployeeSalarySet->settings_salary_set_id)
            ->where('deleted', SettingsSalarySet::DELETED_NO)
            ->where('status', SettingsSalarySet::STATUS_ACTIVE)
            ->first();
        if (empty($getSalarySet)) {
            throw new \Exception("Please Contact with Admin For Your Salary Set");
        }

        if ($getSalarySet->attendance_type_location == SettingsSalarySet::ATTENDANCE_TYPE_LOCATION_IN_GEO) {
            $latitude = $request->latitude??null;
            $longitude = $request->longitude??null;
            if ($latitude == null || $latitude == '' || $longitude == null || $longitude == '') {
                throw new \Exception("Invalid Location");
            }
            $distance = $this->distance($getSalarySet->latitude, $getSalarySet->longitude, $latitude, $longitude, "K");
            if ($distance > $getSalarySet->attendance_type_location_distance) {
                throw new \Exception("You are not in office");
            }
        }

        return $getSalarySet;

        $userAttendance = UserAttendance::where('user_id', $auth_user->id)
            ->where('date', Carbon::now()->format('Y-m-d'))
            ->where('deleted', UserAttendance::DELETED_NO)
            ->where('status', UserAttendance::STATUS_ACTIVE)
            ->first();
        if (!empty($userAttendance)) {
            throw new \Exception("Attendance Already Created");
        }

        $userAttendance = new UserAttendance();
        $userAttendance->user_id = $auth_user->id;
        $userAttendance->date = Carbon::now()->format('Y-m-d');
        $userAttendance->time = Carbon::now()->format('H:i:s');
        $userAttendance->save();
    }
}
