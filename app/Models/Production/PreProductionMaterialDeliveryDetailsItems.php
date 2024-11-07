<?php

namespace App\Models\Production;

use App\Models\BaseModel;
use App\Models\Procurements\ProductMaterialPurchaseDetails;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PreProductionMaterialDeliveryDetailsItems extends BaseModel
{
    use HasFactory;

    protected $table = 'pre_production_material_delivery_details_items';
    public $timestamps = false;

    const RECEIVED_NO = 0;
    const RECEIVED_YES = 1;
    const RECEIVEDS = [
        self::RECEIVED_NO => 'No',
        self::RECEIVED_YES => 'Yes',
    ];

    const SCANNED_NO = 0;
    const SCANNED_YES = 1;
    const SCANNEDS = [
        self::SCANNED_NO => 'No',
        self::SCANNED_YES => 'Yes',
    ];

    const RECEIVED_STATUS_PENDING = 0;
    const RECEIVED_STATUS_RECEIVED = 1;
    const RECEIVED_STATUS_PARTIAL = 2;
    const RECEIVED_STATUSES = [
        self::RECEIVED_STATUS_PENDING => 'Pending',
        self::RECEIVED_STATUS_RECEIVED => 'Received',
        self::RECEIVED_STATUS_PARTIAL => 'Partial',
    ];

    const SCAN_STATUS_PENDING = 0;
    const SCAN_STATUS_SCANNED = 1;
    const SCAN_STATUS_PARTIAL = 2;
    const SCAN_STATUSES = [
        self::SCAN_STATUS_PENDING => 'Pending',
        self::SCAN_STATUS_SCANNED => 'Scanned',
        self::SCAN_STATUS_PARTIAL => 'Partial',
    ];


    protected $fillable = [
        'pre_production_id',
        'pre_production_material_delivery_id',
        'pre_production_material_delivery_details_id',
        'pre_production_material_id',
        'product_material_id',
        'product_material_purchase_details_id',
        'quantity',
        'received_qty',
        'received_status',
        'scanned_qty',
        'scan_status',
        'barcode',
        'received',
        'scanned'
    ];

    public function purchase_details() {
        return $this->belongsTo(ProductMaterialPurchaseDetails::class, 'product_material_purchase_details_id', 'id');
    }
}
