<?php

namespace App\Models\Production;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PreProductionBoardDeliveryDetails extends BaseModel
{
    use HasFactory;

    protected $table = 'pre_production_board_delivery_details';
    public $timestamps = false;

    const RECEIVED_STATUS_PENDING = 0;
    const RECEIVED_STATUS_DELIVERED = 1;
    const RECEIVED_STATUS_PARTIAL = 2;
    const RECEIVEDS = [
        self::RECEIVED_STATUS_PENDING => 'Not Received',
        self::RECEIVED_STATUS_DELIVERED => 'Perfect',
        self::RECEIVED_STATUS_PARTIAL => 'Missing',
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
        'pre_production_board_delivery_id',
        'pre_production_board_id',
        'finished_board_id',
        'total_quantity',
        'quantity',
        'received_qty',
        'received_status',
        'scanned_qty',
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

    public function board()
    {
        return $this->belongsTo(PreProductionBoard::class, 'pre_production_board_id', 'id')->where('deleted', PreProductionMaterial::DELETED_NO);
    }

    public function items()
    {
        return $this->hasMany(PreProductionBoardDeliveryDetailsItem::class, 'pre_production_board_delivery_details_id', 'id');
    }

    public function pending_items()
    {
        return $this->hasMany(PreProductionBoardDeliveryDetailsItem::class, 'pre_production_board_delivery_details_id', 'id')
            ->where('received', PreProductionBoardDeliveryDetailsItem::RECEIVED_NO);
    }

    public function pending_scans()
    {
        return $this->hasMany(PreProductionBoardDeliveryDetailsItem::class, 'pre_production_board_delivery_details_id', 'id')
            ->where('scanned', PreProductionBoardDeliveryDetailsItem::SCANNED_NO)
            ->where('received', PreProductionBoardDeliveryDetailsItem::RECEIVED_YES);
    }

}
