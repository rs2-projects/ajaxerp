<?php

namespace App\Models\Production;

use App\Models\BaseModel;
use App\Models\Products\ProductMaterial;
use App\Models\Products\ProductMaterialCategory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BoardPreProductionMaterials extends BaseModel
{
    use HasFactory;

    protected $table = 'board_pre_production_materials';
    public $timestamps = false;

    const TYPE_RAW_BOARD = 0;
    const TYPE_PAPER_UP = 1;
    const TYPE_PAPER_DOWN = 2;

    const TYPES = [
        self::TYPE_RAW_BOARD => 'Raw Board',
        self::TYPE_PAPER_UP => 'Paper Up',
        self::TYPE_PAPER_DOWN => 'Paper Down',
    ];

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
        'type',
        'board_pre_production_id',
        'product_material_category_id',
        'product_material_id',
        'quantity',
        'status',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
        'deleted',
        'deleted_by',
        'deleted_at',
    ];


    public function product_category()
    {
        return $this->belongsTo(ProductMaterialCategory::class, 'product_material_category_id');
    }

    public function product_material()
    {
        return $this->belongsTo(ProductMaterial::class, 'product_material_id');
    }
}
