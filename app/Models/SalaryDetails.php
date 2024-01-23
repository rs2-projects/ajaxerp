<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalaryDetails extends Model
{
    use HasFactory;
    protected $table = 'salary_details';
    public $timestamps = false;

    const ABSENT_DAY_RATE_TYPE_PERCENTAGE = 0;
    const ABSENT_DAY_RATE_TYPE_AMOUNT = 1;
    const ABSENT_DAY_RATE_TYPES = [
        self::ABSENT_DAY_RATE_TYPE_PERCENTAGE => 'Percentage',
        self::ABSENT_DAY_RATE_TYPE_AMOUNT => 'Amount',
    ];

    const ABSENT_DAY_SALARY_TYPE_BASIC_SALARY = 0;
    const ABSENT_DAY_SALARY_TYPE_GROSS_SALARY = 1;
    const ABSENT_DAY_SALARY_TYPES = [
        self::ABSENT_DAY_SALARY_TYPE_BASIC_SALARY => 'Basic Salary',
        self::ABSENT_DAY_SALARY_TYPE_GROSS_SALARY => 'Gross Salary',
    ];

    const DEDUCTION_RATE_TYPE_PERCENTAGE = 1;
    const DEDUCTION_RATE_TYPE_AMOUNT = 2;
    const DEDUCTION_RATE_TYPES = [
        self::DEDUCTION_RATE_TYPE_PERCENTAGE => 'Percentage',
        self::DEDUCTION_RATE_TYPE_AMOUNT => 'Amount',
    ];

    const DEDUCTION_SALARY_TYPE_BASIC_SALARY = 0;
    const DEDUCTION_SALARY_TYPE_GROSS_SALARY = 1;
    const DEDUCTION_SALARY_TYPES = [
        self::DEDUCTION_SALARY_TYPE_BASIC_SALARY => 'Basic Salary',
        self::DEDUCTION_SALARY_TYPE_GROSS_SALARY => 'Gross Salary',
    ];

    const SALARY_PAID_STATUS_UNPAID = 0;
    const SALARY_PAID_STATUS_PAID = 1;
    const SALARY_PAID_PARTIAL_PAID = 2;
    const SALARY_PAID_STATUSES = [
        self::SALARY_PAID_STATUS_UNPAID => 'Unpaid',
        self::SALARY_PAID_STATUS_PAID => 'Paid',
        self::SALARY_PAID_PARTIAL_PAID => 'Partial Paid',
    ];

    const SLIP_GENERATED_NO = 0;
    const SLIP_GENERATED_YES = 1;
    const SLIP_GENERATEDS = [
        self::SLIP_GENERATED_NO => 'No',
        self::SLIP_GENERATED_YES => 'Yes',
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
        'employee_id',
        'salary_id',
        'settings_salary_set_id',
        'salary_settings_salary_set_id',
        'settings_salary_type_id',
        'settings_overtime_type_id',
        'settings_absent_penalty_id',
        'settings_late_penalty_id',
        'settings_office_time_type_id',

        'total_days',
        'total_working_days',
        'total_weekend_days',
        'holiday_days',
        'total_present_days',
        'perfect_present_days',
        'late_present_days',
        'early_departure_days',
        'absent_days',
        'total_leave_days',
        'paid_leave_days',
        'extra_leave_days',

        'monthly_basic_salary',
        'daily_basic_salary',
        'net_basic_salary',
        'total_added_salary',
        'total_deducted_salary',
        'monthly_salary',
        'daily_salary',
        'current_period_salary',

        'absent_day_rate_type',
        'absent_day_salary_type',
        'absent_day_rate',
        'absent_day_amount_per_day',
        'absent_day_amount',

        'extra_leave_amount',

        'normal_day_overtime_minutes',
        'normal_day_overtime_rate_per_hour',
        'normal_day_overtime_rate_per_minute',
        'normal_day_overtime_amount',
        'special_day_overtime_minutes',
        'special_day_overtime_rate_per_hour',
        'special_day_overtime_rate_per_minute',
        'special_day_overtime_amount',

        'late_minutes',
        'late_rate_per_hour',
        'late_rate_per_minute',
        'late_amount',

        'early_departure_minutes',
        'early_departure_rate_per_hour',
        'early_departure_rate_per_minute',
        'early_departure_amount',

        'total_bonus_amount',
        'settings_deduction_type_id',
        'deduction_rate_type',
        'deduction_salary_type',
        'deduction_rate',
        'deduction_amount',
        'custom_add_amount_text',
        'custom_add_amount',
        'custom_deduct_amount_text',
        'custom_deduct_amount',
        'net_payable_salary',
        'paid_salary',
        'salary_paid_status',
        'slip_generated',
        'status',
        'deleted',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
        'deleted_by',
        'deleted_at',
        ];

}
