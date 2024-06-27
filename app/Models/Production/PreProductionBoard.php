<?php

namespace App\Models\Production;

use App\Models\BaseModel;
use App\Models\Products\FinishedGoods;
use App\Models\Products\FinishedGoodsCategory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PreProductionBoard extends BaseModel
{
    use HasFactory;

    protected $table = 'pre_production_boards';
    public $timestamps = false;

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

    const SCAN_STATUS_PENDING = 0;
    const SCAN_STATUS_SCANNED = 1;
    const SCAN_STATUS_PARTIAL = 2;
    const SCANNED = [
        self::SCAN_STATUS_PENDING => 'Pending',
        self::SCAN_STATUS_SCANNED => 'Scanned',
        self::SCAN_STATUS_PARTIAL => 'Partial',
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
        'finished_board_category_id',
        'finished_board_id',
        'quantity',
        'base_quantity',
        'extra_quantity',
        'delivered_qty',
        'received_qty',
        'scanned_qty',
        'delivery_status',
        'received_status',
        'scan_status',
        'status',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
        'deleted',
        'deleted_by',
        'deleted_at',
    ];

    public function category()
    {
        return $this->belongsTo(FinishedGoodsCategory::class, 'finished_board_category_id', 'id');
    }
    public function product()
    {
        return $this->belongsTo(FinishedGoods::class, 'finished_board_id', 'id');
    }
}
