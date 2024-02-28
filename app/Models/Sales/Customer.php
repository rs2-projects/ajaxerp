<?php

namespace App\Models\Sales;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $table = 'customers';
    public $timestamps = false;
    //status const
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUSES = [
        self::STATUS_INACTIVE => 'Inactive',
        self::STATUS_ACTIVE => 'Active',
    ];
    //delete status const
    const DELETED_NO = 0;
    const DELETED_YES = 1;
    const DELETEDS = [
        self::DELETED_NO => 'No',
        self::DELETED_YES => 'Yes',
    ];

    protected $fillable = [
        'business_name',
        'image',
        'email',
        'phone',
        'contact_first_name',
        'contact_last_name',
        'lead_time_status',
        'address',
        'city',
        'zip_code',
        'country_id',
        'state_id',
        'fax',
        'website',
        'notes',
        'status',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
        'deleted',
        'deleted_by',
        'deleted_at',
    ];
    //show image
    public function getShowImageAttribute()
    {
        if ($this->image != null && $this->image != '') {
            return asset($this->image);
        }
        return asset('assets/img/placeholder.jpg');
    }
    // get full name
    public function getFullNameAttribute()
    {
        return $this->contact_first_name.' '.$this->contact_last_name;
    }
    //customer and bank relationship
    public function customerBanks()
    {
        return $this->hasMany(CustomerBank::class, 'customer_id', 'id');
    }
    //customer and contacts relationship
    public function customerContacts()
    {
        return $this->hasMany(CustomerContact::class, 'customer_id', 'id');
    }
}
