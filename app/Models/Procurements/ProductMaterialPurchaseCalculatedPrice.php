<?php

namespace App\Models\Procurements;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductMaterialPurchaseCalculatedPrice extends Model
{
    use HasFactory;

    protected $table = 'product_material_purchase_calculated_prices';
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
        'product_type',
        'product_material_purchase_id',
        'product_material_purchase_detail_id',
        'product_material_id',
        'qty',
        'price',
        'exchange_rate',
        'price_fob',
        'cbm',
        'total_pieces_per_container',
        'freight_cost_usd',
        'exchange_rate_after_import',
        'freight_cost',
        'total_taxes_import_duties',
        'taxes_import_duties',
        'total_transport_cost_to_wh',
        'transport_cost_to_wh',
        'total_unloading_cost',
        'unloading_cost',
        'handling_cost',
        'price_excluding_vat',
        'vat_percent',
        'vat',
        'final_price',
        'total_final_price',
        'status',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
        'deleted',
        'deleted_by',
        'deleted_at',
    ];

    public function materialPurchase()
    {
        return $this->belongsTo(ProductMaterialPurchase::class, 'product_material_purchase_id', 'id');
    }

    public function purchaseDetails()
    {
        return $this->hasMany(ProductMaterialPurchaseDetails::class, 'product_material_purchase_id', 'id')->where('deleted', ProductMaterialPurchaseDetails::DELETED_NO);
    }
}
