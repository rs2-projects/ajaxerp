<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettingsHolidayType extends Model
{
    use HasFactory;

    protected $table = 'settings_holiday_types';
    public $timestamps = false;

    const OVERTIME_SALARY_TYPE_BASIC_SALARY = 0;
    const OVERTIME_SALARY_TYPE_GROSS_SALARY = 1;
    const OVERTIME_SALARY_TYPES = [
        self::OVERTIME_SALARY_TYPE_BASIC_SALARY => 'Basic Salary',
        self::OVERTIME_SALARY_TYPE_GROSS_SALARY => 'Gross Salary',
    ];

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
        'title',
        'description',
        'overtime_salary_type',
        'overtime_rate',
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
