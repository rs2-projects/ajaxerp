<?php

namespace App\Models\Inventory;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InventoryProductMaterial extends BaseModel
{
    use HasFactory;

    protected $table = 'inventory_product_materials';
    public $timestamps = false;

    const TYPE_IN = 0;
    const TYPE_OUT = 1;
    const TYPES = [
        self::TYPE_IN => 'In',
        self::TYPE_OUT => 'Out',
    ];

    const REFERENCE_TYPE_PRODUCT_MATERIAL_PURCHASE = 0;
    const REFERENCE_TYPE_PRODUCT_MATERIAL_USE = 1;

    const REFERENCE_TYPES = [
        self::REFERENCE_TYPE_PRODUCT_MATERIAL_PURCHASE => 'Product Material Purchase',
        self::REFERENCE_TYPE_PRODUCT_MATERIAL_USE => 'Product Material Use',
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
        'product_material_category_id',
        'product_material_id',
        'type',
        'reference_type',
        'reference_id',
        'quantity',
        'status',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by',
        'deleted',
        'deleted_at',
        'deleted_by',
    ];
}
