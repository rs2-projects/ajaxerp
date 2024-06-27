<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserEmergencyContact extends BaseModel
{
    use HasFactory;

    protected $table = 'user_emergency_contacts';
    public $timestamps = false;

    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUSES = [
        self::STATUS_INACTIVE => 'Inactive',
        self::STATUS_ACTIVE => 'Active',
    ];

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone',
        'relation',
        'status',
    ];
}
