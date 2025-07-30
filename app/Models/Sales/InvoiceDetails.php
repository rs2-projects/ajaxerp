<?php

namespace App\Models\Sales;

use App\Models\Accounting\AccCoaAccount;
use App\Models\BaseModel;
use App\Models\Products\FinishedGoods;
use App\Models\Products\ProductMaterial;
use App\Models\Products\ProductMaterialSet;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InvoiceDetails extends BaseModel
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
        return $this->belongsTo(FinishedGoods::class, 'item_id', 'id')
            // ->where('item_type', self::TYPE_FINISHED_GOODS)
            ->where('type', FinishedGoods::TYPE_OTHERS)
            ->where('deleted', FinishedGoods::DELETED_NO)
            ->where('status', FinishedGoods::STATUS_ACTIVE);
    }

    public function finishedBoard()
    {
        return $this->belongsTo(FinishedGoods::class, 'item_id', 'id')
            // ->where('item_type', self::TYPE_FINISHED_BOARD)
            ->where('type', FinishedGoods::TYPE_BOARD)
            ->where('deleted', FinishedGoods::DELETED_NO)
            ->where('status', FinishedGoods::STATUS_ACTIVE);
    }

    public function product_material()
    {
        return $this->belongsTo(ProductMaterial::class, 'item_id', 'id')
            // ->whereIn('item_type', [self::TYPE_RAW_MATERIAL, self::TYPE_RAW_BOARD, self::TYPE_PAPER])
            ->where('deleted', ProductMaterial::DELETED_NO)
            ->where('status', ProductMaterial::STATUS_ACTIVE);
    }

    public function set_item()
    {
        return $this->belongsTo(ProductMaterialSet::class, 'item_id', 'id')
            // ->where('item_type', self::TYPE_SET_ITEM)
            ->where('deleted', ProductMaterialSet::DELETED_NO)
            ->where('status', ProductMaterialSet::STATUS_ACTIVE);
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'invoice_id', 'id');
    }

    public function tax()
    {
        return $this->belongsTo(AccCoaAccount::class, 'tax_id', 'id');
    }


    public function getItem()
    {
        switch ($this->item_type) {
            case self::TYPE_RAW_MATERIAL:
            case self::TYPE_RAW_BOARD:
            case self::TYPE_PAPER:
                return $this->product_material;

            case self::TYPE_FINISHED_GOODS:
                return $this->finishedGood;

            case self::TYPE_FINISHED_BOARD:
                return $this->finishedBoard;

            case self::TYPE_SET_ITEM:
                return $this->set_item;

            default:
                return null;
        }
    }


    public function itemName()
    {
        return $this->getItem()->name ?? '';
    }

    public function itemCode()
    {
        return $this->getItem()->code ?? '';
    }

    public function itemAvailableQty()
    {
        return $this->getItem()->available_qty ?? 0;
    }


}
