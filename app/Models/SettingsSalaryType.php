<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettingsSalaryType extends Model
{
    use HasFactory;

    protected $table = 'settings_salary_types';
    public $timestamps = false;

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
    const STATUSES = [
        self::STATUS_INACTIVE => 'Inactive',
        self::STATUS_ACTIVE => 'Active',
    ];

    const DELETED_NO = 0;
    const DELETED_YES = 1;
    const DELETEDS = [
        self::DELETED_NO => 'No',
        self::DELETED_YES => 'Yes',
    ];

    protected $fillable = [
        'title',
        'description',
        'status',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by',
        'deleted',
        'deleted_at',
        'deleted_by',
    ];

    protected $appends = [
      'status_label',
    ];

    public function getStatusLabelAttribute()
    {
        return self::STATUSES[$this->status];
    }

    public function salaryTypeDetails()
    {
        return $this->hasMany(SettingsSalaryTypeDetails::class, 'settings_salary_type_id', 'id');
    }
}
