<?php

namespace App\Services\Payroll\Traits;

use App\Helpers\AttendanceHistoryHelper;
use App\Models\AttendanceReport;
use App\Models\SettingsAbsentPenalty;
use App\Models\SettingsLatePenalty;
use App\Models\SettingsOfficeTimeType;
use App\Models\SettingsOvertimeType;
use App\Models\SettingsSalaryDeductionType;
use App\Models\SettingsSalarySet;
use App\Models\SettingsSalarySetEmployee;
use App\Models\SettingsSalaryType;

trait GetSalaryResources
{
    public function getSettingsSalarySet($salary_set_id, $salary_generate_type)
    {
        return SettingsSalarySet::where('id', $salary_set_id)
            ->where('status', SettingsSalarySet::STATUS_ACTIVE)
            ->where('deleted', SettingsSalarySet::DELETED_NO)
            ->where('salary_generate_type', $salary_generate_type)
            ->first();
    }

    public function getSalarySetEmployees($salary_set_id)
    {
        return SettingsSalarySetEmployee::with('employee')
            ->where('settings_salary_set_id', $salary_set_id)
            ->where('status', SettingsSalarySetEmployee::STATUS_ACTIVE)
            ->where('deleted', SettingsSalarySetEmployee::DELETED_NO)
            ->get();
    }

    public function getSettingsSalaryType($settingsSalarySet)
    {
        if ($settingsSalarySet->settings_salary_type_id == '') {
            return null;
        }
        return SettingsSalaryType::with('salaryTypeDetails')
            ->where('id', $settingsSalarySet->settings_salary_type_id)
            ->where('status', SettingsSalaryType::STATUS_ACTIVE)
            ->where('deleted', SettingsSalaryType::DELETED_NO)
            ->first();
    }

    public function getSettingsOvertimeType($settingsSalarySet)
    {
        if ($settingsSalarySet->settings_overtime_type_id == '') {
            return null;
        }
        return SettingsOvertimeType::where('id', $settingsSalarySet->settings_overtime_type_id)
            ->where('status', SettingsOvertimeType::STATUS_ACTIVE)
            ->where('deleted', SettingsOvertimeType::DELETED_NO)
            ->first();
    }

    public function getSettingsAbsentPenalty($settingsSalarySet)
    {
        if ($settingsSalarySet->settings_absent_penalty_id == '') {
            return null;
        }
        return SettingsAbsentPenalty::where('id', $settingsSalarySet->settings_absent_penalty_id)
            ->where('status', SettingsAbsentPenalty::STATUS_ACTIVE)
            ->where('deleted', SettingsAbsentPenalty::DELETED_NO)
            ->first();
    }

    public function getSettingsLatePenalty($settingsSalarySet)
    {
        if ($settingsSalarySet->settings_late_penalty_id == '') {
            return null;
        }
        return SettingsLatePenalty::where('id', $settingsSalarySet->settings_late_penalty_id)
            ->where('status', SettingsLatePenalty::STATUS_ACTIVE)
            ->where('deleted', SettingsLatePenalty::DELETED_NO)
            ->first();
    }

    public function getSettingsOfficeTimeType($settingsSalarySet)
    {
        if ($settingsSalarySet->settings_office_time_type_id == '') {
            return null;
        }
        return SettingsOfficeTimeType::with('officeTimes')
            ->where('id', $settingsSalarySet->settings_office_time_type_id)
            ->where('status', SettingsOfficeTimeType::STATUS_ACTIVE)
            ->where('deleted', SettingsOfficeTimeType::DELETED_NO)
            ->first();
    }

    public function getAttendanceReport($employee_id, $date)
    {
        try {
            $report = AttendanceReport::with('settingsLeaveType')
                ->where('employee_id', $employee_id)
                ->where('date', $date)
                ->where('status', AttendanceReport::STATUS_ACTIVE)
                ->where('deleted', AttendanceReport::DELETED_NO)
                ->first();
            if (empty($report)) {
                AttendanceHistoryHelper::attendanceReportCreateOrUpdate($employee_id, $date, AttendanceReport::INPUTTED_BY_TYPE_ADMIN);

                $report = AttendanceReport::where('employee_id', $employee_id)
                    ->where('date', $date)
                    ->where('status', AttendanceReport::STATUS_ACTIVE)
                    ->where('deleted', AttendanceReport::DELETED_NO)
                    ->first();
            }

        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }

        return $report;
    }

    public function getSettingsSalaryDeductionType($id)
    {
        return SettingsSalaryDeductionType::where('id', $id)
            ->where('status', SettingsSalaryDeductionType::STATUS_ACTIVE)
            ->where('deleted', SettingsSalaryDeductionType::DELETED_NO)
            ->first();
    }


}
