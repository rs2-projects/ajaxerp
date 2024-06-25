<?php

namespace App\Models\Accounting;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionVat extends BaseModel
{
    use HasFactory;

    protected $table = 'transaction_vats';

    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUSES = [
        self::STATUS_INACTIVE => 'Inactive',
        self::STATUS_ACTIVE => 'Active',
    ];

    protected $fillable = [
        'transaction_id',
        'tax_id',
        'main_amount',
        'vat_percent',
        'vat_amount',
        'status',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by',
        'deleted',
        'deleted_at',
        'deleted_by'
    ];
}
