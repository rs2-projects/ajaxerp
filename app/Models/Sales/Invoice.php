<?php

namespace App\Models\Sales;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    protected $table = 'invoices';
    public $timestamps = false;
    //Discount type const
    const DISCOUNT_TYPE_PERCENTAGE = 0;
    const DISCOUNT_TYPE_FIXED_AMOUNT = 1;
    const DISCOUNT_TYPES = [
        self::DISCOUNT_TYPE_PERCENTAGE => 'Percentage',
        self::DISCOUNT_TYPE_FIXED_AMOUNT => 'Fixed Amount',
    ];

    //Payment status const
    const PAYMENT_STATUS_UNPAID = 0;
    const PAYMENT_STATUS_PARTIAL_PAID = 1;
    const PAYMENT_STATUS_PAID = 2;
    const PAYMENT_STATUSES = [
        self::PAYMENT_STATUS_UNPAID => 'Unpaid',
        self::PAYMENT_STATUS_PARTIAL_PAID => 'Partial',
        self::PAYMENT_STATUS_PAID => 'Paid',
    ];
    //Invoice status const
    const INVOICE_STATUS_PENDING = 0;
    const INVOICE_STATUS_PROCESSING = 1;
    const INVOICE_STATUS_DELIVERED = 2;
    const INVOICE_STATUS_CANCELLED = 3;
    const INVOICE_STATUSES = [
        self::INVOICE_STATUS_PENDING => 'Pending',
        self::INVOICE_STATUS_PROCESSING => 'On Process',
        self::INVOICE_STATUS_DELIVERED => 'Delivered',
        self::INVOICE_STATUS_CANCELLED => 'Cancelled',
    ];
    protected $fillable = [
        'invoice_no',
        'customer_id',
        'order_no',
        'invoice_date',
        'payment_date',
        'subtotal_amount',
        'vat_amount',
        'total_amount',
        'discount_type',
        'discount_value',
        'discount_amount',
        'payable_amount',
        'paid_amount',
        'due_amount',
        'payment_status',
        'invoice_status',
        'processed_by',
        'processed_at',
        'delivered_by',
        'delivered_at',
        'cancelled_by',
        'cancelled_at',
        'notes',
        'invoice_footer',
        'created_by',
        'created_at',
        'deleted',
        'deleted_by',
        'deleted_at',
        'updated_by',
        'updated_at',
    ];
    //customer relation
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }
}
