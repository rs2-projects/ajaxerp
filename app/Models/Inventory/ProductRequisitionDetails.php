<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductRequisitionDetails extends Model
{
    use HasFactory;

    protected $table = 'product_requisition_details';
    public $timestamps = false;

    const DELIVERY_STATUS_PENDING = 0;
    const DELIVERY_STATUS_DELIVERED = 1;
    const DELIVERY_STATUS_PARTIALLY_DELIVERED = 2;

    const RECEIVED_STATUS_PENDING = 0;
    const RECEIVED_STATUS_RECEIVED = 1;
    const RECEIVED_STATUS_PARTIALLY_RECEIVED = 2;

    protected $fillable = [
        'product_requisition_id',
        'product_type',
        'product_id',
        'qty',
        'delivered_qty',
        'delivery_status',
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
