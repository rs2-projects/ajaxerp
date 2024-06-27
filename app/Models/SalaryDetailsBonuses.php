<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class SalaryDetailsBonuses extends BaseModel
{
    use HasFactory;

    protected $table = 'salary_details_bonuses';
    public $timestamps = false;

    const BONUS_RATE_TYPE_PERCENT = 0;
    const BONUS_RATE_TYPE_FIXED_AMOUNT = 1;
    const BONUS_RATE_TYPES = [
        self::BONUS_RATE_TYPE_PERCENT => 'Percent',
        self::BONUS_RATE_TYPE_FIXED_AMOUNT => 'Fixed Amount',
    ];

    const BONUS_SALARY_TYPE_BASIC_SALARY = 0;
    const BONUS_SALARY_TYPE_GROSS_SALARY = 1;
    const BONUS_SALARY_TYPES = [
        self::BONUS_SALARY_TYPE_BASIC_SALARY => 'Basic Salary',
        self::BONUS_SALARY_TYPE_GROSS_SALARY => 'Gross Salary',
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
        'salary_id',
        'salary_details_id',
        'salary_bonus_type_id',
        'settings_bonus_type_id',
        'settings_bonus_type_salary_bonus_id',
        'bonus_rate_type',
        'bonus_salary_type',
        'bonus_rate',
        'bonus_amount',
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
