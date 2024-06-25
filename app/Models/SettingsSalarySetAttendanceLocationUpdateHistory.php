<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class SettingsSalarySetAttendanceLocationUpdateHistory extends BaseModel
{
    use HasFactory;
    protected $table = 'settings_salary_set_attendance_location_update_histories';
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


    protected $fillable = [
        'settings_salary_set_attendance_location_id',
        'start_date',
        'end_date',
        'settings_salary_set_id',
        'settings_geo_location_id',
        'created_by',
        'updated_by',
        'deleted_by',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
