<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserTermination extends Model
{
    use HasFactory;

    protected $table = 'user_terminations';
    public $timestamps = false;

    const TERMINATION_STATUS_PENDING = 0;
    const TERMINATION_STATUS_APPROVED = 1;
    const TERMINATION_STATUS_REJECTED = 2;
    const TERMINATION_STATUSES = [
        self::TERMINATION_STATUS_PENDING => 'Pending',
        self::TERMINATION_STATUS_APPROVED => 'Approved',
        self::TERMINATION_STATUS_REJECTED => 'Rejected',
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
        'settings_termination_type_id',
        'notice_date',
        'termination_date',
        'reason',
        'remarks',
        'termination_status',
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
