<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceReport extends Model
{
    use HasFactory;

    protected $table = 'attendance_reports';
    public $timestamps = false;

    const TIME_IN_STATUS_NOT_SET = 0;
    const TIME_IN_STATUS_ON_TIME = 1;
    const TIME_IN_STATUS_LATE = 2;
    const TIME_IN_STATUSES = [
        self::TIME_IN_STATUS_NOT_SET => 'Not Set',
        self::TIME_IN_STATUS_ON_TIME => 'On Time',
        self::TIME_IN_STATUS_LATE => 'Late'
    ];

    const TIME_OUT_STATUS_NOT_SET = 0;
    const TIME_OUT_STATUS_ON_TIME = 1;
    const TIME_OUT_STATUS_EARLY = 2;
    const TIME_OUT_STATUSES = [
        self::TIME_OUT_STATUS_NOT_SET => 'Not Set',
        self::TIME_OUT_STATUS_ON_TIME => 'On Time',
        self::TIME_OUT_STATUS_EARLY => 'Early'
    ];

    const IS_PRESENT_ABSENT = 0;
    const IS_PRESENT_PRESENT = 1;
    const IS_PRESENTS = [
        self::IS_PRESENT_ABSENT => 'Absent',
        self::IS_PRESENT_PRESENT => 'Present'
    ];

    const IS_HOLIDAY_NOT_HOLIDAY = 0;
    const IS_HOLIDAY_HOLIDAY = 1;
    const IS_HOLIDAYS = [
        self::IS_HOLIDAY_NOT_HOLIDAY => 'Not Holiday',
        self::IS_HOLIDAY_HOLIDAY => 'Holiday'
    ];

    const IS_WEEKEND_NOT_WEEKEND = 0;
    const IS_WEEKEND_WEEKEND = 1;
    const IS_WEEKENDS = [
        self::IS_WEEKEND_NOT_WEEKEND => 'Not Weekend',
        self::IS_WEEKEND_WEEKEND => 'Weekend'
    ];

    const IS_LEAVE_NOT_LEAVE = 0;
    const IS_LEAVE_LEAVE = 1;
    const IS_LEAVES = [
        self::IS_LEAVE_NOT_LEAVE => 'Not Leave',
        self::IS_LEAVE_LEAVE => 'Leave'
    ];

    const LEAVE_TYPE_NOT_SET = 0;
    const LEAVE_TYPE_PAID = 1;
    const LEAVE_TYPE_UNPAID = 2;
    const LEAVE_TYPES = [
        self::LEAVE_TYPE_NOT_SET => 'Not Set',
        self::LEAVE_TYPE_PAID => 'Paid',
        self::LEAVE_TYPE_UNPAID => 'Unpaid'
    ];

    const INPUTTED_BY_TYPE_CRON = 0;
    const INPUTTED_BY_TYPE_EMPLOYEE = 1;
    const INPUTTED_BY_TYPE_ADMIN = 2;
    const INPUTTED_BY_TYPES = [
        self::INPUTTED_BY_TYPE_CRON => 'Cron',
        self::INPUTTED_BY_TYPE_EMPLOYEE => 'Employee',
        self::INPUTTED_BY_TYPE_ADMIN => 'Admin'
    ];

    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUSES = [
        self::STATUS_INACTIVE => 'Inactive',
        self::STATUS_ACTIVE => 'Active'
    ];

    const DELETED_NO = 0;
    const DELETED_YES = 1;
    const DELETEDS = [
        self::DELETED_NO => 'No',
        self::DELETED_YES => 'Yes'
    ];

    protected $fillable = [
        'employee_id',
        'settings_salary_set_id',
        'date',
        'time_in',
        'time_out',
        'time_in_status',
        'time_out_status',
        'is_present',
        'is_holiday',
        'is_weekend',
        'is_leave',
        'leave_type',
        'settings_leave_type_id',
        'total_work_time',
        'total_overtime',
        'normal_day_overtime',
        'special_day_overtime',
        'total_break_time',
        'late_time',
        'early_leaving_time',
        'inputted_by_type',
        'status',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by',
        'deleted',
        'deleted_at',
        'deleted_by',
    ];

    public function employee()
    {
        return $this->belongsTo(User::class, 'employee_id');
    }

    public function settingsLeaveType()
    {
        return $this->belongsTo(SettingsLeaveType::class, 'settings_leave_type_id');
    }
}
