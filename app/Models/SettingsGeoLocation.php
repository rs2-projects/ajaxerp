<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettingsGeoLocation extends Model
{
    use HasFactory;

    protected $table = 'settings_geo_locations';
    public $timestamps = false;

    const MAP_TYPE_POLYGON = 0;
    const MAP_TYPE_CIRCLE = 1;
    const MAP_TYPE_RECTANGLE = 2;
    const MAP_TYPES = [
        self::MAP_TYPE_POLYGON => 'Polygon',
        self::MAP_TYPE_CIRCLE => 'Circle',
        self::MAP_TYPE_RECTANGLE => 'Rectangle',
    ];

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

    const IS_DEFAULT_NO = 0;
    const IS_DEFAULT_YES = 1;
    const IS_DEFAULTS = [
        self::IS_DEFAULT_NO => 'No',
        self::IS_DEFAULT_YES => 'Yes',
    ];

    protected $fillable = [
        'title',
        'description',
        'map_type',
        'location_data',
        'is_default',
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
}
