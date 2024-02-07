<?php

namespace App\Models\Procurements;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductMaterialPurchaseDetails extends Model
{
    use HasFactory;

    protected $table = 'product_material_purchase_details';
    public $timestamps = false;

    const IS_PERFECT_NO = 0;
    const IS_PERFECT_YES = 1;
    const IS_PERFECTS = [
        self::IS_PERFECT_NO => 'No',
        self::IS_PERFECT_YES => 'Yes',
    ];

    const HAS_DAMAGE_NO = 0;
    const HAS_DAMAGE_YES = 1;
    const HAS_DAMAGES = [
        self::HAS_DAMAGE_NO => 'No',
        self::HAS_DAMAGE_YES => 'Yes',
    ];

    const HAS_MISSING_NO = 0;
    const HAS_MISSING_YES = 1;
    const HAS_MISSINGS = [
        self::HAS_MISSING_NO => 'No',
        self::HAS_MISSING_YES => 'Yes',
    ];

    protected $fillable = [
        'product_material_purchase_id',
        'product_material_id',
        'description',
        'color',
        'qty',
        'unit_price',
        'total_price',
        'tax_id',
        'tax_rate',
        'tax_amount',
        'net_total',
        'is_perfect',
        'has_damage',
        'damage_qty',
        'damage_remarks',
        'has_missing',
        'missing_qty',
        'missing_remarks',
        'status',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
        'deleted',
        'deleted_by',
        'deleted_at',
    ];

}
