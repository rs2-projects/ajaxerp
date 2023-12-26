<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettingsSalarySet extends Model
{
    use HasFactory;

    protected $table = 'settings_salary_sets';
    public $timestamps = false;

    protected $fillable = [
        'name',
        'description',
        'settings_salary_type_id',
        'settings_overtime_type_id',
        'settings_absent_penalty_id',
        'settings_late_penalty_id',
        'settings_office_time_type_id',
        'attendance_type_fingerprint_device',
        'attendance_type_in_geo',
        'salary_generate_type',
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
