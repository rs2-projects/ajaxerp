<?php

namespace App\Models\Showroom;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Showroom extends BaseModel
{
    use HasFactory;

    protected $table = 'showrooms';
    public $timestamps = false;

    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    const DELETED_NO = 0;
    const DELETED_YES = 1;

    protected $fillable = [
        'name',
        'address',
        'status',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by',
        'deleted',
        'deleted_at',
        'deleted_by',
        'synced'
    ];
}
