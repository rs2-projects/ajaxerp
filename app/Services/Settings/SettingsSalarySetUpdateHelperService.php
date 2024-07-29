<?php

namespace App\Services\Settings;

use App\Helpers\SalaryGenerateDateHelper;
use App\Models\AttendanceReport;
use App\Models\SettingsSalarySet;
use App\Models\SettingsSalarySetAttendanceLocation;
use App\Models\SettingsSalarySetEmployee;
use App\Models\SettingsSalarySetLeaveType;
use Carbon\Carbon;

class SettingsSalarySetUpdateHelperService
{
    public function updateOfficeTimeType($oldOfficeTimeType, $newOfficeTimeType)
    {
        $salarySets = SettingsSalarySet::where('settings_office_time_type_id', $oldOfficeTimeType->id)
            ->where('status', SettingsSalarySet::STATUS_ACTIVE)
            ->get();

        $this->updateSingleColumn($salarySets, 'settings_office_time_type_id', $newOfficeTimeType->id);
        /*$month_start_date = Carbon::now()->startOfMonth()->format('Y-m-d');
        foreach ($salarySets as $salarySet) {
            if($salarySet->start_date != $month_start_date) {
                $salarySet->status = SettingsSalarySet::STATUS_INACTIVE;
                $salarySet->end_date = Carbon::now()->subMonth()->endOfMonth()->format('Y-m-d');
                $salarySet->save();

                $newSalarySet = new SettingsSalarySet();
                $newSalarySet->start_date = $month_start_date;
                $newSalarySet->name = $salarySet->name;
                $newSalarySet->description = $salarySet->description;
                $newSalarySet->settings_salary_type_id = $salarySet->settings_salary_type_id;
                $newSalarySet->settings_overtime_type_id = $newOfficeTimeType->id;
                $newSalarySet->settings_absent_penalty_id = $salarySet->settings_absent_penalty_id;
                $newSalarySet->settings_late_penalty_id = $salarySet->settings_late_penalty_id;
                $newSalarySet->settings_office_time_type_id = $salarySet->settings_office_time_type_id;
                $newSalarySet->attendance_type_fingerprint_device = $salarySet->attendance_type_fingerprint_device;
                $newSalarySet->attendance_type_location = $salarySet->attendance_type_location;
                $newSalarySet->salary_generate_type = $salarySet->salary_generate_type;
                $newSalarySet->status = SettingsSalarySet::STATUS_ACTIVE;
                $newSalarySet->created_at = now();
                $newSalarySet->created_by = auth()->id();
                $newSalarySet->updated_at = now();
                $newSalarySet->updated_by = auth()->id();
                $newSalarySet->save();

                $this->copyAttendanceLocations($salarySet, $newSalarySet);

                $this->copyLeaveTypes($salarySet, $newSalarySet);

                $this->copyEmployees($salarySet, $newSalarySet);

            } else {
                $salarySet->settings_overtime_type_id = $newOfficeTimeType->id;
                $salarySet->updated_at = now();
                $salarySet->updated_by = auth()->id();
                $salarySet->save();
            }
        }*/
    }
    public function updateSalaryType($oldSalaryType, $newSalaryType)
    {
        $salarySets = SettingsSalarySet::where('settings_salary_type_id', $oldSalaryType->id)
            ->where('status', SettingsSalarySet::STATUS_ACTIVE)
            ->get();

        $this->updateSingleColumn($salarySets, 'settings_salary_type_id', $newSalaryType->id);
    }
    public function updateOvertimeType($oldOverTimeType, $newOverTimeType)
    {
        $salarySets = SettingsSalarySet::where('settings_overtime_type_id', $oldOverTimeType->id)
            ->where('status', SettingsSalarySet::STATUS_ACTIVE)
            ->get();

        $this->updateSingleColumn($salarySets, 'settings_overtime_type_id', $newOverTimeType->id);
    }
    public function updateAbsentPenalty($oldAbsentPenalty, $newAbsentPenalty)
    {
        $salarySets = SettingsSalarySet::where('settings_absent_penalty_id', $oldAbsentPenalty->id)
            ->where('status', SettingsSalarySet::STATUS_ACTIVE)
            ->get();

        $this->updateSingleColumn($salarySets, 'settings_absent_penalty_id', $newAbsentPenalty->id);
    }

    public function updateLatePenalty($oldLatePenalty, $newLatePenalty)
    {
        $salarySets = SettingsSalarySet::where('settings_late_penalty_id', $oldLatePenalty->id)
            ->where('status', SettingsSalarySet::STATUS_ACTIVE)
            ->get();

        $this->updateSingleColumn($salarySets, 'settings_late_penalty_id', $newLatePenalty->id);
    }

    public function updateSingleColumn($salarySets, $columnName, $value)
    {
        $month_start_date = SalaryGenerateDateHelper::monthStartDate();
        foreach ($salarySets as $salarySet) {
            if($salarySet->start_date != $month_start_date) {
                $salarySet->status = SettingsSalarySet::STATUS_INACTIVE;
                $salarySet->end_date = SalaryGenerateDateHelper::previousMonthEndDate();
                $salarySet->save();

                $singleColumns = [
                    'settings_salary_type_id',
                    'settings_overtime_type_id',
                    'settings_absent_penalty_id',
                    'settings_late_penalty_id',
                    'settings_office_time_type_id',
                    'attendance_type_fingerprint_device',
                    'attendance_type_location',
                    'salary_generate_type',
                ];


                $newSalarySet = new SettingsSalarySet();
                $newSalarySet->start_date = $month_start_date;
                $newSalarySet->parent_id = $salarySet->id;
                $newSalarySet->name = $salarySet->name;
                $newSalarySet->description = $salarySet->description;
                foreach ($singleColumns as $singleColumn) {
                    if($singleColumn == $columnName) {
                        $newSalarySet->$singleColumn = $value;
                    } else {
                        $newSalarySet->$singleColumn = $salarySet->$singleColumn;
                    }
                }
                /*$newSalarySet->settings_salary_type_id = $salarySet->settings_salary_type_id;
                $newSalarySet->settings_overtime_type_id = $newOfficeTimeType->id;
                $newSalarySet->settings_absent_penalty_id = $salarySet->settings_absent_penalty_id;
                $newSalarySet->settings_late_penalty_id = $salarySet->settings_late_penalty_id;
                $newSalarySet->settings_office_time_type_id = $salarySet->settings_office_time_type_id;
                $newSalarySet->attendance_type_fingerprint_device = $salarySet->attendance_type_fingerprint_device;
                $newSalarySet->attendance_type_location = $salarySet->attendance_type_location;
                $newSalarySet->salary_generate_type = $salarySet->salary_generate_type;*/
                $newSalarySet->status = SettingsSalarySet::STATUS_ACTIVE;
                $newSalarySet->created_at = now();
                $newSalarySet->created_by = auth()->id();
                $newSalarySet->updated_at = now();
                $newSalarySet->updated_by = auth()->id();
                $newSalarySet->save();

                $this->copyAttendanceLocations($salarySet, $newSalarySet);

                $this->copyLeaveTypes($salarySet, $newSalarySet);

                $this->copyEmployees($salarySet, $newSalarySet);

            } else {
                $salarySet->$columnName = $value;
                $salarySet->updated_at = now();
                $salarySet->updated_by = auth()->id();
                $salarySet->save();

                $salary_set_ids = SettingsSalarySet::where($columnName, $value)->pluck('id')->toArray();
                $employee_ids = SettingsSalarySetEmployee::whereIn('settings_salary_set_id', $salary_set_ids)->pluck('employee_id')->toArray();
                AttendanceReport::whereIn('employee_id', $employee_ids)
                    ->whereIn('settings_salary_set_id', $salary_set_ids)
                    ->where('salary_generated', AttendanceReport::SALARY_GENERATED_NO)
                    ->delete();
            }
        }
    }

    public function copyAttendanceLocations($oldSalarySet, $newSalarySet)
    {
        foreach ($oldSalarySet->attendanceLocations as $attendanceLocation) {
            $newAttendanceLocation = new SettingsSalarySetAttendanceLocation();
            $newAttendanceLocation->settings_salary_set_id = $newSalarySet->id;
            $newAttendanceLocation->settings_geo_location_id = $attendanceLocation->settings_geo_location_id;
            $newAttendanceLocation->status = SettingsSalarySetAttendanceLocation::STATUS_ACTIVE;
            $newAttendanceLocation->created_at = now();
            $newAttendanceLocation->created_by = auth()->id();
            $newAttendanceLocation->updated_at = now();
            $newAttendanceLocation->updated_by = auth()->id();
            $newAttendanceLocation->save();
        }
    }

    public function copyLeaveTypes($oldSalarySet, $newSalarySet)
    {
        foreach ($oldSalarySet->leaveTypes as $leaveType) {
            $newLeaveType = new SettingsSalarySetLeaveType();
            $newLeaveType->settings_salary_set_id = $newSalarySet->id;
            $newLeaveType->settings_leave_type_id = $leaveType->settings_leave_type_id;
            $newLeaveType->status = SettingsSalarySetLeaveType::STATUS_ACTIVE;
            $newLeaveType->created_at = now();
            $newLeaveType->created_by = auth()->id();
            $newLeaveType->updated_at = now();
            $newLeaveType->updated_by = auth()->id();
            $newLeaveType->save();
        }
    }

    public function copyEmployees($oldSalarySet, $newSalarySet)
    {
        foreach ($oldSalarySet->employees as $employee) {
            $newEmployee = new SettingsSalarySetEmployee();
            $newEmployee->settings_salary_set_id = $newSalarySet->id;
            $newEmployee->employee_id = $employee->employee_id;
            $newEmployee->basic_salary = $employee->basic_salary;
            $newEmployee->status = SettingsSalarySetEmployee::STATUS_ACTIVE;
            $newEmployee->created_at = now();
            $newEmployee->created_by = auth()->id();
            $newEmployee->updated_at = now();
            $newEmployee->updated_by = auth()->id();
            $newEmployee->save();
        }
    }
}
