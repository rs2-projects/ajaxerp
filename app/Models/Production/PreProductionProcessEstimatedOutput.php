<?php

namespace App\Models\Production;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreProductionProcessEstimatedOutput extends Model
{
    use HasFactory;

    protected $table = 'pre_production_process_estimated_outputs';
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
        'pre_production_id',
        'pre_production_process_id',
        'unit',
        'quantity',
        'verified_qty',
        'name',
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
