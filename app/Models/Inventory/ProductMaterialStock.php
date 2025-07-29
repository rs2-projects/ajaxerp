<?php

namespace App\Models\Inventory;

use App\Models\Products\ProductMaterial;
use App\Models\Products\ProductMaterialCategory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductMaterialStock extends Model
{
    use HasFactory;
    protected $table = 'product_material_stocks';
    public $timestamps = false;

    const TYPE_IN = 0;
    const TYPE_OUT = 1;

    const REFERENCE_TYPE_INITIAL_STOCK = 0;
    const REFERENCE_TYPE_PURCHASE = 1;
    const REFERENCE_TYPE_SALES = 2;
    const REFERENCE_TYPE_USE = 3;
    const REFERENCE_TYPE_RETURN = 4;
    const REFERENCE_TYPE_DAMAGE = 5;


    const PRODUCT_MATERIAL_TYPE_OTHERS = 0;
    const PRODUCT_MATERIAL_TYPE_BOARD = 1;
    const PRODUCT_MATERIAL_TYPE_PAPER = 2;
    const PRODUCT_MATERIAL_TYPES = [
        self::PRODUCT_MATERIAL_TYPE_BOARD => 'Board',
        self::PRODUCT_MATERIAL_TYPE_OTHERS => 'Others',
        self::PRODUCT_MATERIAL_TYPE_PAPER => 'Paper'
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
        'date',
        'product_material_category_id',
        'product_material_id',
        'product_material_type',
        'type',
        'reference_type',
        'reference_id',
        'quantity',
        'status',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
        'deleted',
        'deleted_at',
        'deleted_by'
    ];

    public function productMaterialCategory()
    {
        return $this->belongsTo(ProductMaterialCategory::class, 'product_material_category_id')
            ->where('deleted', ProductMaterialCategory::DELETED_NO)
            ->where('status', ProductMaterialCategory::STATUS_ACTIVE);
    }

    public function productMaterial()
    {
        return $this->belongsTo(ProductMaterial::class, 'product_material_id')
            ->where('deleted', ProductMaterial::DELETED_NO)
            ->where('status', ProductMaterial::STATUS_ACTIVE);
    }
}
