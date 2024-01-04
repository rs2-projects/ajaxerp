<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractorEmergencyContact extends Model
{
    use HasFactory;

    protected $table = 'contractor_emergency_contacts';
    public $timestamps = false;

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
    const STATUS = [
        self::STATUS_ACTIVE => 'Active',
        self::STATUS_INACTIVE => 'Inactive'
    ];

    protected $fillable = [
        'contractor_id',
        'name',
        'email',
        'phone',
        'relationship',
        'status'
    ];
}
