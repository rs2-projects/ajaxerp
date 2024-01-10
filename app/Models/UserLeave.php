<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLeave extends Model
{
    use HasFactory;

    protected $table = 'user_leaves';
    public $timestamps = false;

    const LEAVE_STATUS_PENDING = 0;
    const LEAVE_STATUS_APPROVED = 1;
    const LEAVE_STATUS_REJECTED = 2;
    const LEAVE_STATUSES = [
        self::LEAVE_STATUS_PENDING => 'Pending',
        self::LEAVE_STATUS_APPROVED => 'Approved',
        self::LEAVE_STATUS_REJECTED => 'Rejected',
    ];

    const IS_PAID_NO = 0;
    const IS_PAID_YES = 1;
    const IS_PAIDS = [
        self::IS_PAID_NO => 'No',
        self::IS_PAID_YES => 'Yes',
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
        'user_id',
        'settings_leave_type_id',
        'start_date',
        'end_date',
        'number_of_days',
        'reason',
        'leave_status',
        'accepted_at',
        'accepted_by',
        'approve_start_date',
        'approve_end_date',
        'approved_number_of_days',
        'paid_leave_start_date',
        'paid_leave_end_date',
        'paid_leave_number_of_days',
        'unpaid_leave_start_date',
        'unpaid_leave_end_date',
        'unpaid_leave_number_of_days',
        'rejected_at',
        'rejected_by',
        'reject_reason',
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
        'leave_status_label',
    ];

    public function getLeaveStatusLabelAttribute()
    {
        return self::LEAVE_STATUSES[$this->leave_status] ?? self::LEAVE_STATUSES[0];
    }


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function settingsLeaveType()
    {
        return $this->belongsTo(SettingsLeaveType::class, 'settings_leave_type_id');
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'accepted_by');
    }
}
