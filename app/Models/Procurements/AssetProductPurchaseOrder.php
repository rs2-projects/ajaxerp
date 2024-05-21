<?php

namespace App\Models\Procurements;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetProductPurchaseOrder extends Model
{
    use HasFactory;

    protected $table = 'asset_product_purchase_orders';
    public $timestamps = false;

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
    const PURCHASE_STATUS_CANCELLED = 3;
    const PURCHASE_STATUSES = [
        self::PURCHASE_STATUS_NEW => 'New',
        self::PURCHASE_STATUS_ON_PROCESS => 'On Process',
        self::PURCHASE_STATUS_DELIVERED => 'Delivered',
        self::PURCHASE_STATUS_CANCELLED => 'Canceled',
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

    const DISCOUNT_TYPE_PERCENTAGE = 0;
    const DISCOUNT_TYPE_FIXED_AMOUNT = 1;
    const DISCOUNT_TYPES = [
        self::DISCOUNT_TYPE_PERCENTAGE => 'Percentage',
        self::DISCOUNT_TYPE_FIXED_AMOUNT => 'Fixed Amount',
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
        'asset_product_purchase_request_id',
        'supplier_id',
        'purchase_order_id',
        'batch_number',
        'purchase_date',
        'estimated_delivery_date',
        'subtotal_amount',
        'php_rate',
        'subtotal_amount_php',
        'total_vat_amount_php',
        'total_discount_amount_php',
        'payable_amount_php',
        'paid_amount_php',
        'due_amount_php',
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
        return $this->hasMany(AssetProductPurchaseOrderDetails::class, 'asset_product_purchase_order_id', 'id')->where('deleted', AssetProductPurchaseOrderDetails::DELETED_NO);
    }
}
