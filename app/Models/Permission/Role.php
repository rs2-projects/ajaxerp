<?php

namespace App\Models\Permission;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends BaseModel
{
    use HasFactory;

    protected $table = 'roles';
    public $timestamps = false;

    const IS_DEFAULT_NO = 0;
    const IS_DEFAULT_YES = 1;
    const DEFAULTS = [
        self::IS_DEFAULT_NO => 'No',
        self::IS_DEFAULT_YES => 'Yes',
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
        'slug',
        'title',
        'description',
        'is_default',
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
