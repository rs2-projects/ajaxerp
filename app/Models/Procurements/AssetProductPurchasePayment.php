<?php

namespace App\Models\Procurements;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetProductPurchasePayment extends Model
{
    use HasFactory;

    protected $table = 'asset_product_purchase_payments';
    public $timestamps = false;

    const PAYMENT_METHOD_BANK_PAYMENT = 1;
    const PAYMENT_METHOD_CASH = 2;
    const PAYMENT_METHOD_CHEQUE = 3;
    const PAYMENT_METHOD_CREDIT_CARD = 4;
    const PAYMENT_METHOD_PAYPAL = 5;
    const PAYMENT_METHOD_OTHERS = 6;

    const PAYMENT_METHODS = [
        self::PAYMENT_METHOD_CASH => 'Cash',
        self::PAYMENT_METHOD_BANK_PAYMENT => 'Bank Payment',
        self::PAYMENT_METHOD_CHEQUE => 'Cheque',
        self::PAYMENT_METHOD_CREDIT_CARD => 'Credit Card',
        self::PAYMENT_METHOD_PAYPAL => 'Paypal',
        self::PAYMENT_METHOD_OTHERS => 'Others',
    ];

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
    const STATUSES = [
        self::STATUS_ACTIVE => 'Active',
        self::STATUS_INACTIVE => 'Inactive',
    ];

    const DELETE_YES = 1;
    const DELETE_NO = 0;
    const DELETES = [
        self::DELETE_YES => 'Yes',
        self::DELETE_NO => 'No',
    ];

    protected $fillable = [
        'asset_product_purchase_order_id',
        'transaction_id',
        'account_id',
        'payment_method',
        'amount',
        'payment_date',
        'note',
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
