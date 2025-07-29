<?php

namespace App\Models\Production;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Products\FinishedGoods;

class PreProduction extends BaseModel
{
    use HasFactory;

    protected $table = 'pre_productions';
    public $timestamps = false;

    //type
    const TYPE_OTHERS = 0;
    const TYPE_BOARD = 1;
    
    const VERIFIED_NO = 0;
    const VERIFIED_YES = 1;
    const VERIFIED_REVISION = 2;
    const VERIFIED_REJECTED = 3;

    const VERIFIEDS = [
        self::VERIFIED_NO => 'Not Verified',
        self::VERIFIED_YES => 'Verified',
        self::VERIFIED_REVISION => 'Revision',
        self::VERIFIED_REJECTED => 'Rejected',
    ];

    const PROCESS_STATUS_PENDING = 0;
    const PROCESS_STATUS_PROCESSING = 1;
    const PROCESS_STATUS_COMPLETED = 2;
    const PROCESSES = [
        self::PROCESS_STATUS_PENDING => 'Pending',
        self::PROCESS_STATUS_PROCESSING => 'Processing',
        self::PROCESS_STATUS_COMPLETED => 'Completed',
    ];

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

    const DISPATCH_STATUS_PENDING = 0;
    const DISPATCH_STATUS_DISPATCHED = 1;
    const DISPATCH_STATUS_PARTIAL = 2;
    const DISPATCHS = [
        self::DISPATCH_STATUS_PENDING => 'Not Dispatched',
        self::DISPATCH_STATUS_DISPATCHED => 'Dispatched',
        self::DISPATCH_STATUS_PARTIAL => 'Partially Dispatched',
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
        'type',
        'date',
        'board_pre_production_id',
        'invoice_id',
        'pre_production_no',
        'pre_production_batch_no',
        'order_details',
        'image',
        'design_of_documents',
        'description',
        'finished_goods_id',
        'estimated_production_qty',
        'notes',
        'is_verified',
        'process_status',
        'delivery_status',
        'received_status',
        'scan_status',
        'dispatched_qty',
        'dispatched_status',
        'damage_qty',
        'received_qty',
        'sale_qty',
        'used_qty',
        'available_qty',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
        'deleted',
        'deleted_by',
        'deleted_at',
    ];

    public function finishedGoods()
    {
        return $this->belongsTo(FinishedGoods::class, 'finished_goods_id', 'id');
    }

    public function process()
    {
        return $this->hasMany(PreProductionProcess::class, 'pre_production_id', 'id')
            ->where('deleted', PreProductionProcess::DELETED_NO)
            ->where('status', PreProductionProcess::STATUS_ACTIVE);
    }

    // production staff wise process

    public function pstaff_process()
    {
        return $this->hasMany(PreProductionProcess::class, 'pre_production_id', 'id')
            ->where('deleted', PreProductionProcess::DELETED_NO)
            ->where('status', PreProductionProcess::STATUS_ACTIVE)
            ->where('production_staff_id', auth()->guard('production-staff')->user()->id);
    }

    // process materials
    public function material()
    {
        return $this->hasMany(PreProductionProcessMaterial::class, 'pre_production_id', 'id');
    }

    // production materials
    public function production_material()
    {
        return $this->hasMany(PreProductionMaterial::class, 'pre_production_id', 'id')
            ->where('deleted', PreProductionMaterial::DELETED_NO)
            ->where('status', PreProductionMaterial::STATUS_ACTIVE);
    }

    public function board_material()
    {
        return $this->hasMany(PreProductionBoard::class, 'pre_production_id', 'id')
            ->where('deleted', PreProductionBoard::DELETED_NO)
            ->where('status', PreProductionBoard::STATUS_ACTIVE);
    }

    public function pendingPreProductionMaterialDeliveries()
    {
        return $this->hasMany(PreProductionMaterialDelivery::class, 'pre_production_id', 'id')
            ->where('deleted', PreProductionMaterialDelivery::DELETED_NO)
            ->where('status', PreProductionMaterialDelivery::STATUS_ACTIVE)
            ->where('received_status', '!=', PreProductionMaterialDelivery::RECEIVED_STATUS_DELIVERED);
    }

    public function pendingPreProductionBoardDeliveries()
    {
        return $this->hasMany(PreProductionBoardDelivery::class, 'pre_production_id', 'id')
            ->where('deleted', PreProductionBoardDelivery::DELETED_NO)
            ->where('status', PreProductionBoardDelivery::STATUS_ACTIVE)
            ->where('received_status', '!=', PreProductionBoardDelivery::RECEIVED_STATUS_DELIVERED);
    }

    public function pendingForReceiveCount(){
        return $this->hasMany(PreProductionMaterialDelivery::class, 'pre_production_id', 'id')
            ->where('deleted', PreProductionMaterialDelivery::DELETED_NO)
            ->where('status', PreProductionMaterialDelivery::STATUS_ACTIVE)
            ->where('received_status', '!=', PreProductionMaterialDelivery::RECEIVED_STATUS_DELIVERED)
            ->count();
    }

    public function pendingForReceiveBoardCount(){
        return $this->hasMany(PreProductionBoardDelivery::class, 'pre_production_id', 'id')
            ->where('deleted', PreProductionBoardDelivery::DELETED_NO)
            ->where('status', PreProductionBoardDelivery::STATUS_ACTIVE)
            ->where('received_status', '!=', PreProductionBoardDelivery::RECEIVED_STATUS_DELIVERED)
            ->count();
    }

    public function productionMachines() {
        return $this->hasMany(PreProductionProcessMachine::class, 'pre_production_id', 'id');
    }

    public function countRawMaterials(){
        $materialCount = $this->production_material()->count();
        $boardCount = $this->board_material()->count();
        return $materialCount + $boardCount;
    }

    public function invoice() {
        return $this->belongsTo(\App\Models\Sales\Invoice::class, 'invoice_id', 'id');
    }

    public function showStatus($type = 'default')
    {
        if($type == 'process') {
            if ($this->process_status == self::PROCESS_STATUS_PROCESSING) {
                return "On Process";
            }
        }
        if ($this->delivery_status == self::DELIVERY_STATUS_PENDING) {
            return "Waiting for Items";
        }
        if ($this->received_status == self::RECEIVED_STATUS_PENDING) {
            return "Pending Items";
        }
        if($type == 'receive_raw_materials') {
            if (($this->delivery_status != self::DELIVERY_STATUS_DELIVERED) && ($this->received_status != self::RECEIVED_STATUS_PENDING)) {
                return "Partial";
            }
        }
        if ($this->process_status == self::PROCESS_STATUS_PENDING) {
            return "Production Pending";
        }
        if(($this->process_status == self::PROCESS_STATUS_COMPLETED) && ($this->dispatched_status == self::DISPATCH_STATUS_PENDING)) {
            return "Completed";
        }
        if(($this->process_status == self::PROCESS_STATUS_COMPLETED) && ($this->dispatched_status == self::DISPATCH_STATUS_PARTIAL)) {
            return "Partial Dispatched";
        }
        if(($this->process_status == self::PROCESS_STATUS_COMPLETED) && ($this->dispatched_status == self::DISPATCH_STATUS_DISPATCHED)) {
            return "Dispatched";
        }
        if ($this->process_status == self::PROCESS_STATUS_PROCESSING) {
            return "On Process";
        }
        if (($this->delivery_status != self::DELIVERY_STATUS_DELIVERED) && ($this->received_status != self::RECEIVED_STATUS_PENDING)) {
            return "Partial";
        }
        return "N/A";
    }

}
