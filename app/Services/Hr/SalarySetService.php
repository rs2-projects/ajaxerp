<?php

namespace App\Services\Hr;

use App\Models\SettingsAbsentPenalty;
use App\Models\SettingsGeoLocation;
use App\Models\SettingsLatePenalty;
use App\Models\SettingsLeaveType;
use App\Models\SettingsOfficeTime;
use App\Models\SettingsOfficeTimeType;
use App\Models\SettingsOvertimeType;
use App\Models\SettingsSalaryType;
use App\Models\User;

class SalarySetService
{
    public function __construct()
    {
        $this->paginate_limit = config('commonData.paginate_limit');
    }

    public function getIndexFilteredData()
    {

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

        return $data;
    }
}
