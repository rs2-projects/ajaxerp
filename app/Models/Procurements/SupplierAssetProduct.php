<?php

namespace App\Models\Procurements;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SupplierAssetProduct extends BaseModel
{
    use HasFactory;

    protected $table = 'supplier_asset_products';
    public $timestamps = false;

    protected $fillable = [
        'supplier_id',
        'asset_product_id'
    ];
}
