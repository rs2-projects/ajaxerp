<?php

namespace App\Models\Accounting;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class AccCoaAccount extends BaseModel
{
    use HasFactory;

    protected $table = 'acc_coa_accounts';
    public $timestamps = false;

    const CAN_EDIT_NO = 0;
    const CAN_EDIT_YES = 1;
    const CAN_EDITS = [
        self::CAN_EDIT_NO => 'No',
        self::CAN_EDIT_YES => 'Yes',
    ];

    const IS_DEFAULT_NO = 0;
    const IS_DEFAULT_YES = 1;
    const IS_DEFAULTS = [
        self::IS_DEFAULT_NO => 'No',
        self::IS_DEFAULT_YES => 'Yes',
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
        'acc_coa_sub_category_id',
        'name',
        'slug',
        'account_no',
        'description',
        'tax_rate',
        'opening_balance',
        'available_balance',
        'can_edit',
        'is_default',
        'status',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
        'deleted',
        'deleted_at',
        'deleted_by'
    ];

    public function category():\Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(AccCoaCategory::class, 'acc_coa_category_id', 'id');
    }

    public function subCategory():\Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(AccCoaSubCategory::class, 'acc_coa_sub_category_id', 'id');
    }

}
