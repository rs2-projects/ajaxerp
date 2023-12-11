<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSalarySettings extends Model
{
    use HasFactory;

    protected $table = 'user_salary_settings';
    public $timestamps = false;

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
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
        'user_id',
        'start_date',
        'end_date',
        'basic_salary',
        'settings_salary_type_id',
        'settings_overtime_type_id',
        'settings_absent_penalty_id',
        'settings_late_penalty_id',
        'settings_office_time_type_id',
        'status',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by',
        'deleted',
        'deleted_at',
        'deleted_by',
    ];
}
