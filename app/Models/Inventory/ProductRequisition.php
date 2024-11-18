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
    const DELIVERY_STATUSES = [
        self::DELIVERY_STATUS_PENDING => 'Pending',
        self::DELIVERY_STATUS_DELIVERED => 'Delivered',
        self::DELIVERY_STATUS_PARTIALLY_DELIVERED => 'Partial',
    ];

    const RECEIVED_STATUS_PENDING = 0;
    const RECEIVED_STATUS_RECEIVED = 1;
    const RECEIVED_STATUS_PARTIALLY_RECEIVED = 2;
    const RECEIVED_STATUSES = [
        self::RECEIVED_STATUS_PENDING => 'Pending',
        self::RECEIVED_STATUS_RECEIVED => 'Received',
        self::RECEIVED_STATUS_PARTIALLY_RECEIVED => 'Partial',
    ];

    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    const DELETED_NO = 0;
    const DELETED_YES = 1;

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

    public function details()
    {
        return $this->hasMany(ProductRequisitionDetails::class, 'product_requisition_id', 'id');
    }
}
