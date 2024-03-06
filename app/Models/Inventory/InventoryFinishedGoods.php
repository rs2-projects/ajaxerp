<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryFinishedGoods extends Model
{
    use HasFactory;

    protected $table = 'inventory_finished_goods';
    public $timestamps = false;

    const TYPE_IN = 0;
    const TYPE_OUT = 1;
    const TYPES = [
        self::TYPE_IN => 'In',
        self::TYPE_OUT => 'Out',
    ];

    const REFERENCE_TYPE_FROM_PRODUCTION = 0;
    const REFERENCE_TYPE_FROM_SALE = 1;
    const REFERENCE_TYPES = [
        self::REFERENCE_TYPE_FROM_PRODUCTION => 'From Production',
        self::REFERENCE_TYPE_FROM_SALE => 'From Sale',
    ];

    protected $fillable = [
        'finished_goods_category_id',
        'finished_goods_id',
        'type',
        'reference_type',
        'reference_id',
        'quantity',
    ];

}
