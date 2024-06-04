<?php

namespace App\Services\User;

use App\Helpers\AttendanceHelper;
use App\Helpers\AttendanceHelper\AttendanceLateEarlyHelper;
use App\Helpers\AttendanceHistoryHelper;
use App\Helpers\OvertimeHelper;
use App\Helpers\PolygonAreaHelpler;
use App\Models\AttendanceHistory;
use App\Models\AttendanceHistoryToday;
use App\Models\AttendanceReport;
use App\Models\SettingsGeoLocation;
use App\Models\SettingsSalarySet;
use App\Models\SettingsSalarySetAttendanceLocation;
use App\Models\SettingsSalarySetEmployee;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AttendanceService
{
    public function __construct()
    {
        $this->paginate_limit = config('commonData.paginate_limit');
    }

    public function indexData($request)
    {
        $auth_user = auth()->user();
        $data['last_punch'] = AttendanceHistoryToday::where('employee_id', $auth_user->id)
            ->where('deleted', AttendanceHistoryToday::DELETED_NO)
            ->whereDate('datetime', Carbon::now()->format('Y-m-d'))
            ->orderBy('id', 'desc')
            ->first();
        if ($data['last_punch']) {
            if ($data['last_punch']->type == $data['last_punch']::TYPE_IN) {
                $data['new_punch_type'] = $data['last_punch']::TYPE_OUT;

            } else {
                $data['new_punch_type'] = $data['last_punch']::TYPE_IN;
            }
        }else{
            $data['new_punch_type'] = AttendanceHistoryToday::TYPE_IN;
        }

        if($data['last_punch'] && $data['last_punch']->type == AttendanceHistoryToday::TYPE_IN) {
            $data['working_hours'] = (Carbon::now())->diff(new Carbon($data['last_punch']->datetime))->format('%h:%I');
        }else{
            $data['working_hours'] = '0:00';
        }

        $data['attendance_history_today'] = AttendanceHistoryToday::where('employee_id', $auth_user->id)
            ->where('deleted', AttendanceHistoryToday::DELETED_NO)
            ->whereDate('datetime', Carbon::now()->format('Y-m-d'))
            ->get();

        $data['overtime'] = OvertimeHelper::getOvertime($auth_user->id, Carbon::now()->format('Y-m-d'));

        if (($request->month != '') && ($request->year != '')) {
            $alDate = $request->year.'-'.$request->month.'-1';
            if($request->year == date('Y') && ($request->month == date('m'))) {
                $data['attendance_list_start_date'] = Carbon::now()->startOfMonth();
                $data['attendance_list_end_date'] = Carbon::now();
            } else {
                $data['attendance_list_start_date'] = Carbon::make($alDate)->startOfMonth();
                $data['attendance_list_end_date'] = Carbon::make($alDate)->endOfMonth();
            }
        } else {
            $data['attendance_list_start_date'] = Carbon::now()->startOfMonth();
            $data['attendance_list_end_date'] = Carbon::now();
        }

        $data['attendance_reports'] = AttendanceReport::where('employee_id', $auth_user->id)
            ->where('deleted', AttendanceReport::DELETED_NO)
            ->whereBetween('date', [$data['attendance_list_start_date']->format('Y-m-d'), $data['attendance_list_end_date']->format('Y-m-d')])
            ->get();

        $data['months'] = config('commonData.month_names');

        $salary_set_employee = SettingsSalarySetEmployee::where('employee_id', $auth_user->id)
            ->where('status', SettingsSalarySetEmployee::STATUS_ACTIVE)
            ->where('deleted', SettingsSalarySetEmployee::DELETED_NO)
            ->first();
        $data['salary_set'] = $salary_set_employee;

        return $data;
    }
    public function punch($request)
    {
        DB::beginTransaction();
        try {
            $auth_user = auth()->user();
            $salary_set_employees = SettingsSalarySetEmployee::where('employee_id', $auth_user->id)
                ->where('status', SettingsSalarySetEmployee::STATUS_ACTIVE)
                ->where('deleted', SettingsSalarySetEmployee::DELETED_NO)
                ->first();
            if (!$salary_set_employees) {
                throw new \Exception('Salary set employee not found.');
            }

            $salary_set = SettingsSalarySet::where('id', $salary_set_employees->settings_salary_set_id)
                ->where('status', SettingsSalarySet::STATUS_ACTIVE)
                ->where('deleted', SettingsSalarySet::DELETED_NO)
                ->first();

            if (!$salary_set) {
                throw new \Exception('Salary set not found.');
            }

            $punch_settings_geo_location_id = null;
            if ($salary_set->attendance_type_location == $salary_set::ATTENDANCE_TYPE_LOCATION_IN_GEO) {
                $salary_set_attendance_locations = SettingsSalarySetAttendanceLocation::where('settings_salary_set_id', $salary_set->id)
                    ->where('status', SettingsSalarySetAttendanceLocation::STATUS_ACTIVE)
                    ->where('deleted', SettingsSalarySetAttendanceLocation::DELETED_NO)
                    ->pluck('settings_geo_location_id')
                    ->toArray();
                if (count($salary_set_attendance_locations) <= 0) {
                    throw new \Exception('Salary set attendance location not found!');
                }

                $settings_geo_locations = SettingsGeoLocation::whereIn('id', $salary_set_attendance_locations)
                    ->where('status', SettingsGeoLocation::STATUS_ACTIVE)
                    ->where('deleted', SettingsGeoLocation::DELETED_NO)
                    ->get();
                if (count($settings_geo_locations) <= 0) {
                    throw new \Exception('Geo Location Settings Not Found.');
                }

                $inGeo = false;
                foreach ($settings_geo_locations as $settings_geo_location) {
                    $polygon_string = $settings_geo_location->location_data;
                    $polygon_array = json_decode($polygon_string, true);
                    $pointToCheck = ["lat" => $request->latitude, "lng" => $request->longitude];

                    if (PolygonAreaHelpler::pointInPolygon($pointToCheck, $polygon_array)) {
                        $inGeo = true;
                        $punch_settings_geo_location_id = $settings_geo_location->id;
                        break;
                    }
                }
                if (!$inGeo) {
                    throw new \Exception('You are out of assigned location!');
                }
            }

            $check_attendance_history_today = AttendanceHistoryToday::where('employee_id', $auth_user->id)
                ->where('deleted', AttendanceHistoryToday::DELETED_NO)
                ->whereDate('datetime', Carbon::now()->format('Y-m-d'))
                ->orderBy('id', 'desc')
                ->first();

            if ($check_attendance_history_today) {
                if ($check_attendance_history_today->type == $check_attendance_history_today::TYPE_IN) {
                    $type = $check_attendance_history_today::TYPE_OUT;
                } else {
                    $type = $check_attendance_history_today::TYPE_IN;
                }
            } else {
                $type = AttendanceHistoryToday::TYPE_IN;
            }

            $attendance_history_today = new AttendanceHistoryToday();
            $attendance_history_today->employee_id = $auth_user->id;
            $attendance_history_today->datetime = Carbon::now()->format('Y-m-d H:i:s');
            $attendance_history_today->type = $type;
            $attendance_history_today->latitude = $request->latitude;
            $attendance_history_today->longitude = $request->longitude;
            $attendance_history_today->attendance_by = AttendanceHistoryToday::ATTENDANCE_BY_EMPLOYEE;
            $attendance_history_today->settings_geo_location_id = $punch_settings_geo_location_id??null;
            $attendance_history_today->created_at = Carbon::now();
            $attendance_history_today->created_by = $auth_user->id;
            $attendance_history_today->updated_at = Carbon::now();
            $attendance_history_today->updated_by = $auth_user->id;
            $attendance_history_today->save();

            $attendance_history = new AttendanceHistory();
            $attendance_history->employee_id = $auth_user->id;
            $attendance_history->datetime = Carbon::now()->format('Y-m-d H:i:s');
            $attendance_history->type = $type;
            $attendance_history->latitude = $request->latitude;
            $attendance_history->longitude = $request->longitude;
            $attendance_history->attendance_by = AttendanceHistory::ATTENDANCE_BY_EMPLOYEE;
            $attendance_history->settings_geo_location_id = $punch_settings_geo_location_id??null;
            $attendance_history->created_at = Carbon::now();
            $attendance_history->created_by = $auth_user->id;
            $attendance_history->updated_at = Carbon::now();
            $attendance_history->updated_by = $auth_user->id;
            $attendance_history->save();

            $attendance_report = AttendanceHistoryHelper::attendanceReportCreateOrUpdate($attendance_history->employee_id, $attendance_history->datetime, 1);


        }catch (\Exception $exception) {
            DB::rollBack();
            throw new \Exception($exception->getMessage());
        }
        DB::commit();
        return ['attendance_history_today'=>$attendance_history_today,'attendance_history'=>$attendance_history, 'attendance_report'=>$attendance_report];
    }

}
