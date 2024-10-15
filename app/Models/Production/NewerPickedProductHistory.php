<?php

namespace App\Models\Production;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewerPickedProductHistory extends Model
{
    use HasFactory;

    protected $table = 'newer_picked_product_histories';
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

    const ACTION_STATUS_NOT_VIEWED = 0;
    const ACTION_STATUS_VIEWED = 1;
    const ACTION_STATUS_ACTION_DONE = 2;

    
    protected $fillable = [
        'user_id',
        'product_material_id',
        'product_material_purchase_details_id',
        'pre_production_material_delivery_details_id',
        'picked_at',
        'action_status',
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
