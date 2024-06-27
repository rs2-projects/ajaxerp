<?php

namespace App\Models\Production;

use App\Models\BaseModel;
use App\Models\Products\ProductMaterial;
use App\Models\Products\ProductMaterialCategory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PreProductionProcessMaterial extends BaseModel
{
    use HasFactory;

    protected $table = 'pre_production_process_materials';
    public $timestamps = false;

    const TYPE_RAW_BOARD = 0;
    const TYPE_PAPER_UP = 1;
    const TYPE_PAPER_DOWN = 2;
    const TYPE_OTHER = 3;

    protected $fillable = [
        'type',
        'pre_production_id',
        'pre_production_process_id',
        'product_material_category_id',
        'product_material_id',
        'quantity',
        'base_quantity',
        'extra_quantity'
    ];

    public function category()
    {
        return $this->belongsTo(ProductMaterialCategory::class, 'product_material_category_id', 'id');
    }
    public function product()
    {
        return $this->belongsTo(ProductMaterial::class, 'product_material_id', 'id');
    }
}
