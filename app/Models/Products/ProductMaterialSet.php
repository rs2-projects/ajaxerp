<?php

namespace App\Models\Products;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductMaterialSet extends Model
{
    use HasFactory;

    protected $table = 'product_material_sets';
    public $timestamps = false;

    const PRICE_CALCULATED_NO = 0;
    const PRICE_CALCULATED_YES = 1;
    
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
        'name',
        'rp_cost',
        'srp_markup_percent',
        'wholesale_discount_percent',
        'rp_srp',
        'srp_with_discount',
        'wholesale',
        'price_calculated',
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
        return asset('assets/img/placeholder.jpg');
    }

    public function set_items(){
        return $this->hasMany(ProductMaterialSetItem::class, 'product_material_set_id', 'id')
            ->where('deleted', ProductMaterialSetItem::DELETED_NO)
            ->where('status', ProductMaterialSetItem::STATUS_ACTIVE);
    }
}
