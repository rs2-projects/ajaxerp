<?php

namespace App\Models\Products;

use App\Models\Inventory\Warehouse;
use App\Models\Inventory\WarehouseSection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductMaterialSection extends Model
{
    use HasFactory;
    protected $table = 'product_material_sections';
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
        'status',
    ];

    public function warehouseSection()
    {
        return $this->belongsTo(WarehouseSection::class, 'warehouse_section_id', 'id');
    }

    public function productMaterialRacks(){
        return $this->hasMany(ProductMaterialRack::class, 'warehouse_section_id', 'id');
    }
}
