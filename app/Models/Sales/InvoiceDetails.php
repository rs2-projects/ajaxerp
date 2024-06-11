<?php

namespace App\Models\Sales;

use App\Models\Accounting\AccCoaAccount;
use App\Models\Products\FinishedGoods;
use App\Models\Products\ProductMaterial;
use App\Models\Products\ProductMaterialSet;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceDetails extends Model
{
    use HasFactory;
    protected $table = 'invoice_details';
    public $timestamps = false;

    CONST TYPE_RAW_MATERIAL = 0;
    CONST TYPE_RAW_BOARD = 1;
    CONST TYPE_PAPER = 2;
    CONST TYPE_FINISHED_GOODS = 3;
    CONST TYPE_FINISHED_BOARD = 4;
    CONST TYPE_SET_ITEM = 5;

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
    
    //Dispatched Status
    const DISPATCHED_NO = 0;
    const DISPATCHED_YES = 1;
    const DISPATCHED_PARTIALLY = 2;

    Const DISPATCHED_STATUSES = [
        self::DISPATCHED_NO => 'No',
        self::DISPATCHED_YES => 'Dispatched',
        self::DISPATCHED_PARTIALLY => 'Partially',
    ];

    protected $fillable = [
        'invoice_id',
        'item_id',
        'item_type',
        'description',
        'quantity',
        'unit_price',
        'total',
        'tax_id',
        'tax_rate',
        'tax_amount',
        'net_total',
        'dispatched',
        'dispatched_qty',
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

    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'invoice_id', 'id');
    }

    public function tax()
    {
        return $this->belongsTo(AccCoaAccount::class, 'tax_id', 'id');
    }

}
