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
use App\Models\UserLeaveDetail;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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

        $data['salarySetEmployee'] = $salarySetEmployee;

        // if (empty($salarySetEmployee)) {
        //     throw new \Exception("Please Contact with Admin For Your Salary Set");
        // }

        $salarySetLeaveTypes = SettingsSalarySetLeaveType::where('settings_salary_set_id', $salarySetEmployee?->settings_salary_set_id)
            ->where('deleted', SettingsSalarySetLeaveType::DELETED_NO)
            ->where('status', SettingsSalarySetLeaveType::STATUS_ACTIVE)
            ->pluck('settings_leave_type_id')->toArray();

        $data['settings_leave_types'] = SettingsLeaveType::whereIn('id', $salarySetLeaveTypes)
            ->where('deleted', SettingsLeaveType::DELETED_NO)
            ->where('status', SettingsLeaveType::STATUS_ACTIVE)
            ->orderBy('title', 'asc')
            ->get();

        $salary_set_employee = SettingsSalarySetEmployee::where('employee_id', $auth_user->id)
            ->where('status', SettingsSalarySetEmployee::STATUS_ACTIVE)
            ->where('deleted', SettingsSalarySetEmployee::DELETED_NO)
            ->first();
        $data['salary_set'] = $salary_set_employee;

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
        DB::beginTransaction();
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
            $get_leave_type_data = LeaveHelper::leaveType($request->settings_leave_type_id);

            $getTotalLeaveYearly = $get_leave_type_data->annual_leave_days;
            $getTotalLeaveMonthly = $get_leave_type_data->max_leave_per_month;

            $getUsedLeaveYearly = LeaveHelper::countEmployeeUsedLeave($auth_user->id, $request->settings_leave_type_id, $request->start_date);
            $getUsedLeaveMonthly = LeaveHelper::countEmployeeUsedLeaveMonth($auth_user->id, $request->settings_leave_type_id, $request->start_date);

            $getRemainingLeaveYearly = $getTotalLeaveYearly - $getUsedLeaveYearly;
            $getRemainingLeaveMonthly = $getTotalLeaveMonthly - $getUsedLeaveMonthly;

            if ($getRemainingLeaveYearly < $getRemainingLeaveMonthly) {
                $max_usable_paid_leave = $getRemainingLeaveYearly;
            }else{
                $max_usable_paid_leave = $getRemainingLeaveMonthly;
            }

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

            // while loop start end date
            $start_date = Carbon::make($request->start_date);
            $end_date = Carbon::make($request->end_date);

            $paid_leave_start_date = null;
            $paid_leave_end_date = null;
            $paid_leave_number_of_days = 0;

            $unpaid_leave_start_date = null;
            $unpaid_leave_end_date = null;
            $unpaid_leave_number_of_days = 0;

            while ($start_date->lte($end_date)) {
                $check_day_type_holiday = LeaveHelper::checkDateIsHoliday($start_date);
                $check_day_type_weekend = LeaveHelper::checkDateIsWeekend($salary_set->settings_office_time_type_id, $start_date);
                $dayType = UserLeaveDetail::DAY_TYPE_GENERAL;

                if ($check_day_type_holiday) {
                    $dayType = UserLeaveDetail::DAY_TYPE_HOLIDAY;
                } elseif ($check_day_type_weekend) {
                    $dayType = UserLeaveDetail::DAY_TYPE_WEEKEND;
                }

                $is_paid = UserLeave::IS_PAID_NO;
                if($max_usable_paid_leave > $paid_leave_number_of_days) {
                    if($paid_leave_start_date == null) {
                        $paid_leave_start_date = $start_date->format('Y-m-d');
                    }
                    $paid_leave_end_date = $start_date->format('Y-m-d');
                    if ($dayType == UserLeaveDetail::DAY_TYPE_GENERAL) {
                        $paid_leave_number_of_days++;
                    }

                    $is_paid = UserLeave::IS_PAID_YES;
                } else {
                    if($unpaid_leave_start_date == null) {
                        $unpaid_leave_start_date = $start_date->format('Y-m-d');
                    }
                    $unpaid_leave_end_date = $start_date->format('Y-m-d');
                    if ($dayType == UserLeaveDetail::DAY_TYPE_GENERAL) {
                        $unpaid_leave_number_of_days++;
                    }
                }

                $userLeaveDetail = new UserLeaveDetail();
                $userLeaveDetail->user_id = $auth_user->id;
                $userLeaveDetail->settings_leave_type_id = $request->settings_leave_type_id;
                $userLeaveDetail->user_leave_id = $userLeave->id;
                $userLeaveDetail->date = $start_date->format('Y-m-d');
                $userLeaveDetail->day_type = $dayType;
                $userLeaveDetail->is_paid = $is_paid;
                $userLeaveDetail->leave_status = UserLeaveDetail::LEAVE_STATUS_PENDING;
                $userLeaveDetail->created_at = Carbon::now();
                $userLeaveDetail->created_by = $auth_user->id;
                $userLeaveDetail->updated_at = Carbon::now();
                $userLeaveDetail->updated_by = $auth_user->id;
                $userLeaveDetail->save();

                $start_date->addDay();
            }

            $userLeave->paid_leave_start_date = $paid_leave_start_date;
            $userLeave->paid_leave_end_date = $paid_leave_end_date;
            $userLeave->paid_leave_number_of_days = $paid_leave_number_of_days;
            $userLeave->unpaid_leave_start_date = $unpaid_leave_start_date;
            $userLeave->unpaid_leave_end_date = $unpaid_leave_end_date;
            $userLeave->unpaid_leave_number_of_days = $unpaid_leave_number_of_days;
            $userLeave->save();


        }catch (\Exception $exception) {
            DB::rollBack();
            throw new \Exception($exception->getMessage());
        }
        DB::commit();
        return $userLeave;
    }

    public function delete($id)
    {
        DB::beginTransaction();
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

            $userLeaveDetails = UserLeaveDetail::where('user_leave_id', $userLeave->id)
                ->get();
            foreach ($userLeaveDetails as $userLeaveDetail) {
                $userLeaveDetail->deleted = UserLeaveDetail::DELETED_YES;
                $userLeaveDetail->deleted_at = Carbon::now();
                $userLeaveDetail->deleted_by = auth()->user()->id;
                $userLeaveDetail->save();
            }

        }catch (\Exception $exception) {
            DB::rollBack();
            throw new \Exception($exception->getMessage());
        }
        DB::commit();
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
