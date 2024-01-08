<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceHistoryToday extends Model
{
    use HasFactory;

    protected $table = 'attendance_history_todays';
    public $timestamps = false;

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

    const TYPE_IN = 1;
    const TYPE_OUT = 2;
    const TYPES = [
        self::TYPE_IN => 'In',
        self::TYPE_OUT => 'Out',
    ];

    const ATTENDANCE_BY_EMPLOYEE = 0;
    const ATTENDANCE_BY_ADMIN = 1;
    const ATTENDANCE_BY = [
        self::ATTENDANCE_BY_EMPLOYEE => 'Employee',
        self::ATTENDANCE_BY_ADMIN => 'Admin',
    ];

    protected $fillable = [
        'employee_id',
        'datetime',
        'type',
        'latitude',
        'longitude',
        'image',
        'attendance_by',
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
        'type_text',
    ];

    public function getTypeTextAttribute()
    {
        return self::TYPES[$this->type];
    }
    public function employee()
    {
        return $this->belongsTo(User::class, 'employee_id', 'id');
    }

    public function attendance_by()
    {
        return $this->belongsTo(User::class, 'attendance_by', 'id');
    }
}
