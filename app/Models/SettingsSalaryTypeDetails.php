<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class SettingsSalaryTypeDetails extends BaseModel
{
    use HasFactory;

    protected $table = 'settings_salary_type_details';
    public $timestamps = false;

    const TYPE_EARNING = 0;
    const TYPE_DEDUCTION = 1;
    const TYPES = [
        self::TYPE_EARNING => 'Earning/Allowance',
        self::TYPE_DEDUCTION => 'Deduction',
    ];


    protected $fillable = [
        'settings_salary_type_id',
        'type',
        'title',
        'value',
    ];
}
