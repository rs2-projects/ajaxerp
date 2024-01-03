<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contractor extends Model
{
    use HasFactory;

    protected $table = 'contractors';
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

    protected $fillable = [
        'name',
        'email',
        'phone',
        'image',
        'phone2',
        'company_name',
        'company_address',
        'contract_value',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
        'deleted',
        'deleted_at',
        'deleted_by'
    ];

    protected $appends = [
        'show_image',
    ];

    public function getShowImageAttribute()
    {
        if ($this->image != null && $this->image != '') {
            return asset($this->image);
        }
        return asset('assets/img/profiles/man.png');
    }
    public function emergencyContacts()
    {
        return $this->hasMany(ContractorEmergencyContact::class, 'contractor_id', 'id');
    }
}
