<?php

namespace App\Models\Procurements;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $table = 'suppliers';
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
        'account_no',
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
    
    public function getShowImageAttribute()
    {
        if ($this->image != null && $this->image != '') {
            return asset($this->image);
        }
        return asset('assets/img/placeholder.jpg');
    }

    public function supplierBanks()
    {
        return $this->hasMany(SupplierBank::class, 'supplier_id', 'id');
    }
    public function supplierContacts()
    {
        return $this->hasMany(SupplierContact::class, 'supplier_id', 'id');
    }
    public function supplierMaterials()
    {
        return $this->hasMany(SupplierProductMaterial::class, 'supplier_id', 'id');
    }
    public function supplierAssets()
    {
        return $this->hasMany(SupplierAssetProduct::class, 'supplier_id', 'id');
    }
}
