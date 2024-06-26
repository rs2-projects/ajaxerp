<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeletedHistory extends Model
{
    use HasFactory;

    protected $table = 'deleted_histories';

    protected $fillable = [
        'table_name',
        'reference_id',
        'created_at',
        'updated_at',
        'synced',
    ];
}
