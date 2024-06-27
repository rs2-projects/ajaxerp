<?php

namespace App\Models\Procurements;

use App\Models\BaseModel;
use App\Models\Products\AssetProduct;
use App\Models\Products\AssetProductCategory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AssetProductPurchaseRequestDetails extends BaseModel
{
    use HasFactory;

    protected $table = 'asset_product_purchase_request_details';
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
        'asset_product_purchase_request_id',
        'asset_product_category_id',
        'asset_product_id',
        'qty',
        'description',
        'file',
        'is_purchased',
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
        if ($this->file != null && $this->file != '') {
            return asset($this->file);
        }
        return asset('assets/img/placeholder.jpg');
    }

    public function asset_category()
    {
        return $this->belongsTo(AssetProductCategory::class, 'asset_product_category_id', 'id');
    }
    public function asset_product()
    {
        return $this->belongsTo(AssetProduct::class, 'asset_product_id', 'id');
    }
}
