<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettingsOfficeTime extends Model
{
    use HasFactory;
    protected $table = 'settings_office_times';
    public $timestamps = false;

    const IS_WEEKEND_NO = 0;
    const IS_WEEKEND_YES = 1;
    const IS_WEEKENDS = [
        self::IS_WEEKEND_NO => 'No',
        self::IS_WEEKEND_YES => 'Yes',
    ];

    protected $fillable = [
        'office_time_type_id',
        'day',
        'start_time',
        'end_time',
        'is_weekend',
        'working_hour',
    ];
}
