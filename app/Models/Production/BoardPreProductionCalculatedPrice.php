<?php

namespace App\Models\Production;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BoardPreProductionCalculatedPrice extends BaseModel
{
    use HasFactory;

    protected $table = 'board_pre_production_calculated_prices';
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

    protected $fillable = [
        'board_pre_production_id',
        'product_material_id',
        'landed_cost_excluding_vat',
        'machine_cost',
        'paper_up_cost',
        'plate_up_cost',
        'paper_down_cost',
        'plate_down_cost',
        'vat_percent',
        'retail_percent',
        'discount_percent',
        'total_production_cost_excluding_vat',
        'retail_price',
        'price_excluding_vat',
        'vat',
        'discount_wholesale',
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
