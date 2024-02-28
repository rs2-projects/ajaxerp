<?php

namespace App\Models\Production;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreProductionMaterialDeliveryDetails extends Model
{
    use HasFactory;

    protected $table = 'pre_production_material_delivery_details';
    public $timestamps = false;

    const RECEIVED_STATUS_PENDING = 0;
    const RECEIVED_STATUS_DELIVERED = 1;
    const RECEIVED_STATUS_PARTIAL = 2;
    const RECEIVEDS = [
        self::RECEIVED_STATUS_PENDING => 'Not Received',
        self::RECEIVED_STATUS_DELIVERED => 'Perfect',
        self::RECEIVED_STATUS_PARTIAL => 'Missing',
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
        'pre_production_id',
        'pre_production_material_delivery_id',
        'pre_production_material_id',
        'product_material_id',
        'total_quantity',
        'quantity',
        'received_qty',
        'received_status',
        'status',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
        'deleted',
        'deleted_by',
        'deleted_at',
    ];

    public function pre_production()
    {
        return $this->belongsTo(PreProduction::class, 'pre_production_id', 'id')->where('deleted', PreProduction::DELETED_NO);
    }
    public function material()
    {
        return $this->belongsTo(PreProductionMaterial::class, 'pre_production_material_id', 'id')->where('deleted', PreProductionMaterial::DELETED_NO);
    }
    public function items()
    {
        return $this->hasMany(PreProductionMaterialDeliveryDetailsItems::class, 'pre_production_material_delivery_details_id', 'id');
    }
}
