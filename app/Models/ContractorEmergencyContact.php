<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractorEmergencyContact extends Model
{
    use HasFactory;

    protected $table = 'contractor_emergency_contacts';
    public $timestamps = false;

    protected $fillable = [
        'contractor_id',
        'name',
        'email',
        'phone',
        'relationship',
        'status'
    ];
}
