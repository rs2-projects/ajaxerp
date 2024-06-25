<?php

namespace App\Models\Accounting;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AccCoaSubCategory extends BaseModel
{
    use HasFactory;

    protected $table = 'acc_coa_sub_categories';
    public $timestamps = false;


    const IS_ACCOUNT_TYPE_NO = 0;
    const IS_ACCOUNT_TYPE_YES = 1;
    const IS_ACCOUNT_TYPES = [
        self::IS_ACCOUNT_TYPE_NO => 'No',
        self::IS_ACCOUNT_TYPE_YES => 'Yes',
    ];

    const CAN_CREATE_ACCOUNT_NO = 0;
    const CAN_CREATE_ACCOUNT_YES = 1;
    const CAN_CREATE_ACCOUNTS = [
        self::CAN_CREATE_ACCOUNT_NO => 'Can\'t Create',
        self::CAN_CREATE_ACCOUNT_YES => 'Can Create',
    ];

    const IS_SALES_TAX_NO = 0;
    const IS_SALES_TAX_YES = 1;
    const IS_SALES_TAXES = [
        self::IS_SALES_TAX_NO => 'No',
        self::IS_SALES_TAX_YES => 'Yes',
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
        'acc_coa_category_id',
        'name',
        'slug',
        'description',
        'is_account_type',
        'can_create_account',
        'is_sales_tax',
        'status',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
        'deleted',
    ];

    public function accounts():\Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(AccCoaAccount::class, 'acc_coa_sub_category_id', 'id');
    }

    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(AccCoaCategory::class, 'acc_coa_category_id', 'id');
    }
}
