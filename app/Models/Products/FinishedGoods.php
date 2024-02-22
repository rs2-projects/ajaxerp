<?php

namespace App\Models\Products;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinishedGoods extends Model
{
    use HasFactory;

    protected $table = 'finished_goods';
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
        'finished_goods_category_id',
        'name',
        'code',
        'image',
        'description',
        'total_finished_qty',
        'total_sale_qty',
        'total_returned_qty',
        'total_damage_qty',
        'available_qty',
        'working_temperature',
        'length',
        'width',
        'thickness',
        'remarks',
        'warehouse_id',
        'comments',
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
    
    // public function category()
    // {
    //     return $this->belongsTo(AssetProductCategory::class, 'asset_product_category_id', 'id');
    // }
}
