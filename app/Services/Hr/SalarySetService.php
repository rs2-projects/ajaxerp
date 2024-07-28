<?php

namespace App\Services\Hr;

use App\Helpers\SalaryGenerateDateHelper;
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
use App\Services\Settings\SettingsSalarySetUpdateHelperService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SalarySetService
{
    public SettingsSalarySetUpdateHelperService $updateSalarySetHelperService;
    public function __construct()
    {
        $this->paginate_limit = config('commonData.paginate_limit');
        $this->updateSalarySetHelperService = new SettingsSalarySetUpdateHelperService();
    }

    public function getIndexFilteredData()
    {
        $data['settingsSalarySets'] = SettingsSalarySet::where('deleted', SettingsSalarySet::DELETED_NO)
            ->where('status', SettingsSalarySet::STATUS_ACTIVE)
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
            $salarySet->start_date = SalaryGenerateDateHelper::monthStartDate();
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

       $data['setEmployeeRoute'] = route('hr.salary-set.set-employees', $salarySet->id);
        return $data;
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

    public function update($id,$request){

        try {
            $month_start_date = SalaryGenerateDateHelper::monthStartDate();

            $salarySet = SettingsSalarySet::where('deleted', SettingsSalarySet::DELETED_NO)
                ->where('id', $id)
                ->first();

            if (empty($salarySet)){
                throw new \Exception("Salary Set not found");
            }

            if($salarySet->start_date != $month_start_date) {

                $salarySet->status = SettingsSalarySet::STATUS_INACTIVE;
                $salarySet->end_date = SalaryGenerateDateHelper::previousMonthEndDate();
                $salarySet->updated_at = Carbon::now();
                $salarySet->updated_by = auth()->user()->id;
                $salarySet->save();

                $newSalarySet = new SettingsSalarySet();
                $newSalarySet->start_date = $month_start_date;
                $newSalarySet->parent_id = $salarySet->id;
                $newSalarySet->name = $request->name;
                $newSalarySet->description = $request->description;
                $newSalarySet->settings_salary_type_id = $request->settings_salary_type_id;
                $newSalarySet->settings_overtime_type_id = $request->settings_overtime_type_id;
                $newSalarySet->settings_absent_penalty_id = $request->settings_absent_penalty_id;
                $newSalarySet->settings_late_penalty_id = $request->settings_late_penalty_id;
                $newSalarySet->settings_office_time_type_id = $request->settings_office_time_type_id;
                $newSalarySet->salary_generate_type = $request->salary_generate_type;
                $newSalarySet->attendance_type_fingerprint_device = $salarySet->attendance_type_fingerprint_device??0;
                $newSalarySet->attendance_type_location = $salarySet->attendance_type_location??0;
                $newSalarySet->created_at = Carbon::now();
                $newSalarySet->created_by = auth()->user()->id;
                $newSalarySet->updated_at = Carbon::now();
                $newSalarySet->updated_by = auth()->user()->id;
                $newSalarySet->save();

                $this->updateSalarySetHelperService->copyAttendanceLocations($salarySet, $newSalarySet);
                $this->updateSalarySetHelperService->copyLeaveTypes($salarySet, $newSalarySet);
                $this->updateSalarySetHelperService->copyEmployees($salarySet, $newSalarySet);

            } else {
                $salarySet->name = $request->name;
                $salarySet->description = $request->description;
                $salarySet->settings_salary_type_id = $request->settings_salary_type_id;
                $salarySet->settings_overtime_type_id = $request->settings_overtime_type_id;
                $salarySet->settings_absent_penalty_id = $request->settings_absent_penalty_id;
                $salarySet->settings_late_penalty_id = $request->settings_late_penalty_id;
                $salarySet->settings_office_time_type_id = $request->settings_office_time_type_id;
                $salarySet->salary_generate_type = $request->salary_generate_type;
                $salarySet->updated_at = Carbon::now();
                $salarySet->updated_by = auth()->user()->id;
                $salarySet->save();
            }

        }catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $salarySet = SettingsSalarySet::where('deleted', SettingsSalarySet::DELETED_NO)
                ->where('id', $id)
                ->first();

            if (!$salarySet){
                throw new \Exception("Salary Set not found");
            }

            $salarySet->deleted = SettingsSalarySet::DELETED_YES;
            $salarySet->deleted_at = Carbon::now();
            $salarySet->deleted_by = auth()->user()->id;
            $salarySet->save();

        }catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }
    }

    public function getAttendanceSetEditData($id)
    {
        try {
            $data['item'] = SettingsSalarySet::with('attendanceLocations')
                ->where('deleted', SettingsSalarySet::DELETED_NO)
                ->where('id', $id)
                ->first();
            if (!$data['item']){
                throw new \Exception("Salary Set not found");
            }
            $data['settingsGeoLocations'] = SettingsGeoLocation::where('status',SettingsGeoLocation::STATUS_ACTIVE)
                ->where('deleted', SettingsGeoLocation::DELETED_NO)
                ->orderBy('title', 'asc')
                ->get();

            $data['selected_geo_location_ids'] = $data['item']->attendanceLocations->pluck('settings_geo_location_id')->toArray();

            return $data;
        }catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }
    }

    public function attendanceSetUpdate($id,$request)
    {
        try {
            $month_start_date = SalaryGenerateDateHelper::monthStartDate();

            $salarySet = SettingsSalarySet::where('deleted', SettingsSalarySet::DELETED_NO)
                ->where('id', $id)
                ->first();

            if (!$salarySet){
                throw new \Exception("Salary Set not found");
            }
            if ($salarySet->attendance_type_location == 1) {
                $geoLocationIds = $request->settings_geo_location_id ?? [];
                if (count($geoLocationIds) == 0) {
                    throw new \Exception("Please select at least one geo location");
                }
            }

            $updateSalarySetId = $salarySet->id;
            if($salarySet->start_date != $month_start_date) {
                $salarySet->status = SettingsSalarySet::STATUS_INACTIVE;
                $salarySet->end_date = SalaryGenerateDateHelper::previousMonthEndDate();
                $salarySet->updated_at = Carbon::now();
                $salarySet->updated_by = auth()->user()->id;
                $salarySet->save();

                $newSalarySet = new SettingsSalarySet();
                $newSalarySet->start_date = $month_start_date;
                $newSalarySet->parent_id = $salarySet->id;
                $newSalarySet->name = $salarySet->name;
                $newSalarySet->description = $salarySet->description;
                $newSalarySet->settings_salary_type_id = $salarySet->settings_salary_type_id;
                $newSalarySet->settings_overtime_type_id = $salarySet->settings_overtime_type_id;
                $newSalarySet->settings_absent_penalty_id = $salarySet->settings_absent_penalty_id;
                $newSalarySet->settings_late_penalty_id = $salarySet->settings_late_penalty_id;
                $newSalarySet->settings_office_time_type_id = $salarySet->settings_office_time_type_id;
                $newSalarySet->salary_generate_type = $salarySet->salary_generate_type;
                $newSalarySet->attendance_type_fingerprint_device = $request->attendance_type_fingerprint_device??0;
                $newSalarySet->attendance_type_location = $request->attendance_type_location??0;
                $newSalarySet->created_at = Carbon::now();
                $newSalarySet->created_by = auth()->user()->id;
                $newSalarySet->updated_at = Carbon::now();
                $newSalarySet->updated_by = auth()->user()->id;
                $newSalarySet->save();

                $updateSalarySetId = $newSalarySet->id;

//                $this->updateSalarySetHelperService->copyAttendanceLocations($salarySet, $newSalarySet);
                $this->updateSalarySetHelperService->copyLeaveTypes($salarySet, $newSalarySet);
                $this->updateSalarySetHelperService->copyEmployees($salarySet, $newSalarySet);
            } else {

                $salarySet->attendance_type_fingerprint_device = $request->attendance_type_fingerprint_device??0;
                $salarySet->attendance_type_location = $request->attendance_type_location??0;
                $salarySet->updated_at = Carbon::now();
                $salarySet->updated_by = auth()->user()->id;
                $salarySet->save();
            }



            if ($salarySet->attendance_type_location == 1){
                $geoLocationIds = $request->settings_geo_location_id??[];
                if (count($geoLocationIds) == 0){
                    throw new \Exception("Please select at least one geo location");
                }
                SettingsSalarySetAttendanceLocation::where('settings_salary_set_id', $updateSalarySetId)
                    ->whereNotIn('settings_geo_location_id', $geoLocationIds)
                    ->delete();

                if (count($geoLocationIds) > 0){
                    foreach ($geoLocationIds as $key => $value){
                        if ($value != null && $value != '') {
                            $location = SettingsSalarySetAttendanceLocation::where('settings_salary_set_id', $updateSalarySetId)
                                ->where('settings_geo_location_id', $value)
                                ->first();
                            if (!$location){
                                $location = new SettingsSalarySetAttendanceLocation();
                                $location->settings_salary_set_id = $updateSalarySetId;
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
            }else{
                $geoLocationIds = $request->settings_geo_location_id??[];
                SettingsSalarySetAttendanceLocation::where('settings_salary_set_id', $updateSalarySetId)
//                    ->whereNotIn('settings_geo_location_id', $geoLocationIds)
                    ->delete();
            }
        }catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }

    }

    public function getLeaveTypeSetEditData($id)
    {
        try {
            $data['item'] = SettingsSalarySet::with('leaveTypes')
                ->where('deleted', SettingsSalarySet::DELETED_NO)
                ->where('id', $id)
                ->first();
            if (!$data['item']){
                throw new \Exception("Salary Set not found");
            }
            $data['settingsLeaveTypes'] = SettingsLeaveType::where('status',SettingsLeaveType::STATUS_ACTIVE)
                ->where('deleted', SettingsLeaveType::DELETED_NO)
                ->orderBy('title', 'asc')
                ->get();

            $data['selected_leave_type_ids'] = $data['item']->leaveTypes->pluck('settings_leave_type_id')->toArray();

            return $data;
        }catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }

    }

    public function leaveTypeSetUpdate($id,$request)
    {
        try {
            $month_start_date = SalaryGenerateDateHelper::monthStartDate();

            $salarySet = SettingsSalarySet::where('deleted', SettingsSalarySet::DELETED_NO)
                ->where('id', $id)
                ->first();
            if (empty($salarySet)){
                throw new \Exception("Salary Set not found");
            }

            $leaveTypeIds = $request->settings_leave_type_id??[];
            if (count($leaveTypeIds) == 0){
                throw new \Exception("Please select at least one leave type");
            }

            $updateSalarySetId = $salarySet->id;

            if($salarySet->start_date != $month_start_date) {
                $salarySet->status = SettingsSalarySet::STATUS_INACTIVE;
                $salarySet->end_date = SalaryGenerateDateHelper::previousMonthEndDate();
                $salarySet->updated_at = Carbon::now();
                $salarySet->updated_by = auth()->user()->id;
                $salarySet->save();

                $newSalarySet = new SettingsSalarySet();
                $newSalarySet->start_date = $month_start_date;
                $newSalarySet->parent_id = $salarySet->id;
                $newSalarySet->name = $salarySet->name;
                $newSalarySet->description = $salarySet->description;
                $newSalarySet->settings_salary_type_id = $salarySet->settings_salary_type_id;
                $newSalarySet->settings_overtime_type_id = $salarySet->settings_overtime_type_id;
                $newSalarySet->settings_absent_penalty_id = $salarySet->settings_absent_penalty_id;
                $newSalarySet->settings_late_penalty_id = $salarySet->settings_late_penalty_id;
                $newSalarySet->settings_office_time_type_id = $salarySet->settings_office_time_type_id;
                $newSalarySet->salary_generate_type = $salarySet->salary_generate_type;
                $newSalarySet->attendance_type_fingerprint_device = $salarySet->attendance_type_fingerprint_device??0;
                $newSalarySet->attendance_type_location = $salarySet->attendance_type_location??0;
                $newSalarySet->created_at = Carbon::now();
                $newSalarySet->created_by = auth()->user()->id;
                $newSalarySet->updated_at = Carbon::now();
                $newSalarySet->updated_by = auth()->user()->id;
                $newSalarySet->save();

                $updateSalarySetId = $newSalarySet->id;

                $this->updateSalarySetHelperService->copyAttendanceLocations($salarySet, $newSalarySet);
//                $this->updateSalarySetHelperService->copyLeaveTypes($salarySet, $newSalarySet);
                $this->updateSalarySetHelperService->copyEmployees($salarySet, $newSalarySet);
            } else {

            }


            SettingsSalarySetLeaveType::where('settings_salary_set_id', $updateSalarySetId)
                ->whereNotIn('settings_leave_type_id', $leaveTypeIds)
                ->delete();

            if (count($leaveTypeIds) > 0){
                foreach ($leaveTypeIds as $key => $value){
                    if ($value != null && $value != '') {
                        $leaveType = SettingsSalarySetLeaveType::where('settings_salary_set_id', $updateSalarySetId)
                            ->where('settings_leave_type_id', $value)
                            ->first();
                        if (!$leaveType){
                            $leaveType = new SettingsSalarySetLeaveType();
                            $leaveType->settings_salary_set_id = $updateSalarySetId;
                            $leaveType->settings_leave_type_id = $value;
                            $leaveType->created_at = Carbon::now();
                            $leaveType->created_by = auth()->user()->id;
                            $leaveType->updated_at = Carbon::now();
                            $leaveType->updated_by = auth()->user()->id;
                            $leaveType->save();
                        }

                    }
                }
            }

        }catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }

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

    public function setEmployeesStore($id,$request)
    {
        DB::beginTransaction();
        try {
            $month_start_date = SalaryGenerateDateHelper::monthStartDate();

            $salarySet = SettingsSalarySet::where('deleted', SettingsSalarySet::DELETED_NO)
                ->where('id', $id)
                ->first();

            if (!$salarySet){
                throw new \Exception("Salary Set not found");
            }

            $employeeIds = $request->employee_id??[];
            if (count($employeeIds) == 0){
                throw new \Exception("Employee Required");
            }

            $updateSalarySetId = $salarySet->id;
            if($salarySet->start_date != $month_start_date) {
                $salarySet->status = SettingsSalarySet::STATUS_INACTIVE;
                $salarySet->end_date = SalaryGenerateDateHelper::previousMonthEndDate();
                $salarySet->updated_at = Carbon::now();
                $salarySet->updated_by = auth()->user()->id;
                $salarySet->save();

                $newSalarySet = new SettingsSalarySet();
                $newSalarySet->start_date = $month_start_date;
                $newSalarySet->parent_id = $salarySet->id;
                $newSalarySet->name = $salarySet->name;
                $newSalarySet->description = $salarySet->description;
                $newSalarySet->settings_salary_type_id = $salarySet->settings_salary_type_id;
                $newSalarySet->settings_overtime_type_id = $salarySet->settings_overtime_type_id;
                $newSalarySet->settings_absent_penalty_id = $salarySet->settings_absent_penalty_id;
                $newSalarySet->settings_late_penalty_id = $salarySet->settings_late_penalty_id;
                $newSalarySet->settings_office_time_type_id = $salarySet->settings_office_time_type_id;
                $newSalarySet->salary_generate_type = $salarySet->salary_generate_type;
                $newSalarySet->attendance_type_fingerprint_device = $salarySet->attendance_type_fingerprint_device??0;
                $newSalarySet->attendance_type_location = $salarySet->attendance_type_location??0;
                $newSalarySet->created_at = Carbon::now();
                $newSalarySet->created_by = auth()->user()->id;
                $newSalarySet->updated_at = Carbon::now();
                $newSalarySet->updated_by = auth()->user()->id;
                $newSalarySet->save();

                $updateSalarySetId = $newSalarySet->id;

                $this->updateSalarySetHelperService->copyAttendanceLocations($salarySet, $newSalarySet);
                $this->updateSalarySetHelperService->copyLeaveTypes($salarySet, $newSalarySet);
//                $this->updateSalarySetHelperService->copyEmployees($salarySet, $newSalarySet);
            } else {

            }

            SettingsSalarySetEmployee::where('settings_salary_set_id', $updateSalarySetId)
                ->whereNotIn('employee_id', $employeeIds)
                ->delete();

            $userLifecycleService = new UserLifecycleService();
            $current_timestamp = now();
            $current_date = now()->format('Y-m-d');
            foreach ($employeeIds as $key => $value){
                if ($value != null && $value != '') {
                    $employee = SettingsSalarySetEmployee::where('settings_salary_set_id', $updateSalarySetId)
                        ->where('employee_id', $value)
                        ->first();
                    $salaryUpdated = false;
                    if (!$employee){
                        $employee = new SettingsSalarySetEmployee();
                        $employee->settings_salary_set_id = $updateSalarySetId;
                        $employee->employee_id = $value;
                        $employee->basic_salary = $request->basic_salary[$key];
                        $employee->created_at = $current_timestamp;
                        $employee->created_by = auth()->user()->id;
                        $employee->updated_at = $current_timestamp;
                        $employee->updated_by = auth()->user()->id;

                        $salaryUpdated = true;

                    }else{
                        if($employee->basic_salary != $request->basic_salary[$key]) {
                            $employee->basic_salary = $request->basic_salary[$key];
                            $salaryUpdated = true;
                        }
                        $employee->updated_at = $current_timestamp;
                        $employee->updated_by = auth()->user()->id;
                    }

                    $employee->save();

                    if ($salaryUpdated === true) {
                        $userLifecycleService->storeUpdateSalary(
                            user_id:$employee->employee_id,
                            salary:$employee->basic_salary,
                            date: $current_date
                        );
                    }
                }
            }

        }catch (\Exception $exception) {
            DB::rollBack();
            throw new \Exception($exception->getMessage());
        }
        DB::commit();
    }
}
