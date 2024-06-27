<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UpdatedTable extends Model
{
    use HasFactory;

    protected $table = 'updated_tables';
    protected $fillable = [
        'table_name',
        'created_at',
        'updated_at'
    ];


}
