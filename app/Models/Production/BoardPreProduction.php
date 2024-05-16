<?php

namespace App\Models\Production;

use App\Models\Machine;
use App\Models\Products\FinishedGoods;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoardPreProduction extends Model
{
    use HasFactory;

    protected $table = 'board_pre_productions';
    public $timestamps = false;

    // status const
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUSES = [
        self::STATUS_INACTIVE => 'Inactive',
        self::STATUS_ACTIVE => 'Active',
    ];

    // deleted const
    const DELETED_NO = 0;
    const DELETED_YES = 1;
    const DELETEDS = [
        self::DELETED_NO => 'No',
        self::DELETED_YES => 'Yes',
    ];

    protected $fillable = [
        'pre_production_no',
        'finished_goods_id',
        'estimated_quantity',
        'machine_id',
        'staff_id',
        'note',
        'status',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
        'deleted',
        'deleted_by',
        'deleted_at',
    ];

    public function board_materials(){
        return $this->hasMany(BoardPreProductionMaterials::class, 'board_pre_production_id', 'id');
    }

    public function other_board_materials(){
        return $this->hasMany(BoardPreProductionMaterials::class, 'board_pre_production_id', 'id')
            ->where('type', '!=', BoardPreProductionMaterials::TYPE_RAW_BOARD);
    }

    public function finishedGoods()
    {
        return $this->belongsTo(FinishedGoods::class, 'finished_goods_id', 'id');
    }

    public function machine()
    {
        return $this->belongsTo(Machine::class, 'machine_id', 'id');
    }

    public function staff()
    {
        return $this->belongsTo(ProductionStaff::class, 'staff_id', 'id');
    }

    public function raw_board(){
        return $this->hasOne(BoardPreProductionMaterials::class, 'board_pre_production_id', 'id')
            ->where('type', BoardPreProductionMaterials::TYPE_RAW_BOARD);
    }

    public function paper_up(){
        return $this->hasOne(BoardPreProductionMaterials::class, 'board_pre_production_id', 'id')
            ->where('type', BoardPreProductionMaterials::TYPE_PAPER_UP);
    }

    public function paper_down(){
        return $this->hasOne(BoardPreProductionMaterials::class, 'board_pre_production_id', 'id')
            ->where('type', BoardPreProductionMaterials::TYPE_PAPER_DOWN);
    }
    
}
