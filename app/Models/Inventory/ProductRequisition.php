<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductRequisition extends Model
{
    use HasFactory;

    protected $table = 'product_requisitions';
    public $timestamps = false;

    const DELIVERY_STATUS_PENDING = 0;
    const DELIVERY_STATUS_DELIVERED = 1;
    const DELIVERY_STATUS_PARTIALLY_DELIVERED = 2;

    const RECEIVED_STATUS_PENDING = 0;
    const RECEIVED_STATUS_RECEIVED = 1;
    const RECEIVED_STATUS_PARTIALLY_RECEIVED = 2;

    protected $fillable = [
        'requisition_no',
        'production_staff_id',
        'description',
        'delivery_status',
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
