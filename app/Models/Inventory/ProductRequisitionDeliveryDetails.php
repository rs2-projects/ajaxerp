<?php

namespace App\Models\Inventory;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductRequisitionDeliveryDetails extends BaseModel
{
    use HasFactory;

    protected $table = 'product_requisition_delivery_details';
    public $timestamps = false;

    const RECEIVED_STATUS_PENDING = 0;
    const RECEIVED_STATUS_RECEIVED = 1;
    const RECEIVED_STATUS_PARTIALLY_RECEIVED = 2;


    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    const DELETED_NO = 0;
    const DELETED_YES = 1;

    protected $fillable = [
        'product_requisition_delivery_id',
        'product_requisition_id',
        'product_requisition_detail_id',
        'product_material_purchase_detail_id',
        'product_id',
        'delivered_qty',
        'received_qty',
        'received_status',
        'status',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by',
        'deleted',
        'deleted_at',
        'deleted_by',
    ];
}
