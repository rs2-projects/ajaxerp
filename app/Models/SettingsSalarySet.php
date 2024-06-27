<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class SettingsSalarySet extends BaseModel
{
    use HasFactory;

    protected $table = 'settings_salary_sets';
    public $timestamps = false;
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUSES = [
        self::STATUS_INACTIVE => 'Inactive',
        self::STATUS_ACTIVE => 'Active',
    ];

    const DELETED_NO = 0;
    const DELETED_YES = 1;
    const DELETEDS = [
        self::DELETED_NO => 'No',
        self::DELETED_YES => 'Yes',
    ];

    const ATTENDANCE_TYPE_FINGERPRINT_DEVICE_NO = 0;
    const ATTENDANCE_TYPE_FINGERPRINT_DEVICE_YES = 1;
    const ATTENDANCE_TYPE_FINGERPRINT_DEVICES = [
        self::ATTENDANCE_TYPE_FINGERPRINT_DEVICE_NO => 'No',
        self::ATTENDANCE_TYPE_FINGERPRINT_DEVICE_YES => 'Yes',
    ];

    const ATTENDANCE_TYPE_LOCATION_NO = 0;
    const ATTENDANCE_TYPE_LOCATION_IN_GEO = 1;

    const ATTENDANCE_TYPE_LOCATION__ANY_LOCATION = 2;
    const ATTENDANCE_TYPE_LOCATIONS = [
        self::ATTENDANCE_TYPE_LOCATION_NO => 'No',
        self::ATTENDANCE_TYPE_LOCATION_IN_GEO => 'In Geo',
        self::ATTENDANCE_TYPE_LOCATION__ANY_LOCATION => 'Any Location',
    ];

    const SALARY_GENERATE_TYPE_HALF_MONTH = 1;
    const SALARY_GENERATE_TYPE_FULL_MONTH = 2;
    const SALARY_GENERATE_TYPES = [
        self::SALARY_GENERATE_TYPE_HALF_MONTH => 'Half Month',
        self::SALARY_GENERATE_TYPE_FULL_MONTH => 'Full Month',
    ];
    protected $fillable = [
        'name',
        'description',
        'settings_salary_type_id',
        'settings_overtime_type_id',
        'settings_absent_penalty_id',
        'settings_late_penalty_id',
        'settings_office_time_type_id',
        'attendance_type_fingerprint_device',
        'attendance_type_location',
        'salary_generate_type',
        'status',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by',
        'deleted',
        'deleted_at',
        'deleted_by',
    ];

    public function attendanceLocations()
    {
        return $this->hasMany(SettingsSalarySetAttendanceLocation::class, 'settings_salary_set_id', 'id');
    }

    public function leaveTypes()
    {
        return $this->hasMany(SettingsSalarySetLeaveType::class, 'settings_salary_set_id', 'id');
    }
}
