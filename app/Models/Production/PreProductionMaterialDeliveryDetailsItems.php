<?php

namespace App\Models\Production;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreProductionMaterialDeliveryDetailsItems extends Model
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

    protected $fillable = [
        'pre_production_id',
        'pre_production_material_delivery_id',
        'pre_production_material_delivery_details_id',
        'pre_production_material_id',
        'product_material_id',
        'product_material_purchase_details_id',
        'barcode',
        'received'
    ];
}
