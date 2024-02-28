<?php

namespace App\Models\Production;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Products\FinishedGoods;
class PreProduction extends Model
{
    use HasFactory;

    protected $table = 'pre_productions';
    public $timestamps = false;

    const VERIFIED_NO = 0;
    const VERIFIED_YES = 1;
    const VERIFIEDS = [
        self::VERIFIED_NO => 'Not Verified',
        self::VERIFIED_YES => 'Verified',
    ];

    const DELIVERY_STATUS_PENDING = 0;
    const DELIVERY_STATUS_DELIVERED = 1;
    const DELIVERY_STATUS_PARTIAL = 2;
    const DELIVERIES = [
        self::DELIVERY_STATUS_PENDING => 'Pending',
        self::DELIVERY_STATUS_DELIVERED => 'Delivered',
        self::DELIVERY_STATUS_PARTIAL => 'Partial',
    ];

    const RECEIVED_STATUS_PENDING = 0;
    const RECEIVED_STATUS_DELIVERED = 1;
    const RECEIVED_STATUS_PARTIAL = 2;
    const RECEIVEDS = [
        self::RECEIVED_STATUS_PENDING => 'Pending',
        self::RECEIVED_STATUS_DELIVERED => 'Received',
        self::RECEIVED_STATUS_PARTIAL => 'Partial',
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

    public function finishedGoods()
    {
        return $this->belongsTo(FinishedGoods::class, 'finished_goods_id', 'id');
    }

    public function process()
    {
        return $this->hasMany(PreProductionProcess::class, 'pre_production_id', 'id')->where('deleted', PreProductionProcess::DELETED_NO);
    }

    public function material()
    {
        return $this->hasMany(PreProductionProcessMaterial::class, 'pre_production_id', 'id');
    }

    public function production_material()
    {
        return $this->hasMany(PreProductionMaterial::class, 'pre_production_id', 'id')->where('deleted', PreProductionMaterial::DELETED_NO);
    }
}
