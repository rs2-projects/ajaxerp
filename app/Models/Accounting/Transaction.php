<?php

namespace App\Models\Accounting;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends BaseModel
{
    use HasFactory;
    protected $table = 'transactions';
    public $timestamps = false;

    //TODO: need to check the account id and category id in every transaction add and edit (important)
    const PAID_TYPE_UNPAID = 0;
    const PAID_TYPE_PAID = 1;
    const PAID_TYPES = [
        self::PAID_TYPE_UNPAID => 'Unpaid',
        self::PAID_TYPE_PAID => 'Paid',
    ];

    const TRANSACTION_TYPE_DEPOSIT = 0;
    const TRANSACTION_TYPE_WITHDRAW = 1;
    const TRANSACTION_TYPES = [
        self::TRANSACTION_TYPE_DEPOSIT => 'Deposit',
        self::TRANSACTION_TYPE_WITHDRAW => 'Withdraw',
    ];

    const REFERENCE_TYPE_INCOME = 0;
    const REFERENCE_TYPE_EXPENSE = 1;
    const REFERENCE_TYPE_TRANSFER = 2;
    const REFERENCE_TYPE_ASSET_PRODUCT_PURCHASE = 3;
    const REFERENCE_TYPE_PRODUCT_MATERIAL_PURCHASE = 4;
    const REFERENCE_TYPE_ASSET_PRODUCT_PURCHASE_PAYMENT = 5;
    const REFERENCE_TYPE_PRODUCT_MATERIAL_PURCHASE_PAYMENT = 6;
    const REFERENCE_TYPE_INVOICE_PAYMENT = 7;
    const REFERENCE_TYPE_RETURN_INVOICE_PAYMENT = 8;
    const REFERENCE_TYPE_INVOICE_CREATE = 9;
    const REFERENCE_TYPE_ASSET_PRODUCT_SELL = 10;
    const REFERENCE_TYPES = [
        self::REFERENCE_TYPE_INCOME => 'Income',
        self::REFERENCE_TYPE_EXPENSE => 'Expense',
        self::REFERENCE_TYPE_TRANSFER => 'Transfer',
        self::REFERENCE_TYPE_ASSET_PRODUCT_PURCHASE => 'Asset Product Purchase',
        self::REFERENCE_TYPE_PRODUCT_MATERIAL_PURCHASE => 'Product Material Purchase',
        self::REFERENCE_TYPE_ASSET_PRODUCT_PURCHASE_PAYMENT => 'Asset Product Purchase Payment',
        self::REFERENCE_TYPE_PRODUCT_MATERIAL_PURCHASE_PAYMENT => 'Product Material Purchase Payment',
        self::REFERENCE_TYPE_INVOICE_PAYMENT => 'Invoice Payment',
        self::REFERENCE_TYPE_RETURN_INVOICE_PAYMENT => 'Return Invoice Payment',
        self::REFERENCE_TYPE_INVOICE_CREATE => 'Invoice Create',
        self::REFERENCE_TYPE_ASSET_PRODUCT_SELL => 'Asset Product Sell',
    ];

    const IS_REVIEWED_NO = 0;
    const IS_REVIEWED_YES = 1;
    const IS_REVIEWEDS = [
        self::IS_REVIEWED_NO => 'Not Reviewed',
        self::IS_REVIEWED_YES => 'Reviewed',
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
        'transaction_id',
        'paid_type',
        'transaction_type',
        'transaction_date',
        'account_id',
        'category_id',
        'reference_type',
        'reference_id',
        'reference_description',
        'total_cost_price',
        'net_amount',
        'total_vat_amount',
        'total_amount',
        'description',
        'note',
        'is_reviewed',
        'reviewed_at',
        'reviewed_by',
        'status',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by',
        'deleted',
        'deleted_at',
        'deleted_by',
    ];

    public static function boot(){
        parent::boot();

        static::created(function($model){
            $model->transaction_id = 1000 + $model->id;
            $model->save();
        });
    }

    public function account()
    {
        return $this->belongsTo(AccCoaAccount::class, 'account_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(AccCoaAccount::class, 'category_id', 'id');
    }

}
