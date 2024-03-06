<?php

namespace App\Models\Sales;

use App\Models\Accounting\AccCoaAccount;
use App\Models\Products\FinishedGoods;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceDetails extends Model
{
    use HasFactory;
    protected $table = 'invoice_details';
    public $timestamps = false;

    //Delete status const
    const DELETED_NO = 0;
    const DELETED_YES = 1;
    const DELETEDS = [
        self::DELETED_NO => 'No',
        self::DELETED_YES => 'Yes',
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
        'finished_good_id',
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
        return $this->belongsTo(FinishedGoods::class, 'finished_good_id', 'id');
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
