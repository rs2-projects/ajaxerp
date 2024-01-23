<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalaryDetailsLeaves extends Model
{
    use HasFactory;

    protected $table = 'salary_details_leaves';
    public $timestamps = false;

    const LEAVE_TYPE_NOT_SET = 0;
    const LEAVE_TYPE_PAID = 1;
    const LEAVE_TYPE_UNPAID = 2;
    const LEAVE_TYPES = [
        self::LEAVE_TYPE_NOT_SET => 'Not Set',
        self::LEAVE_TYPE_PAID => 'Paid',
        self::LEAVE_TYPE_UNPAID => 'Unpaid',
    ];

    const SALARY_TYPE_BASIC_SALARY = 0;
    const SALARY_TYPE_GROSS_SALARY = 1;
    const SALARY_TYPES = [
        self::SALARY_TYPE_BASIC_SALARY => 'Basic Salary',
        self::SALARY_TYPE_GROSS_SALARY => 'Gross Salary',
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
        'employee_id',
        'date',
        'leave_type',
        'settings_leave_type_id',
        'salary_type',
        'rate',
        'amount',
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
