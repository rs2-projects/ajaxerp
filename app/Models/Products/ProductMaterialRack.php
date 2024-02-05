<?php

namespace App\Models\Products;

use App\Models\Inventory\Warehouse;
use App\Models\Inventory\WarehouseSection;
use App\Models\Inventory\WarehouseSectionRack;
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


    public function warehouseSectionRack()
    {
        return $this->belongsTo(WarehouseSectionRack::class, 'warehouse_section_rack_id', 'id');
    }
}
