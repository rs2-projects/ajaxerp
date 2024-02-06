<?php

namespace App\Models\Procurements;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierProductMaterial extends Model
{
    use HasFactory;

    protected $table = 'supplier_product_materials';
    public $timestamps = false;

    protected $fillable = [
        'supplier_id',
        'product_material_id'
    ];
}
