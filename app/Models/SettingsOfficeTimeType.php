<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class SettingsOfficeTimeType extends BaseModel
{
    use HasFactory;
    protected $table = 'settings_office_time_types';
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
        'name',
        'working_hour',
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

    public function officeTimes()
    {
        return $this->hasMany(SettingsOfficeTime::class, 'office_time_type_id', 'id');
    }
}
