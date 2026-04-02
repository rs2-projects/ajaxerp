<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Company extends BaseModel
{
    use HasFactory;

    protected $table = 'companies';
    public $timestamps = false;

    protected $fillable = [
        'company_name',
        'email',
        'phone',
        'address',
        'status',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by',
        'deleted',
        'deleted_at',
        'deleted_by',
        'synced',
    ];
}

