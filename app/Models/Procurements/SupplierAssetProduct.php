<?php

namespace App\Models\Procurements;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierAssetProduct extends Model
{
    use HasFactory;

    protected $table = 'supplier_asset_products';
    public $timestamps = false;

    protected $fillable = [
        'supplier_id',
        'asset_product_id'
    ];
}
