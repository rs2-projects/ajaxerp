<?php

namespace App\Models\Products;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetProductAssign extends Model
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
}
