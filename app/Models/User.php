<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';
    public $timestamps = false;

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
        self::STATUS_INACTIVE => 'Inactive',
        self::STATUS_ACTIVE => 'Active',
    ];

    const DELETED_NO = 0;
    const DELETED_YES = 1;
    const DELETEDS = [
        self::DELETED_NO => 'No',
        self::DELETED_YES => 'Yes',
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

    const RESIGNED_NO = 0;
    const RESIGNED_YES = 1;
    const RESIGNEDS = [
        self::RESIGNED_NO => 'No',
        self::RESIGNED_YES => 'Yes',
    ];

    const TERMINATED_NO = 0;
    const TERMINATED_YES = 1;
    const TERMINATEDS = [
        self::TERMINATED_NO => 'No',
        self::TERMINATED_YES => 'Yes',
    ];


    protected $fillable = [
        'employee_id',
        'type',
        'role',
        'department_id',
        'designation_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'joining_date',
        'nid_no',
        'nid_image',
        'passport_no',
        'passport_expiry_date',
        'passport_image',
        'date_of_birth',
        'gender',
        'religion',
        'marital_status',
        'marriage_date',
        'present_address',
        'permanent_address',
        'email_verified_at',
        'password',
        'resigned',
        'resign_date',
        'terminated',
        'terminate_date',
        'status',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by',
        'deleted',
        'deleted_at',
        'deleted_by',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    protected $appends = [
      'full_name',
        'show_image',
    ];

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getShowImageAttribute()
    {
        if ($this->image != null && $this->image != '') {
            return asset($this->image);
        }
        return asset('assets/img/profiles/man.png');
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->created_at = Carbon::now();
        });
        static::created(function ($model) {
            $model->employee_id = 1000 + $model->id;
            $model->save();
        });
    }
}
