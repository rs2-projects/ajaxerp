<?php

namespace App\Models\Products;

use App\Models\Inventory\WarehouseSection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinishedGoodsSection extends Model
{
    use HasFactory;
    protected $table = 'finished_goods_sections';
    public $timestamps = false;

    //status constant
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUSES = [
        self::STATUS_INACTIVE => 'Inactive',
        self::STATUS_ACTIVE => 'Active',
    ];

    protected $fillable = [
        'warehouse_id',
        'finished_goods_id',
        'warehouse_section_id',
        'status'
    ];

    public function finishedGoodRacks(){
        return $this->hasMany(FinishedGoodsRack::class, 'finished_goods_section_id', 'id');
    }
    public function warehouseSection()
    {
        return $this->belongsTo(WarehouseSection::class, 'warehouse_section_id', 'id');
    }
}
