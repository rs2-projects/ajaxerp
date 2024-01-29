<?php

namespace App\Services\Hr;

use App\Helpers\AttendanceHelper\AttendanceLeaveHelper;
use App\Helpers\AttendanceHistoryHelper;
use App\Helpers\LeaveHelper;
use App\Helpers\SalarySetHelper;
use App\Models\SettingsLeaveType;
use App\Models\SettingsSalarySetEmployee;
use App\Models\SettingsSalarySetLeaveType;
use App\Models\User;
use App\Models\UserLeave;
use App\Models\UserLeaveDetail;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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
        DB::beginTransaction();
        try {
            $check_user = User::where('id', $request->user_id)->first();
            if (!$check_user) {
                throw new \Exception('User not found.');
            }

            $checkUserLeave = UserLeave::where('user_id', $check_user->id)
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


            $check_leave_type = SettingsLeaveType::where('id', $request->settings_leave_type_id)->first();
            if (!$check_leave_type) {
                throw new \Exception('Leave type not found.');
            }

            //TODO: calculate number of days based on start and end date instead of using number_of_days from request

            $general_number_of_days =  LeaveHelper::countEmployeeGeneralDays($check_user->id, $request->start_date, $request->end_date);
            $salary_set = SalarySetHelper::getEmployeeSalarySet($check_user->id);
            $get_leave_type_data = LeaveHelper::leaveType($request->settings_leave_type_id);

            $getTotalLeaveYearly = $get_leave_type_data->annual_leave_days;
            $getTotalLeaveMonthly = $get_leave_type_data->max_leave_per_month;

            $getUsedLeaveYearly = LeaveHelper::countEmployeeUsedLeave($check_user->id, $request->settings_leave_type_id, $request->start_date);
            $getUsedLeaveMonthly = LeaveHelper::countEmployeeUsedLeaveMonth($check_user->id, $request->settings_leave_type_id, $request->start_date);

            $getRemainingLeaveYearly = $getTotalLeaveYearly - $getUsedLeaveYearly;
            $getRemainingLeaveMonthly = $getTotalLeaveMonthly - $getUsedLeaveMonthly;

            if ($getRemainingLeaveYearly < $getRemainingLeaveMonthly) {
                $max_usable_paid_leave = $getRemainingLeaveYearly;
            }else{
                $max_usable_paid_leave = $getRemainingLeaveMonthly;
            }


            $userLeave = new UserLeave();
            $userLeave->user_id = $request->user_id;
            $userLeave->settings_leave_type_id = $request->settings_leave_type_id;
            $userLeave->start_date = $request->start_date;
            $userLeave->end_date = $request->end_date;
            $userLeave->number_of_days = $general_number_of_days;
            $userLeave->reason = $request->reason;
            $userLeave->leave_status = UserLeave::LEAVE_STATUS_APPROVED;
            $userLeave->accepted_at = Carbon::now();
            $userLeave->accepted_by = auth()->user()->id;
            $userLeave->approve_start_date = $request->start_date;
            $userLeave->approve_end_date = $request->end_date;
            $userLeave->approved_number_of_days = $general_number_of_days;
            $userLeave->created_by = auth()->user()->id;
            $userLeave->created_at = Carbon::now();
            $userLeave->updated_by = auth()->user()->id;
            $userLeave->updated_at = Carbon::now();
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
                        $unpaid_leave_start_date =$start_date->format('Y-m-d');
                    }
                    $unpaid_leave_end_date = $start_date->format('Y-m-d');
                    if ($dayType == UserLeaveDetail::DAY_TYPE_GENERAL) {
                        $unpaid_leave_number_of_days++;
                    }
                }

                $userLeaveDetail = new UserLeaveDetail();
                $userLeaveDetail->user_id = $check_user->id;
                $userLeaveDetail->settings_leave_type_id = $request->settings_leave_type_id;
                $userLeaveDetail->user_leave_id = $userLeave->id;
                $userLeaveDetail->date = $start_date->format('Y-m-d');
                $userLeaveDetail->day_type = $dayType;
                $userLeaveDetail->is_paid = $is_paid;
                $userLeaveDetail->leave_status = UserLeaveDetail::LEAVE_STATUS_APPROVED;
                $userLeaveDetail->created_at = Carbon::now();
                $userLeaveDetail->created_by = auth()->user()->id;
                $userLeaveDetail->updated_at = Carbon::now();
                $userLeaveDetail->updated_by = auth()->user()->id;
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
        DB::beginTransaction();
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

            $check_user = User::where('id', $request->user_id)->first();
            if (!$check_user) {
                throw new \Exception('User not found.');
            }

            $checkUserLeave = UserLeave::where('user_id', $check_user->id)
                ->where('id', '!=', $userLeave->id)
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

            $general_number_of_days =  LeaveHelper::countEmployeeGeneralDays($check_user->id, $request->start_date, $request->end_date);
            $salary_set = SalarySetHelper::getEmployeeSalarySet($check_user->id);
            $get_leave_type_data = LeaveHelper::leaveType($request->settings_leave_type_id);

            $getTotalLeaveYearly = $get_leave_type_data->annual_leave_days;
            $getTotalLeaveMonthly = $get_leave_type_data->max_leave_per_month;

            $getUsedLeaveYearly = LeaveHelper::countEmployeeUsedLeave($check_user->id, $request->settings_leave_type_id, $request->start_date, $userLeave->id);
            $getUsedLeaveMonthly = LeaveHelper::countEmployeeUsedLeaveMonth($check_user->id, $request->settings_leave_type_id, $request->start_date, $userLeave->id);

            $getRemainingLeaveYearly = $getTotalLeaveYearly - $getUsedLeaveYearly;
            $getRemainingLeaveMonthly = $getTotalLeaveMonthly - $getUsedLeaveMonthly;

            if ($getRemainingLeaveYearly < $getRemainingLeaveMonthly) {
                $max_usable_paid_leave = $getRemainingLeaveYearly;
            }else{
                $max_usable_paid_leave = $getRemainingLeaveMonthly;
            }


            $userLeave->settings_leave_type_id = $request->settings_leave_type_id;
            $userLeave->start_date = $request->start_date;
            $userLeave->end_date = $request->end_date;
            $userLeave->number_of_days = $general_number_of_days;
            $userLeave->reason = $request->reason;
//            $userLeave->leave_status = UserLeave::LEAVE_STATUS_APPROVED;
//            $userLeave->accepted_at = Carbon::now();
//            $userLeave->accepted_by = auth()->user()->id;
            $userLeave->approve_start_date = $request->start_date;
            $userLeave->approve_end_date = $request->end_date;
            $userLeave->approved_number_of_days = $general_number_of_days;
            $userLeave->updated_by = auth()->user()->id;
            $userLeave->updated_at = Carbon::now();
            $userLeave->save();

            $rq_start_date = Carbon::make($request->start_date);
            $rq_end_date = Carbon::make($request->end_date);

            $rq_dates_array = [];
            while ($rq_start_date->lte($rq_end_date)) {
                $rq_dates_array[] = $rq_start_date->format('Y-m-d');
                $rq_start_date->addDay();
            }

            $deleteUserDetails = UserLeaveDetail::where('user_leave_id', $userLeave->id)
                ->whereNotIn('date', $rq_dates_array)
                ->delete();

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
                        $unpaid_leave_start_date =$start_date->format('Y-m-d');
                    }
                    $unpaid_leave_end_date = $start_date->format('Y-m-d');
                    if ($dayType == UserLeaveDetail::DAY_TYPE_GENERAL) {
                        $unpaid_leave_number_of_days++;
                    }
                }
                $userLeaveDetail = UserLeaveDetail::where('user_leave_id', $userLeave->id)
                    ->where('date', $start_date->format('Y-m-d'))
                    ->first();
                if (empty($userLeaveDetail)){
                    $userLeaveDetail = new UserLeaveDetail();
                    $userLeaveDetail->created_at = Carbon::now();
                    $userLeaveDetail->created_by = auth()->user()->id;
                }

                $userLeaveDetail->user_id = $check_user->id;
                $userLeaveDetail->settings_leave_type_id = $request->settings_leave_type_id;
                $userLeaveDetail->user_leave_id = $userLeave->id;
                $userLeaveDetail->date = $start_date->format('Y-m-d');
                $userLeaveDetail->day_type = $dayType;
                $userLeaveDetail->is_paid = $is_paid;
                $userLeaveDetail->updated_at = Carbon::now();
                $userLeaveDetail->updated_by = auth()->user()->id;
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
        DB::beginTransaction();
        try {
            $userLeave = UserLeave::where('id', $id)
                ->where('deleted', UserLeave::DELETED_NO)
                ->first();
            if (!$userLeave) {
                throw new \Exception('Leave not found.');
            }

            $check_user = User::where('id', $userLeave->user_id)->first();
            if (!$check_user) {
                throw new \Exception('User not found.');
            }

            $checkUserLeave = UserLeave::where('user_id', $check_user->id)
                ->where('id', '!=', $userLeave->id)
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

            $general_number_of_days =  LeaveHelper::countEmployeeGeneralDays($check_user->id, $request->start_date, $request->end_date);
            $salary_set = SalarySetHelper::getEmployeeSalarySet($check_user->id);
            $get_leave_type_data = LeaveHelper::leaveType($userLeave->settings_leave_type_id);

            $getTotalLeaveYearly = $get_leave_type_data->annual_leave_days;
            $getTotalLeaveMonthly = $get_leave_type_data->max_leave_per_month;

            $getUsedLeaveYearly = LeaveHelper::countEmployeeUsedLeave($check_user->id, $userLeave->settings_leave_type_id, $request->start_date, $userLeave->id);
            $getUsedLeaveMonthly = LeaveHelper::countEmployeeUsedLeaveMonth($check_user->id, $userLeave->settings_leave_type_id, $request->start_date, $userLeave->id);

            $getRemainingLeaveYearly = $getTotalLeaveYearly - $getUsedLeaveYearly;
            $getRemainingLeaveMonthly = $getTotalLeaveMonthly - $getUsedLeaveMonthly;

            if ($getRemainingLeaveYearly < $getRemainingLeaveMonthly) {
                $max_usable_paid_leave = $getRemainingLeaveYearly;
            }else{
                $max_usable_paid_leave = $getRemainingLeaveMonthly;
            }

            $userLeave->leave_status = UserLeave::LEAVE_STATUS_APPROVED;
            $userLeave->accepted_at = Carbon::now();
            $userLeave->accepted_by = auth()->user()->id;
            $userLeave->approve_start_date = $request->start_date;
            $userLeave->approve_end_date = $request->end_date;
            $userLeave->approved_number_of_days = $general_number_of_days;
            $userLeave->save();

            $rq_start_date = Carbon::make($request->start_date);
            $rq_end_date = Carbon::make($request->end_date);

            $rq_dates_array = [];
            while ($rq_start_date->lte($rq_end_date)) {
                $rq_dates_array[] = $rq_start_date->format('Y-m-d');
                $rq_start_date->addDay();
            }

            $deleteUserDetails = UserLeaveDetail::where('user_leave_id', $userLeave->id)
                ->whereNotIn('date', $rq_dates_array)
                ->delete();

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
                        $unpaid_leave_start_date =$start_date->format('Y-m-d');
                    }
                    $unpaid_leave_end_date = $start_date->format('Y-m-d');
                    if ($dayType == UserLeaveDetail::DAY_TYPE_GENERAL) {
                        $unpaid_leave_number_of_days++;
                    }
                }
                $userLeaveDetail = UserLeaveDetail::where('user_leave_id', $userLeave->id)
                    ->where('date', $start_date->format('Y-m-d'))
                    ->first();
                if (empty($userLeaveDetail)){
                    $userLeaveDetail = new UserLeaveDetail();
                    $userLeaveDetail->created_at = Carbon::now();
                    $userLeaveDetail->created_by = auth()->user()->id;
                }

                $userLeaveDetail->user_id = $check_user->id;
                $userLeaveDetail->settings_leave_type_id = $userLeave->settings_leave_type_id;
                $userLeaveDetail->user_leave_id = $userLeave->id;
                $userLeaveDetail->date = $start_date->format('Y-m-d');
                $userLeaveDetail->day_type = $dayType;
                $userLeaveDetail->is_paid = $is_paid;
                $userLeaveDetail->leave_status = UserLeaveDetail::LEAVE_STATUS_APPROVED;
                $userLeaveDetail->updated_at = Carbon::now();
                $userLeaveDetail->updated_by = auth()->user()->id;
                $userLeaveDetail->save();

                // call attendanceReportCreateOrUpdate function
                AttendanceHistoryHelper::attendanceReportCreateOrUpdate($check_user->id, $start_date->format('Y-m-d'), 2);

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
        DB::beginTransaction();
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

            $userLeaveDetails = UserLeaveDetail::where('user_leave_id', $userLeave->id)
                ->get();

            foreach ($userLeaveDetails as $userLeaveDetail) {
                $userLeaveDetail->leave_status = UserLeaveDetail::LEAVE_STATUS_REJECTED;
                $userLeaveDetail->save();
            }

        }catch (\Exception $exception) {
            DB::rollBack();
            throw new \Exception($exception->getMessage());
        }

        DB::commit();
    }
}
