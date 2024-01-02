<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserResignation extends Model
{
    use HasFactory;

    protected $table = 'user_resignations';
    public $timestamps = false;

    const RESIGNATION_STATUS_PENDING = 0;
    const RESIGNATION_STATUS_APPROVED = 1;
    const RESIGNATION_STATUS_REJECTED = 2;
    const RESIGNATION_STATUSES = [
        self::RESIGNATION_STATUS_PENDING => 'Pending',
        self::RESIGNATION_STATUS_APPROVED => 'Approved',
        self::RESIGNATION_STATUS_REJECTED => 'Rejected',
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
        'notice_date',
        'resignation_date',
        'reason',
        'remarks',
        'resignation_status',
        'approved_at',
        'approved_by',
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
}
