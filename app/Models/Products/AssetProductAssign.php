<?php

namespace App\Models\Products;

use App\Models\BaseModel;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AssetProductAssign extends BaseModel
{
    use HasFactory;

    protected $table = 'asset_product_assigns';
    public $timestamps = false;

    const ASSIGN_STATUS_ASSIGNED = 1;
    const ASSIGN_STATUS_MAINTENANCE = 2;
    const ASSIGN_STATUS_SOLD = 3;
    const ASSIGN_STATUS_DISPOSED = 4;
    const ASSIGN_STATUS_REPAIRED = 5;
    const ASSIGN_STATUS_RETURNED = 6;

    const RETURN_TYPE_LEAVE = 1;
    const RETURN_TYPE_TERMINATION = 2;
    const RETURN_TYPE_REPLACE = 3;
    const RETURN_TYPE_RESIGNATION = 4;
    const RETURN_TYPE_FOR_MAINTENANCE = 5;

    const RETURN_TYPES = [
        self::RETURN_TYPE_REPLACE => 'Replace',
        self::RETURN_TYPE_LEAVE => 'Leave',
        self::RETURN_TYPE_TERMINATION => 'Termination',
        self::RETURN_TYPE_RESIGNATION => 'Resignation',
        self::RETURN_TYPE_FOR_MAINTENANCE => 'For Maintenance',
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
        'date',
        'sl_no',
        'model',
        'asset_product_id',
        'qty',
        'unit_price',
        'employee_id',
        'assign_status',
        'reason',
        'remarks',
        'warranty',
        'return_date',
        'return_type',
        'return_reason',
        'repair_date',
        'status',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
        'deleted',
        'deleted_by',
        'deleted_at',
    ];


    public function product()
    {
        return $this->belongsTo(AssetProduct::class, 'asset_product_id', 'id');
    }
    public function attachments()
    {
        return $this->hasMany(AssetProductAssignAttachment::class, 'asset_product_assign_id', 'id');
    }

    public function employee()
    {
        return $this->belongsTo(User::class, 'employee_id', 'id');
    }
}
