<?php

namespace App\Models\Inventory;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductRequisitionDelivery extends BaseModel
{
    use HasFactory;

    protected $table = 'product_requisition_deliveries';
    public $timestamps = false;

    const RECEIVED_STATUS_PENDING = 0;
    const RECEIVED_STATUS_RECEIVED = 1;
    const RECEIVED_STATUS_PARTIALLY_RECEIVED = 2;

    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    const DELETED_NO = 0;
    const DELETED_YES = 1;

    protected $fillable = [
        'delivery_no',
        'product_requisition_id',
        'delivery_date',
        'delivered_by',
        'delivered_at',
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
