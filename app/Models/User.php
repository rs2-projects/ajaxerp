<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';
    public $timestamps = true;

    const TYPE_ADMIN = 0;
    const TYPE_EMPLOYEE = 1;
    const TYPES = [
        self::TYPE_ADMIN => 'Admin',
        self::TYPE_EMPLOYEE => 'Employee',
    ];

    const ROLE_SUPERUSER = 0;
    const ROLE_ADMIN = 1;
    const ROLES = [
        self::ROLE_SUPERUSER => 'Superuser',
        self::ROLE_ADMIN => 'Admin',
    ];

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
    const STATUSES = [
        self::STATUS_ACTIVE => 'Active',
        self::STATUS_INACTIVE => 'Inactive',
    ];

    const GENDER_MALE = 0;
    const GENDER_FEMALE = 1;
    const GENDER_OTHER = 2;
    const GENDERS = [
        self::GENDER_MALE => 'Male',
        self::GENDER_FEMALE => 'Female',
        self::GENDER_OTHER => 'Other'
    ];

    const MARITAL_STATUS_SINGLE = 0;
    const MARITAL_STATUS_MARRIED = 1;
    const MARITAL_STATUS_DIVORCED = 2;
    const MARITAL_STATUS_WIDOWED = 3;
    const MARITAL_STATUSES = [
        self::MARITAL_STATUS_SINGLE => 'Single',
        self::MARITAL_STATUS_MARRIED => 'Married',
        self::MARITAL_STATUS_DIVORCED => 'Divorced',
        self::MARITAL_STATUS_WIDOWED => 'Widowed',
    ];

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
