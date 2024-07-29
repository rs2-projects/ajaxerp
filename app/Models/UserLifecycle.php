<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLifecycle extends Model
{
    use HasFactory;

    protected $table = 'user_lifecycles';

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

    const TYPE_JOIN = 0;
    const TYPE_PROMOTION = 1;
    const TYPE_DEMOTION = 2;
    const TYPE_SALARY_UPDATE = 3;
    const TYPE_TERMINATION = 4;
    const TYPE_RESIGNATION_REQUESTED = 5;
    const TYPE_RESIGNATION_REJECTED = 6;
    const TYPE_RESIGNATION_APPROVED = 7;

    const TYPES = [
        self::TYPE_JOIN => 'Join',
        self::TYPE_PROMOTION => 'Promotion',
        self::TYPE_DEMOTION => 'Demotion',
        self::TYPE_SALARY_UPDATE => 'Salary Update',
        self::TYPE_TERMINATION => 'Termination',
        self::TYPE_RESIGNATION_REQUESTED => 'Resignation Requested',
        self::TYPE_RESIGNATION_REJECTED => 'Resignation Rejected',
        self::TYPE_RESIGNATION_APPROVED => 'Resignation Approved'
    ];

    protected $fillable = [
        'user_id',
        'type',
        'date',
        'department_id',
        'designation_id',
        'basic_salary',
        'reference_description',
        'description',
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
