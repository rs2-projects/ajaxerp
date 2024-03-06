<?php

namespace App\Models\Production;

use App\Models\Products\FinishedGoods;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductionDispatch extends Model
{
    use HasFactory;

    protected $table = 'production_dispatches';
    public $timestamps = false;
    
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
        'dispatch_no',
        'pre_production_no',
        'pre_production_id',
        'finished_goods_id',
        'dispatched_qty',
        'received_qty',
        'dispatched_by',
        'dispatched_at',
        'received_by',
        'received_at',
        'status',
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
}
