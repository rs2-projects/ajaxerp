<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class State extends BaseModel
{
    use HasFactory;
    protected $table = 'states';
    public $timestamps = false;

    protected $fillable = [
        'country_id',
        'name',
        'state_code',
        'status'
    ];
}
