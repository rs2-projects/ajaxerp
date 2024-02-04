<?php

namespace App\Models\Products;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductMaterialRack extends Model
{
    use HasFactory;
    protected $table = 'product_material_racks';
    public $timestamps = false;

    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUSES = [
        self::STATUS_INACTIVE => 'Inactive',
        self::STATUS_ACTIVE => 'Active',
    ];

    protected $fillable = [
        'warehouse_id',
        'product_material_id',
        'warehouse_section_id',
        'warehouse_section_rack_id',
        'status',
    ];
}
