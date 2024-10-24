<?php

namespace App\Models\Sales;

use App\Models\Accounting\AccCoaAccount;
use App\Models\BaseModel;
use App\Models\Products\FinishedGoods;
use App\Models\Products\ProductMaterial;
use App\Models\Products\ProductMaterialSet;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class QuotationDetails extends BaseModel
{
    use HasFactory;
    protected $table = 'quotation_details';
    public $timestamps = false;

    CONST TYPE_RAW_MATERIAL = 0;
    CONST TYPE_RAW_BOARD = 1;
    CONST TYPE_PAPER = 2;
    CONST TYPE_FINISHED_GOODS = 3;
    CONST TYPE_FINISHED_BOARD = 4;
    CONST TYPE_SET_ITEM = 5;
    CONST TYPE_CUSTOM_ITEM = 6;

    //Delete status const
    const DELETED_NO = 0;
    const DELETED_YES = 1;
    const DELETEDS = [
        self::DELETED_NO => 'No',
        self::DELETED_YES => 'Yes',
    ];

    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUSES = [
        self::STATUS_INACTIVE => 'Inactive',
        self::STATUS_ACTIVE => 'Active',
    ];

    protected $fillable = [
        'quotation_id',
        'item_type',
        'item_id',
        'item_name',
        'description',
        'quantity',
        'unit_price',
        'total',
        'tax_id',
        'tax_rate',
        'tax_amount',
        'net_total',
        'status',
        'deleted',
        'deleted_at',
        'deleted_by',
        'created_at',
        'updated_at',
        'created_by',
        'updated_by',

    ];

    public function finishedGood()
    {
        return $this->belongsTo(FinishedGoods::class, 'item_id', 'id');
    }

    public function product_material()
    {
        return $this->belongsTo(ProductMaterial::class, 'item_id', 'id');
    }

    public function set_item()
    {
        return $this->belongsTo(ProductMaterialSet::class, 'item_id', 'id');
    }

    public function quotation()
    {
        return $this->belongsTo(Quotation::class, 'quotation_id', 'id');
    }

    public function tax()
    {
        return $this->belongsTo(AccCoaAccount::class, 'tax_id', 'id');
    }
}
