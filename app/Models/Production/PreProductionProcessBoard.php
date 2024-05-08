<?php

namespace App\Models\Production;

use App\Models\Products\FinishedGoods;
use App\Models\Products\FinishedGoodsCategory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreProductionProcessBoard extends Model
{
    use HasFactory;

    protected $table = 'pre_production_process_boards';
    public $timestamps = false;

    protected $fillable = [
        'pre_production_id',
        'pre_production_process_id',
        'finished_board_category_id',
        'finished_board_id',
        'quantity',
        'base_quantity',
        'extra_quantity'
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
