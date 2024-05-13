<?php

namespace App\Models\Production;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class ProductionStaff extends Authenticatable
{
    use HasFactory;

    protected $table = 'production_staff';
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

    protected $fillable = [
        'title',
        'user_name',
        'password',
        'remember_token',
        'status',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
        'deleted',
        'deleted_by',
        'deleted_at',
    ];
}
