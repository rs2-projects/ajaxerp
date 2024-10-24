<?php

namespace App\Models\Sales;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Quotation extends BaseModel
{
    use HasFactory;

    protected $table = 'quotations';
    public $timestamps = false;

    //status const
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUSES = [
        self::STATUS_INACTIVE => 'Inactive',
        self::STATUS_ACTIVE => 'Active',
    ];
    //Discount type const
    const DISCOUNT_TYPE_PERCENTAGE = 0;
    const DISCOUNT_TYPE_FIXED_AMOUNT = 1;
    const DISCOUNT_TYPES = [
        self::DISCOUNT_TYPE_PERCENTAGE => 'Percentage',
        self::DISCOUNT_TYPE_FIXED_AMOUNT => 'Fixed Amount',
    ];

    //QUOTATION status const
    const QUOTATION_STATUS_PENDING = 0;
    const QUOTATION_STATUS_PROCESSING = 1;
    const QUOTATION_STATUS_CANCELLED = 2;
    const QUOTATION_STATUS_ORDER_CREATED = 3;
    const QUOTATION_STATUSES = [
        self::QUOTATION_STATUS_PENDING => 'Pending',
        self::QUOTATION_STATUS_PROCESSING => 'Processing',
        self::QUOTATION_STATUS_CANCELLED => 'Cancelled',
        self::QUOTATION_STATUS_ORDER_CREATED => 'Cancelled',
    ];
    //Delete status const
    const DELETED_NO = 0;
    const DELETED_YES = 1;
    const DELETEDS = [
        self::DELETED_NO => 'No',
        self::DELETED_YES => 'Yes',
    ];

    protected $fillable = [
        'quotation_no',
        'customer_id',
        'ref_no',
        'quotation_date',
        'project_name',
        'description',
        'subtotal_amount',
        'vat_amount',
        'total_amount',
        'discount_type',
        'discount_value',
        'discount_amount',
        'unloading_cost',
        'first_down_payment_percent',
        'payable_amount',
        'quotation_status',
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

    //relation with quotation details
    public function details(){
        return $this->hasMany(QuotationDetails::class, 'quotation_id', 'id')->where('deleted', QuotationDetails::DELETED_NO);
    }
}
