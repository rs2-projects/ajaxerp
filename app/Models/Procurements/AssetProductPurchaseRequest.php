<?php

namespace App\Models\Procurements;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AssetProductPurchaseRequest extends BaseModel
{
    use HasFactory;

    protected $table = 'asset_product_purchase_requests';
    public $timestamps = false;

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

    const REQUEST_STATUS_NEW = 0;
    const REQUEST_STATUS_APPROVED = 1;
    const REQUEST_STATUS_DECLINED = 2;
    const REQUEST_STATUS_ADDITIONAL_INFO = 3;
    const REQUEST_STATUS_INFO_SUBMITTED = 4;
    const REQUEST_STATUSES = [
        self::REQUEST_STATUS_NEW => 'New',
        self::REQUEST_STATUS_APPROVED => 'Approved',
        self::REQUEST_STATUS_DECLINED => 'Declined',
        self::REQUEST_STATUS_ADDITIONAL_INFO => 'Pending',
        self::REQUEST_STATUS_INFO_SUBMITTED => 'Info Submitted',
    ];

    protected $fillable = [
        'title',
        'description',
        'requested_by',
        'request_status',
        'additional_info',
        'status',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
        'deleted',
        'deleted_by',
        'deleted_at',
    ];

    public function purchase_request_details()
    {
        return $this->hasMany(AssetProductPurchaseRequestDetails::class, 'asset_product_purchase_request_id', 'id');
    }
}
