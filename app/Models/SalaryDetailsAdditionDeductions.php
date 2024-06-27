<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class SalaryDetailsAdditionDeductions extends BaseModel
{
    use HasFactory;

    protected $table = 'salary_details_addition_deductions';
    public $timestamps = false;

    const TYPE_EARNING = 0;
    const TYPE_DEDUCTION = 1;
    const TYPES = [
        self::TYPE_EARNING => 'Earning/Allowance',
        self::TYPE_DEDUCTION => 'Deduction',
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
        'settings_salary_type_id',
        'settings_salary_type_details_id',
        'type',
        'rate',
        'amount',
        'status',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
        'deleted',
        'deleted_by',
        'deleted_at',
    ];

    public function settingsSalaryTypeDetails()
    {
        return $this->belongsTo(SettingsSalaryTypeDetails::class, 'settings_salary_type_details_id', 'id');
    }
}
