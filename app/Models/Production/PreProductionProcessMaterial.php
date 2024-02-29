<?php

namespace App\Models\Production;

use App\Models\Products\ProductMaterial;
use App\Models\Products\ProductMaterialCategory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreProductionProcessMaterial extends Model
{
    use HasFactory;

    protected $table = 'pre_production_process_materials';
    public $timestamps = false;

    protected $fillable = [
        'pre_production_id',
        'pre_production_process_id',
        'product_material_category_id',
        'product_material_id',
        'quantity'
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
