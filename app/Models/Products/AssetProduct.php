<?php

namespace App\Models\Products;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetProduct extends Model
{
    use HasFactory;

    protected $table = 'asset_products';
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
        'asset_product_category_id',
        'name',
        'image',
        'description',
        'comments',
        'total_purchased_qty',
        'total_returned_qty',
        'total_damage_qty',
        'available_qty',
        'assigned_qty',
        'maintenance_qty',
        'sold_qty',
        'disposed_qty',
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

    public function category()
    {
        return $this->belongsTo(AssetProductCategory::class, 'asset_product_category_id', 'id');
    }
}
