<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class UpdatedTable extends BaseModel
{
    use HasFactory;

    protected $table = 'updated_tables';
    protected $fillable = [
        'table_name',
        'created_at',
        'updated_at'
    ];


}
