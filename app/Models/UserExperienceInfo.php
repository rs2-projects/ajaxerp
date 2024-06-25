<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserExperienceInfo extends BaseModel
{
    use HasFactory;

    protected $table = 'user_experience_infos';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'company_name',
        'designation',
        'start_date',
        'end_date',
        'created_by',
        'updated_by',
        'deleted_by',
        'created_at',
        'updated_at',
        'deleted_at'
    ];
}
