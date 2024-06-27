<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class SettingsLeaveType extends BaseModel
{
    use HasFactory;

    protected $table = 'settings_leave_types';
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

    const SALARY_TYPE_BASIC_SALARY = 0;
    const SALARY_TYPE_GROSS_SALARY = 1;
    const SALARY_TYPES = [
        self::SALARY_TYPE_BASIC_SALARY => 'Basic Salary',
        self::SALARY_TYPE_GROSS_SALARY => 'Gross Salary',
    ];

    protected $fillable = [
        'title',
        'description',
        'annual_leave_days',
        'max_leave_per_month',
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
        'status_label',
    ];

    public function getStatusLabelAttribute()
    {
        return self::STATUSES[$this->status] ?? self::STATUSES[0];
    }

}
