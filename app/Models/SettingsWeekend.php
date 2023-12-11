<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettingsWeekend extends Model
{
    use HasFactory;
    protected $table = 'settings_weekends';
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

    const SATURDAY_NO = 0;
    const SATURDAY_YES = 1;
    const SATURDAYS = [
        self::SATURDAY_NO => 'No',
        self::SATURDAY_YES => 'Yes',
    ];

    const SUNDAY_NO = 0;
    const SUNDAY_YES = 1;
    const SUNDAYS = [
        self::SUNDAY_NO => 'No',
        self::SUNDAY_YES => 'Yes',
    ];

    const MONDAY_NO = 0;
    const MONDAY_YES = 1;
    const MONDAYS = [
        self::MONDAY_NO => 'No',
        self::MONDAY_YES => 'Yes',
    ];

    const TUESDAY_NO = 0;
    const TUESDAY_YES = 1;
    const TUESDAYS = [
        self::TUESDAY_NO => 'No',
        self::TUESDAY_YES => 'Yes',
    ];

    const WEDNESDAY_NO = 0;
    const WEDNESDAY_YES = 1;
    const WEDNESDAYS = [
        self::WEDNESDAY_NO => 'No',
        self::WEDNESDAY_YES => 'Yes',
    ];

    const THURSDAY_NO = 0;
    const THURSDAY_YES = 1;
    const THURSDAYS = [
        self::THURSDAY_NO => 'No',
        self::THURSDAY_YES => 'Yes',
    ];

    const FRIDAY_NO = 0;
    const FRIDAY_YES = 1;
    const FRIDAYS = [
        self::FRIDAY_NO => 'No',
        self::FRIDAY_YES => 'Yes',
    ];


    protected $fillable = [
        'start_date',
        'end_date',
        'saturday',
        'sunday',
        'monday',
        'tuesday',
        'wednesday',
        'thursday',
        'friday',
        'status',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by',
        'deleted',
        'deleted_at',
        'deleted_by',

    ];
}
