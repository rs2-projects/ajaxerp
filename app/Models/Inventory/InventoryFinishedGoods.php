<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryFinishedGoods extends Model
{
    use HasFactory;
    protected $table = 'inventory_finished_goods';
    public $timestamps = false;
    protected $fillable = [
        'finished_good_id',
        'finished_goods_category_id',
        'type',
        'reference_type',
        'reference_id',
        'quantity',
    ];
}
