<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettingsSalarySetUpdateHistory extends Model
{
    use HasFactory;
    protected $table = 'settings_salary_set_update_histories';
    public $timestamps = false;

    const ATTENDANCE_TYPE_FINGERPRINT_DEVICE_NO = 0;
    const ATTENDANCE_TYPE_FINGERPRINT_DEVICE_YES = 1;
    const ATTENDANCE_TYPE_FINGERPRINT_DEVICES = [
        self::ATTENDANCE_TYPE_FINGERPRINT_DEVICE_NO => 'No',
        self::ATTENDANCE_TYPE_FINGERPRINT_DEVICE_YES => 'Yes',
    ];

    const ATTENDANCE_TYPE_IN_GEO_NO = 0;
    const ATTENDANCE_TYPE_IN_GEO_YES = 1;
    const ATTENDANCE_TYPE_IN_GEOS = [
        self::ATTENDANCE_TYPE_IN_GEO_NO => 'No',
        self::ATTENDANCE_TYPE_IN_GEO_YES => 'Yes',
    ];

    const SALARY_GENERATE_TYPE_HALF_MONTH = 1;
    const SALARY_GENERATE_TYPE_FULL_MONTH = 2;
    const SALARY_GENERATE_TYPES = [
        self::SALARY_GENERATE_TYPE_HALF_MONTH => 'Half Month',
        self::SALARY_GENERATE_TYPE_FULL_MONTH => 'Full Month',
    ];

    const DELETED_NO = 0;
    const DELETED_YES = 1;
    const DELETEDS = [
        self::DELETED_NO => 'No',
        self::DELETED_YES => 'Yes',
    ];

    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUSES = [
        self::STATUS_INACTIVE => 'Inactive',
        self::STATUS_ACTIVE => 'Active',
    ];

    protected $fillable = [
        'settings_salary_set_id',
        'start_date',
        'end_date',
        'name',
        'description',
        'settings_salary_type_id',
        'settings_overtime_type_id',
        'settings_absent_penalty_id',
        'settings_late_penalty_id',
        'settings_office_time_type_id',
        'attendance_type_fingerprint_device',
        'attendance_type_in_geo',
        'salary_generate_type',
        'created_by',
        'updated_by',
        'deleted_by',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
