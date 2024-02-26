<?php

namespace App\Models\Production;

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
}
