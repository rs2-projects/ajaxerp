<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    use HasFactory;

    protected $table = 'salaries';
    public $timestamps = false;

    const SALARY_GENERATE_TYPE_HALF_MONTH = 1;
    const SALARY_GENERATE_TYPE_FULL_MONTH = 2;
    const SALARY_GENERATE_TYPES = [
        self::SALARY_GENERATE_TYPE_HALF_MONTH => 'Half Month',
        self::SALARY_GENERATE_TYPE_FULL_MONTH => 'Full Month',
    ];

    const SALARY_PERIOD_FIRST_HALF = 1;
    const SALARY_PERIOD_SECOND_HALF = 2;
    const SALARY_PERIOD_FULL_MONTH = 3;
    const SALARY_PERIODS = [
        self::SALARY_PERIOD_FIRST_HALF => '1st Half',
        self::SALARY_PERIOD_SECOND_HALF => '2nd Half',
        self::SALARY_PERIOD_FULL_MONTH => 'Full Month',
    ];

    const GENERATION_STATUS_RUNNING = 0;
    const GENERATION_STATUS_SUCCESS = 1;
    const GENERATION_STATUS_ERROR = 2;
    const GENERATION_STATUSES = [
        self::GENERATION_STATUS_RUNNING => 'Running',
        self::GENERATION_STATUS_SUCCESS => 'Success',
        self::GENERATION_STATUS_ERROR => 'Error',
    ];

    const VIEW_STATUS_NOT_VIEWED = 0;
    const VIEW_STATUS_VIEWED = 1;
    const VIEW_STATUSES = [
        self::VIEW_STATUS_NOT_VIEWED => 'Not Viewed',
        self::VIEW_STATUS_VIEWED => 'Viewed',
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
        'salary_year',
        'salary_month',
        'salary_date',
        'salary_generate_type',
        'salary_period',
        'generated_by',
        'generated_at',
        'generation_status',
        'generation_error',
        'start_date',
        'end_date',
        'no_of_days',
        'settings_salary_deduction_type_id',
        'total_salary_amount',
        'total_bonus_amount',
        'total_deduction_amount',
        'total_amount_to_pay',
        'total_amount_paid',
        'view_status',
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
