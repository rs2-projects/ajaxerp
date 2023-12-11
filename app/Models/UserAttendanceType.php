<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAttendanceType extends Model
{
    use HasFactory;

    protected $table = 'user_attendance_types';
    public $timestamps = false;

    const FINGERPRINT_DEVICE_NO = 0;
    const FINGERPRINT_DEVICE_YES = 1;
    const FINGERPRINT_DEVICES = [
        self::FINGERPRINT_DEVICE_NO => 'No',
        self::FINGERPRINT_DEVICE_YES => 'Yes',
    ];

    const IN_GEO_NO = 0;
    const IN_GEO_YES = 1;
    const IN_GEOS = [
        self::IN_GEO_NO => 'No',
        self::IN_GEO_YES => 'Yes',
    ];

    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
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
        'user_id',
        'fingerprint_device',
        'in_geo',
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
