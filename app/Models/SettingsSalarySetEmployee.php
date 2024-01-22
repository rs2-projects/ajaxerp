<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettingsSalarySetEmployee extends Model
{
    use HasFactory;
    protected $table = 'settings_salary_set_employees';
    public $timestamps = false;
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
    const STATUS = [
        self::STATUS_ACTIVE => 'Active',
        self::STATUS_INACTIVE => 'Inactive',
    ];

    const DELETED_YES = 1;
    const DELETED_NO = 0;
    const DELETED = [
        self::DELETED_YES => 'Yes',
        self::DELETED_NO => 'No',
    ];

    protected $fillable = [
        'settings_salary_set_id',
        'employee_id',
        'basic_salary',
        'status',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
        'deleted',
        'deleted_by',
        'deleted_at',
    ];

    public function employee()
    {
        return $this->belongsTo(User::class, 'employee_id', 'id');
    }
}
