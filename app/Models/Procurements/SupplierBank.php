<?php

namespace App\Models\Procurements;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SupplierBank extends BaseModel
{
    use HasFactory;

    protected $table = 'supplier_banks';
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
        'supplier_id',
        'bank_name',
        'account_name',
        'account_no',
        'branch',
        'routing_number',
        'swift_code',
        'notes',
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
