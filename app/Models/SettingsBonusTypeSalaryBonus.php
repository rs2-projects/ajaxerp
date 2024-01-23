<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettingsBonusTypeSalaryBonus extends Model
{
    use HasFactory;

    protected $table = 'settings_bonus_type_salary_bonuses';
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
        'settings_bonus_type_id',
        'settings_salary_type_id',
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

    protected $appends = [
        'rate_type_text',
        'salary_type_text',
        'status_text',
    ];

    public function getRateTypeTextAttribute()
    {
        return self::RATE_TYPES[$this->rate_type];
    }

    public function getSalaryTypeTextAttribute()
    {
        return self::SALARY_TYPES[$this->salary_type];
    }

    public function getStatusTextAttribute()
    {
        return self::STATUSES[$this->status];
    }


    public function bonusType()
    {
        return $this->belongsTo(SettingsBonusType::class, 'settings_bonus_type_id');
    }

    public function salaryType()
    {
        return $this->belongsTo(SettingsSalaryType::class, 'settings_salary_type_id');
    }
}
