<?php

namespace App\Models\Sales;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceDetails extends Model
{
    use HasFactory;
    protected $table = 'invoice_details';
    public $timestamps = false;
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
        'deleted',
        'deleted_at',
        'deleted_by',
        'created_at',
        'updated_at',
        'created_by',
        'updated_by',

    ];

}
