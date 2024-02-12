<?php

namespace App\Models\Procurements;

use App\Models\Accounting\AccCoaAccount;
use App\Models\Products\ProductMaterial;
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

    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUSES = [
        self::STATUS_INACTIVE => 'Inactive',
        self::STATUS_ACTIVE => 'Active',
    ];

    const DELETED_NO = 0;
    const DELETED_YES = 1;
    const DELETEDS = [
        self::DELETED_NO => 'No',
        self::DELETED_YES => 'Yes',
    ];

    protected $fillable = [
        'product_material_purchase_id',
        'product_material_id',
        'description',
        'color',
        'qty',
        'used_qty',
        'available_qty',
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

    public function productMaterial()
    {
        return $this->belongsTo(ProductMaterial::class, 'product_material_id', 'id');
    }

    public function materialPurchase()
    {
        return $this->belongsTo(ProductMaterialPurchase::class, 'product_material_purchase_id', 'id');
    }

    public function tax()
    {
        return $this->belongsTo(AccCoaAccount::class, 'tax_id', 'id');
    }

}
