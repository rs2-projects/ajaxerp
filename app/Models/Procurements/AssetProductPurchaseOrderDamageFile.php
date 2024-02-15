<?php

namespace App\Models\Procurements;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetProductPurchaseOrderDamageFile extends Model
{
    use HasFactory;

    protected $table = 'asset_product_purchase_order_damage_files';
    public $timestamps = false;

    const FILE_TYPE_DAMAGE = 0;
    const FILE_TYPE_MISSING = 1;
    const FILE_TYPES = [
        self::FILE_TYPE_DAMAGE => 'Damage',
        self::FILE_TYPE_MISSING => 'Missing',
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
        'asset_product_purchase_order_id',
        'asset_product_purchase_order_detail_id',
        'file_type',
        'file_path',
        'status',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
        'deleted',
        'deleted_by',
        'deleted_at',

    ];
}
