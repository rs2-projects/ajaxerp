<?php

namespace App\Models\Products;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinishedGoodsCategory extends Model
{
    use HasFactory;
    protected $table = 'finished_goods_categories';
    public $timestamps = false;

    const TYPE_OTHERS = 0;
    const TYPE_BOARD = 1;
    const TYPES = [
        self::TYPE_BOARD => 'Board',
        self::TYPE_OTHERS => 'Others'
    ];

    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUSES = [
        self::STATUS_INACTIVE => 'Inactive',
        self::STATUS_ACTIVE => 'Active',
    ];
    // 0 => 'No', 1 => 'Yes'
    const DELETED_NO = 0;
    const DELETED_YES = 1;
    const DELETEDS = [
        self::DELETED_NO => 'No',
        self::DELETED_YES => 'Yes',
    ];

    protected $fillable = [
        'type',
        'name',
        'description',
        'status',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
        'deleted',
        'deleted_by',
        'deleted_at',
    ];
}
