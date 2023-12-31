<?php

namespace App\Services\Hr;

use App\Models\Department;
use App\Models\SettingsAbsentPenalty;
use App\Models\SettingsGeoLocation;
use App\Models\SettingsLatePenalty;
use App\Models\SettingsLeaveType;
use App\Models\SettingsOfficeTime;
use App\Models\SettingsOfficeTimeType;
use App\Models\SettingsOvertimeType;
use App\Models\SettingsSalarySet;
use App\Models\SettingsSalarySetAttendanceLocation;
use App\Models\SettingsSalarySetEmployee;
use App\Models\SettingsSalarySetLeaveType;
use App\Models\SettingsSalaryType;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SalarySetService
{
    public function __construct()
    {
        $this->paginate_limit = config('commonData.paginate_limit');
    }

    public function getIndexFilteredData()
    {
        $data['settingsSalarySets'] = SettingsSalarySet::where('deleted', SettingsSalarySet::DELETED_NO)
            ->orderBy('name', 'asc')
            ->paginate($this->paginate_limit);

        return $data;
    }

    public function getCreateData()
    {
        $data['settingsSalaryTypes'] = SettingsSalaryType::where('status',SettingsSalaryType::STATUS_ACTIVE)
            ->where('deleted', SettingsSalaryType::DELETED_NO)
            ->orderBy('title', 'asc')
            ->get();

        $data['settingsOverTimeTypes'] = SettingsOvertimeType::where('status',SettingsOvertimeType::STATUS_ACTIVE)
            ->where('deleted', SettingsOvertimeType::DELETED_NO)
            ->orderBy('title', 'asc')
            ->get();

        $data['settingsAbsentPenalties'] = SettingsAbsentPenalty::where('status',SettingsAbsentPenalty::STATUS_ACTIVE)
            ->where('deleted', SettingsAbsentPenalty::DELETED_NO)
            ->orderBy('title', 'asc')
            ->get();

        $data['settingsLatePenalties'] = SettingsLatePenalty::where('status',SettingsLatePenalty::STATUS_ACTIVE)
            ->where('deleted', SettingsLatePenalty::DELETED_NO)
            ->orderBy('title', 'asc')
            ->get();
        $data['settingsOfficeTimeTypes'] = SettingsOfficeTimeType::where('status',SettingsOfficeTimeType::STATUS_ACTIVE)
            ->where('deleted', SettingsOfficeTimeType::DELETED_NO)
            ->orderBy('name', 'asc')
            ->get();

        $data['settingsLeaveTypes'] = SettingsLeaveType::where('status',SettingsLeaveType::STATUS_ACTIVE)
            ->where('deleted', SettingsLeaveType::DELETED_NO)
            ->orderBy('title', 'asc')
            ->get();

        $data['settingsGeoLocations'] = SettingsGeoLocation::where('status',SettingsGeoLocation::STATUS_ACTIVE)
            ->where('deleted', SettingsGeoLocation::DELETED_NO)
            ->orderBy('title', 'asc')
            ->get();

        $data['employees'] = User::where('status',User::STATUS_ACTIVE)
            ->where('deleted', User::DELETED_NO)
            ->where('type', User::TYPE_EMPLOYEE)
            ->where('role', User::ROLE_EMPLOYEE)
            ->orderBy('first_name', 'asc')
            ->get();

        $data['departments'] = Department::where('status',Department::STATUS_ACTIVE)
            ->where('deleted', Department::DELETED_NO)
            ->orderBy('name', 'asc')
            ->get();
        $data['designations'] = Department::where('status',Department::STATUS_ACTIVE)
            ->where('deleted', Department::DELETED_NO)
            ->orderBy('name', 'asc')
            ->get();

        return $data;
    }

    public function store($request)
    {
        DB::beginTransaction();
        try {

            $salarySet = new SettingsSalarySet();
            $salarySet->name = $request->name;
            $salarySet->description = $request->description;
            $salarySet->settings_salary_type_id = $request->settings_salary_type_id;
            $salarySet->settings_overtime_type_id = $request->settings_overtime_type_id;
            $salarySet->settings_absent_penalty_id = $request->settings_absent_penalty_id;
            $salarySet->settings_late_penalty_id = $request->settings_late_penalty_id;
            $salarySet->settings_office_time_type_id = $request->settings_office_time_type_id;
            $salarySet->salary_generate_type = $request->salary_generate_type;
            $salarySet->attendance_type_fingerprint_device = $request->attendance_type_fingerprint_device??0;
            $salarySet->attendance_type_location = $request->attendance_type_location??0;
            $salarySet->created_at = Carbon::now();
            $salarySet->created_by = auth()->user()->id;
            $salarySet->updated_at = Carbon::now();
            $salarySet->updated_by = auth()->user()->id;
            $salarySet->save();

            if ($salarySet->attendance_type_location == 1){
                if (count($request->settings_geo_location_id) > 0){
                    foreach ($request->settings_geo_location_id as $key => $value){
                        if ($value != null && $value != '') {
                            $location = new SettingsSalarySetAttendanceLocation();
                            $location->settings_salary_set_id = $salarySet->id;
                            $location->settings_geo_location_id = $value;
                            $location->created_at = Carbon::now();
                            $location->created_by = auth()->user()->id;
                            $location->updated_at = Carbon::now();
                            $location->updated_by = auth()->user()->id;
                            $location->save();
                        }
                    }
                }
            }

            if (count($request->settings_leave_type_id) > 0){
                foreach ($request->settings_leave_type_id as $key => $value){
                    if ($value != null && $value != ''){
                        $leaveType = new SettingsSalarySetLeaveType();
                        $leaveType->settings_salary_set_id = $salarySet->id;
                        $leaveType->settings_leave_type_id = $value;
                        $leaveType->created_at = Carbon::now();
                        $leaveType->created_by = auth()->user()->id;
                        $leaveType->updated_at = Carbon::now();
                        $leaveType->updated_by = auth()->user()->id;
                        $leaveType->save();
                    }
                }
            }

        }catch (\Exception $exception) {
            DB::rollBack();
            throw new \Exception($exception->getMessage());
        }
        DB::commit();

    }

    public function getEditData($id)
    {
        try {
            $data['item'] = SettingsSalarySet::where('deleted', SettingsSalarySet::DELETED_NO)
                ->where('id', $id)
                ->first();
            if (!$data['item']){
                throw new \Exception("Salary Set not found");
            }

            $data['settingsSalaryTypes'] = SettingsSalaryType::where('status',SettingsSalaryType::STATUS_ACTIVE)
                ->where('deleted', SettingsSalaryType::DELETED_NO)
                ->orderBy('title', 'asc')
                ->get();

            $data['settingsOverTimeTypes'] = SettingsOvertimeType::where('status',SettingsOvertimeType::STATUS_ACTIVE)
                ->where('deleted', SettingsOvertimeType::DELETED_NO)
                ->orderBy('title', 'asc')
                ->get();

            $data['settingsAbsentPenalties'] = SettingsAbsentPenalty::where('status',SettingsAbsentPenalty::STATUS_ACTIVE)
                ->where('deleted', SettingsAbsentPenalty::DELETED_NO)
                ->orderBy('title', 'asc')
                ->get();

            $data['settingsLatePenalties'] = SettingsLatePenalty::where('status',SettingsLatePenalty::STATUS_ACTIVE)
                ->where('deleted', SettingsLatePenalty::DELETED_NO)
                ->orderBy('title', 'asc')
                ->get();
            $data['settingsOfficeTimeTypes'] = SettingsOfficeTimeType::where('status',SettingsOfficeTimeType::STATUS_ACTIVE)
                ->where('deleted', SettingsOfficeTimeType::DELETED_NO)
                ->orderBy('name', 'asc')
                ->get();

        }catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }

        return $data;
    }

    public function getSetEmployeesData($id)
    {
        try {
            $data['salarySet'] = SettingsSalarySet::where('deleted', SettingsSalarySet::DELETED_NO)
                ->where('id', $id)
                ->first();

            if (!$data['salarySet']){
                throw new \Exception("Salary Set not found");
            }

            $data['selectedSetEmployees'] = SettingsSalarySetEmployee::where('deleted', SettingsSalarySetEmployee::DELETED_NO)
                ->where('settings_salary_set_id', $id)
                ->get();

            $data['employees'] = User::where('status',User::STATUS_ACTIVE)
                ->where('deleted', User::DELETED_NO)
                ->where('type', User::TYPE_EMPLOYEE)
                ->where('role', User::ROLE_EMPLOYEE)
                ->orderBy('first_name', 'asc')
                ->get();

            $data['departments'] = Department::where('status',Department::STATUS_ACTIVE)
                ->where('deleted', Department::DELETED_NO)
                ->orderBy('name', 'asc')
                ->get();
            $data['designations'] = Department::where('status',Department::STATUS_ACTIVE)
                ->where('deleted', Department::DELETED_NO)
                ->orderBy('name', 'asc')
                ->get();

            return $data;
        }catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }
    }
}
