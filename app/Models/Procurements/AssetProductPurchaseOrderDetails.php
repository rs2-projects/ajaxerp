<?php

namespace App\Models\Procurements;

use App\Models\Accounting\AccCoaAccount;
use App\Models\Products\AssetProduct;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetProductPurchaseOrderDetails extends Model
{
    use HasFactory;

    protected $table = 'asset_product_purchase_order_details';
    public $timestamps = false;

    const IS_PERFECT_NO = 0;
    const IS_PERFECT_YES = 1;
    const IS_PERFECTS = [
        self::IS_PERFECT_NO => 'No',
        self::IS_PERFECT_YES => 'Yes',
    ];

    const HAS_DAMAGE_NO = 0;
    const HAS_DAMAGE_YES = 1;
    const HAS_DAMAGES = [
        self::HAS_DAMAGE_NO => 'No',
        self::HAS_DAMAGE_YES => 'Yes',
    ];

    const HAS_MISSING_NO = 0;
    const HAS_MISSING_YES = 1;
    const HAS_MISSINGS = [
        self::HAS_MISSING_NO => 'No',
        self::HAS_MISSING_YES => 'Yes',
    ];

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
        'asset_product_purchase_order_id',
        'asset_product_id',
        'asset_product_purchase_request_id',
        'asset_product_purchase_request_detail_id',
        'description',
        'warranty',
        'qty',
        'unit_price_php',
        'total_price_php',
        'tax_amount_php',
        'net_total_php',
        'unit_price',
        'total_price',
        'tax_id',
        'tax_rate',
        'tax_amount',
        'net_total',
        'is_perfect',
        'has_damage',
        'damage_qty',
        'damage_remarks',
        'has_missing',
        'missing_qty',
        'missing_remarks',
        'status',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
        'deleted',
        'deleted_by',
        'deleted_at',
    ];

    public function assetProduct()
    {
        return $this->belongsTo(AssetProduct::class, 'asset_product_id', 'id');
    }

    public function assetPurchase()
    {
        return $this->belongsTo(AssetProductPurchaseOrder::class, 'asset_product_purchase_order_id', 'id');
    }
}
