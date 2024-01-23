<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettingsSalaryDeductionType extends Model
{
    use HasFactory;

    protected $table = 'settings_salary_deduction_types';
    public $timestamps = false;

    const RATE_TYPE_PERCENT = 0;
    const RATE_TYPE_FIXED_AMOUNT = 1;
    const RATE_TYPES = [
        self::RATE_TYPE_PERCENT => 'Percent',
        self::RATE_TYPE_FIXED_AMOUNT => 'Fixed Amount',
    ];

    const SALARY_TYPE_BASIC_SALARY = 0;
    const SALARY_TYPE_GROSS_SALARY = 1;
    const SALARY_TYPE_NOT_SET = 2;
    const SALARY_TYPES = [
        self::SALARY_TYPE_BASIC_SALARY => 'Basic Salary',
        self::SALARY_TYPE_GROSS_SALARY => 'Gross Salary',
        self::SALARY_TYPE_NOT_SET => 'Not Set',
    ];
    const SALARY_TYPES_DROPDOWN = [
        self::SALARY_TYPE_BASIC_SALARY => 'Basic Salary',
        self::SALARY_TYPE_GROSS_SALARY => 'Gross Salary',
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
        'title',
        'description',
        'rate_type',
        'salary_type',
        'rate',
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
