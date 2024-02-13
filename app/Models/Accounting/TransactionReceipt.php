<?php

namespace App\Models\Accounting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionReceipt extends Model
{
    use HasFactory;
    protected $table = 'transaction_receipts';

    protected $fillable = [
        'transaction_id',
        'receipt',
        'status',
    ];
}
