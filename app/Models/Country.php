<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;
    protected $table = 'countries';
    public $timestamps = false;
    protected $fillable = [
        'name',
        'phone_code',
        'currency_name',
        'currency',
        'currency_symbol',
        'iso2',
        'status'
    ];
}
