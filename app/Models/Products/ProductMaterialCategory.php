<?php

namespace App\Models\Products;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductMaterialCategory extends BaseModel
{
    use HasFactory;
    protected $table = 'product_material_categories';
    public $timestamps = false;

    const TYPE_OTHERS = 0;
    const TYPE_BOARD = 1;
    const TYPE_PAPER = 2;
    const TYPES = [
        self::TYPE_BOARD => 'Board',
        self::TYPE_OTHERS => 'Others',
        self::TYPE_PAPER => 'Paper'
    ];

    const CALCULATOR_TYPE_OTHERS = 0;
    const CALCULATOR_TYPE_BOARDS = 1;
    const CALCULATOR_TYPES = [
        self::CALCULATOR_TYPE_OTHERS => 'Others',
        self::CALCULATOR_TYPE_BOARDS => 'Board, Paper, Vinyl, Glue',
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
        'calculator_type',
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

    public function products()
    {
        return $this->hasMany(ProductMaterial::class, 'product_material_category_id', 'id');
    }
}
