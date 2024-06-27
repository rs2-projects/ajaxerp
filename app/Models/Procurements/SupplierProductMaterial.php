<?php

namespace App\Models\Procurements;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SupplierProductMaterial extends BaseModel
{
    use HasFactory;

    protected $table = 'supplier_product_materials';
    public $timestamps = false;

    protected $fillable = [
        'supplier_id',
        'product_material_id'
    ];
}
