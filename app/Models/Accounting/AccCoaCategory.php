<?php

namespace App\Models\Accounting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccCoaCategory extends Model
{
    use HasFactory;

    protected $table = 'acc_coa_categories';
    public $timestamps = false;


    const TYPE_ASSETS = 0;
    const TYPE_LIABILITIES_CREDIT_CARDS = 1;
    const TYPE_INCOME = 2;
    const TYPE_EXPENSES = 3;
    const TYPE_EQUITY = 4;
    const TYPES = [
        self::TYPE_ASSETS => 'Assets',
        self::TYPE_LIABILITIES_CREDIT_CARDS => 'Liabilities & Credit Cards',
        self::TYPE_INCOME => 'Income',
        self::TYPE_EXPENSES => 'Expenses',
        self::TYPE_EQUITY => 'Equity',
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
        'name',
        'type',
        'description',
        'status',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
        'deleted',
        'deleted_at',
        'deleted_by'
    ];

    public function subcategories():\Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(AccCoaSubCategory::class, 'acc_coa_category_id', 'id');
    }
}
