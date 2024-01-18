<?php

namespace App\Services\Hr;

use App\Helpers\AttendanceHelper;
use App\Helpers\AttendanceHistoryHelper;
use App\Models\AttendanceHistory;
use App\Models\AttendanceHistoryToday;
use App\Models\AttendanceReport;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class EmployeeAttendanceService
{

    public function indexData($request)
    {
        $data['employees'] = User::with('settingsSalarySetEmployee')
            ->whereHas('settingsSalarySetEmployee')
            ->where('status', User::STATUS_ACTIVE)
            ->where('deleted', User::DELETED_NO)
            ->where('role', User::ROLE_EMPLOYEE)
            ->where('type', User::TYPE_EMPLOYEE)
            ->where('is_contracted', User::CONTRACTED_NO)
            ->orderBy('first_name', 'asc')
            ->get();

        if (!empty($request->employee_id_search)){

            $data['getEmployees'] = User::with('settingsSalarySetEmployee')
                ->where('id', $request->employee_id_search)
                ->whereHas('settingsSalarySetEmployee')
                ->where('status', User::STATUS_ACTIVE)
                ->where('deleted', User::DELETED_NO)
                ->where('role', User::ROLE_EMPLOYEE)
                ->where('type', User::TYPE_EMPLOYEE)
                ->where('is_contracted', User::CONTRACTED_NO)
                ->orderBy('first_name', 'asc')
                ->get();
        }else{
            $data['getEmployees'] = User::with('settingsSalarySetEmployee')
                ->whereHas('settingsSalarySetEmployee')
                ->where('status', User::STATUS_ACTIVE)
                ->where('deleted', User::DELETED_NO)
                ->where('role', User::ROLE_EMPLOYEE)
                ->where('type', User::TYPE_EMPLOYEE)
                ->where('is_contracted', User::CONTRACTED_NO)
                ->orderBy('first_name', 'asc')
                ->get();
        }

        if (!empty($request->start_date)) {
            $start_date = $request->start_date;
        } else {
            $start_date = Carbon::now()->startOfMonth()->format('Y-m-d');
        }
        if (!empty($request->end_date)) {
            $end_date = $request->end_date;
        } else {
            $end_date = Carbon::now()->format('Y-m-d');
        }

        $data['result_dates'] = AttendanceHelper::getAllDatesBetweenTowDates($start_date, $end_date);

        return $data;
    }

    public function bulkAttendanceStore($request)
    {
        DB::beginTransaction();
        try {
            $auth_user = auth()->user();
            $date = $request->date;
            $time_in = $request->time_in;
            $time_out = $request->time_out;

            $formatted_date_time_in = $date . ' ' . $time_in;
            $formatted_date_time_out = $date . ' ' . $time_out;

            $employee_ids = $request->employee_ids;

            foreach ($employee_ids as $employee_id) {

                $attendance_history_today = new AttendanceHistoryToday();
                $attendance_history_today->employee_id = $employee_id;
                $attendance_history_today->datetime = $formatted_date_time_in;
                $attendance_history_today->type = AttendanceHistoryToday::TYPE_IN;
                $attendance_history_today->latitude = null;
                $attendance_history_today->longitude = null;
                $attendance_history_today->attendance_by = AttendanceHistoryToday::ATTENDANCE_BY_ADMIN;
                $attendance_history_today->settings_geo_location_id = null;
                $attendance_history_today->created_at = Carbon::now();
                $attendance_history_today->created_by = $auth_user->id;
                $attendance_history_today->updated_at = Carbon::now();
                $attendance_history_today->updated_by = $auth_user->id;
                $attendance_history_today->save();

                $attendance_history_today = new AttendanceHistoryToday();
                $attendance_history_today->employee_id = $employee_id;
                $attendance_history_today->datetime = $formatted_date_time_out;
                $attendance_history_today->type = AttendanceHistoryToday::TYPE_OUT;
                $attendance_history_today->latitude = null;
                $attendance_history_today->longitude = null;
                $attendance_history_today->attendance_by = AttendanceHistoryToday::ATTENDANCE_BY_ADMIN;
                $attendance_history_today->settings_geo_location_id = null;
                $attendance_history_today->created_at = Carbon::now();
                $attendance_history_today->created_by = $auth_user->id;
                $attendance_history_today->updated_at = Carbon::now();
                $attendance_history_today->updated_by = $auth_user->id;
                $attendance_history_today->save();

                $attendance_history = new AttendanceHistory();
                $attendance_history->employee_id =$employee_id;
                $attendance_history->datetime = $formatted_date_time_in;
                $attendance_history->type = AttendanceHistory::TYPE_IN;
                $attendance_history->latitude = null;
                $attendance_history->longitude = null;
                $attendance_history->attendance_by = AttendanceHistory::ATTENDANCE_BY_ADMIN;
                $attendance_history->settings_geo_location_id = null;
                $attendance_history->created_at = Carbon::now();
                $attendance_history->created_by = $auth_user->id;
                $attendance_history->updated_at = Carbon::now();
                $attendance_history->updated_by = $auth_user->id;
                $attendance_history->save();

                $attendance_history = new AttendanceHistory();
                $attendance_history->employee_id =$employee_id;
                $attendance_history->datetime = $formatted_date_time_out;
                $attendance_history->type = AttendanceHistory::TYPE_OUT;
                $attendance_history->latitude = null;
                $attendance_history->longitude = null;
                $attendance_history->attendance_by = AttendanceHistory::ATTENDANCE_BY_ADMIN;
                $attendance_history->settings_geo_location_id = null;
                $attendance_history->created_at = Carbon::now();
                $attendance_history->created_by = $auth_user->id;
                $attendance_history->updated_at = Carbon::now();
                $attendance_history->updated_by = $auth_user->id;
                $attendance_history->save();

                $attendance_report = AttendanceHistoryHelper::attendanceReportCreateOrUpdate($attendance_history->employee_id, $attendance_history->datetime, 2);

            }

        }catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
        DB::commit();
        return $attendance_report;
    }

    public function attendanceStore($request)
    {
        DB::beginTransaction();
        try {

            $auth_user = auth()->user();
            $date = $request->date;
            $employee_id = $request->employee;

            foreach ($request->flag as $key => $value){

                $formatted_date_time = $date . ' ' . $request->time[$key];

                $attendance_history_today = new AttendanceHistoryToday();
                $attendance_history_today->employee_id = $employee_id;
                $attendance_history_today->datetime = $formatted_date_time;
                $attendance_history_today->type = $value;
                $attendance_history_today->latitude = null;
                $attendance_history_today->longitude = null;
                $attendance_history_today->attendance_by = AttendanceHistoryToday::ATTENDANCE_BY_ADMIN;
                $attendance_history_today->settings_geo_location_id = null;
                $attendance_history_today->created_at = Carbon::now();
                $attendance_history_today->created_by = $auth_user->id;
                $attendance_history_today->updated_at = Carbon::now();
                $attendance_history_today->updated_by = $auth_user->id;
                $attendance_history_today->save();

                $attendance_history = new AttendanceHistory();
                $attendance_history->employee_id =$employee_id;
                $attendance_history->datetime = $formatted_date_time;
                $attendance_history->type = $value;
                $attendance_history->latitude = null;
                $attendance_history->longitude = null;
                $attendance_history->attendance_by = AttendanceHistory::ATTENDANCE_BY_ADMIN;
                $attendance_history->settings_geo_location_id = null;
                $attendance_history->created_at = Carbon::now();
                $attendance_history->created_by = $auth_user->id;
                $attendance_history->updated_at = Carbon::now();
                $attendance_history->updated_by = $auth_user->id;
                $attendance_history->save();
            }

            $attendance_report = AttendanceHistoryHelper::attendanceReportCreateOrUpdate($employee_id, $date, 2);

        }catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
        DB::commit();

        return $attendance_report;

    }
    public function getEmployeesByAttendanceDate($request)
    {
        $date = $request->date;
        $data['employees'] = User::with('settingsSalarySetEmployee')
            ->whereHas('settingsSalarySetEmployee')
            ->where('status', User::STATUS_ACTIVE)
            ->where('deleted', User::DELETED_NO)
            ->where('role', User::ROLE_EMPLOYEE)
            ->where('type', User::TYPE_EMPLOYEE)
            ->where('is_contracted', User::CONTRACTED_NO)
            ->orderBy('first_name', 'asc')
            ->get()
            ->map(function ($employee) use ($date) {
                $attendance_history = AttendanceHistory::where('employee_id', $employee->id)
                    ->whereDate('datetime', $date)
                    ->first();
                $has_attendance = false;
                if ($attendance_history) {
                    $has_attendance = true;
                }

                return [
                    'id' => $employee->id,
                    'name' => $employee->first_name . ' ' . $employee->last_name,
                    'has_attendance' => $has_attendance,
                ];
            });

        return $data;
    }

    public function getEmployeeAttendanceActivityDetailsByDate($request)
    {
        try {
            $date = $request->date;
            $attendance_history_table = new AttendanceHistory();

            $first_punch_in = $attendance_history_table->where('employee_id', $request->employee_id)
                ->whereDate('datetime', $request->date)
                ->where('type', $attendance_history_table::TYPE_IN)
                ->first();
            $last_punch_out = $attendance_history_table->where('employee_id', $request->employee_id)
                ->whereDate('datetime', $request->date)
                ->where('type', $attendance_history_table::TYPE_OUT)
                ->orderBy('datetime', 'DESC')
                ->first();
            $activity_history = $attendance_history_table->where('employee_id', $request->employee_id)
                ->whereDate('datetime', $request->date)
                ->get();

            if (count($activity_history) > 0) {
                $last_activity = $activity_history->last();
                $last_flag = $last_activity->type;
                $last_activity_time = Carbon::parse($last_activity->datetime)->format('H:i');
            } else {
                $last_activity = null;
                $last_flag = $attendance_history_table::TYPE_OUT;
                $last_activity_time = "0:00";
            }

            $data = [
              'first_punch_in' => $first_punch_in,
                'last_punch_out' => $last_punch_out,
                'activity_history' => $activity_history,
                'date' => $date,
                'last_flag' => $last_flag,
                'last_activity' => $last_activity,
                'last_activity_time' => $last_activity_time
            ];
            return $data;

        }catch (\Exception $exception) {
            throw $exception;
        }
    }
}
