<?php

namespace App\Models\Accounting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionReceipt extends Model
{
    use HasFactory;
    protected $table = 'transaction_receipts';

    public $timestamps = false;

    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUSES = [
        self::STATUS_INACTIVE => 'Inactive',
        self::STATUS_ACTIVE => 'Active',
    ];

    protected $fillable = [
        'transaction_id',
        'receipt',
        'status',
    ];
}
