<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserLeaveDetail extends BaseModel
{
    use HasFactory;

    protected $table = 'user_leave_details';
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

    const DAY_TYPE_GENERAL = 0;
    const DAY_TYPE_WEEKEND = 1;
    const DAY_TYPE_HOLIDAY = 2;
    const DAY_TYPES = [
        self::DAY_TYPE_GENERAL => 'General',
        self::DAY_TYPE_WEEKEND => 'Weekend',
        self::DAY_TYPE_HOLIDAY => 'Holiday',
    ];

    const IS_PAID_UNPAID = 0;
    const IS_PAID_PAID = 1;
    const IS_PAIDS = [
        self::IS_PAID_UNPAID => 'Unpaid',
        self::IS_PAID_PAID => 'Paid',
    ];

    const LEAVE_STATUS_PENDING = 0;
    const LEAVE_STATUS_APPROVED = 1;
    const LEAVE_STATUS_REJECTED = 2;
    const LEAVE_STATUSES = [
        self::LEAVE_STATUS_PENDING => 'Pending',
        self::LEAVE_STATUS_APPROVED => 'Approved',
        self::LEAVE_STATUS_REJECTED => 'Rejected',
    ];

    protected $fillable = [
        'user_id',
        'settings_leave_type_id',
        'user_leave_id',
        'date',
        'day_type',
        'is_paid',
        'leave_status',
        'status',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by',
        'deleted',
        'deleted_at',
        'deleted_by',
    ];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
