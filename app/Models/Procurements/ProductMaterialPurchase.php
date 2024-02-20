<?php

namespace App\Models\Procurements;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductMaterialPurchase extends Model
{
    use HasFactory;

    protected $table = 'product_material_purchases';
    public $timestamps = false;

    const PURCHASE_CREATE_TYPE_NEW = 0;
    const PURCHASE_CREATE_TYPE_REVISED = 1;
    const PURCHASE_CREATE_TYPE_BACKED = 2;
    const PURCHASE_CREATE_TYPES = [
        self::PURCHASE_CREATE_TYPE_NEW => 'New',
        self::PURCHASE_CREATE_TYPE_REVISED => 'Revised',
        self::PURCHASE_CREATE_TYPE_BACKED => 'Backed',
    ];

    const PAYMENT_STATUS_UNPAID = 0;
    const PAYMENT_STATUS_PARTIAL_PAID = 1;
    const PAYMENT_STATUS_PAID = 2;
    const PAYMENT_STATUSES = [
        self::PAYMENT_STATUS_UNPAID => 'Unpaid',
        self::PAYMENT_STATUS_PARTIAL_PAID => 'Partial',
        self::PAYMENT_STATUS_PAID => 'Paid',
    ];

    const PURCHASE_STATUS_NEW = 0;
    const PURCHASE_STATUS_ON_PROCESS = 1;
    const PURCHASE_STATUS_DELIVERED = 2;
    const PURCHASE_STATUS_REVISED_OR_BACKED = 3;
    const PURCHASE_STATUSES = [
        self::PURCHASE_STATUS_NEW => 'New',
        self::PURCHASE_STATUS_ON_PROCESS => 'On Process',
        self::PURCHASE_STATUS_DELIVERED => 'Delivered',
        self::PURCHASE_STATUS_REVISED_OR_BACKED => 'Revised or Backed',
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

    const IS_REVISED_NO = 0;
    const IS_REVISED_YES = 1;
    const IS_REVISEDS = [
        self::IS_REVISED_NO => 'No',
        self::IS_REVISED_YES => 'Yes',
    ];

    const IS_BACKED_NO = 0;
    const IS_BACKED_YES = 1;
    const IS_BACKEDS = [
        self::IS_BACKED_NO => 'No',
        self::IS_BACKED_YES => 'Yes',
    ];

    const DISCOUNT_TYPE_PERCENTAGE = 0;
    const DISCOUNT_TYPE_FIXED_AMOUNT = 1;
    const DISCOUNT_TYPES = [
        self::DISCOUNT_TYPE_PERCENTAGE => 'Percentage',
        self::DISCOUNT_TYPE_FIXED_AMOUNT => 'Fixed Amount',
    ];

    const PRICE_CALCULATED_NO =0;
    const PRICE_CALCULATED_YES =1;

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
        'purchase_create_type',
        'purchase_create_prev_id',
        'supplier_id',
        'purchase_id',
        'batch_number',
        'purchase_date',
        'estimated_delivery_date',
        'subtotal_amount',
        'total_vat_amount',
        'discount_type',
        'discount_value',
        'total_discount_amount',
        'payable_amount',
        'paid_amount',
        'due_amount',
        'payment_status',
        'purchase_status',
        'has_damage',
        'has_missing',
        'is_revised',
        'revised_by',
        'revised_at',
        'is_backed',
        'backed_by',
        'backed_at',
        'notes',
        'invoice_footer',
        'status',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
        'deleted',
        'deleted_by',
        'deleted_at',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id');
    }

    public function purchaseDetails()
    {
        return $this->hasMany(ProductMaterialPurchaseDetails::class, 'product_material_purchase_id', 'id')->where('deleted', ProductMaterialPurchaseDetails::DELETED_NO);
    }
}
