<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\Permission\Role;
use App\Traits\HasPermission;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends BaseAuthenticatableModel
{
    use HasApiTokens, HasFactory, Notifiable, HasPermission;

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
    const ROLE_EMPLOYEE = 2;
    const ROLES = [
        self::ROLE_SUPERUSER => 'Superuser',
        self::ROLE_ADMIN => 'Admin',
        self::ROLE_EMPLOYEE => 'Employee',
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

    const CONTRACTED_NO = 0;
    const CONTRACTED_YES = 1;
    const CONTRACTEDS = [
        self::CONTRACTED_NO => 'No',
        self::CONTRACTED_YES => 'Yes',
    ];


    protected $fillable = [
        'employee_id',
        'type',
        'role',
        'role_id',
        'department_id',
        'designation_id',
        'is_contracted',
        'contractor_id',
        'first_name',
        'last_name',
        'email',
        'image',
        'phone',
        'joining_date',
        'nid_no',
        'nid_image',
        'tin_number',
        'sss_number',
        'phic',
        'pag_ibig',
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
        'reset_permission',
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
        'show_nid_image',
        'gender_text',
        'marital_status_text'
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

    public function getShowNidImageAttribute(){
        if ($this->nid_image != null && $this->nid_image != '') {
            return asset($this->nid_image);
        }
        return asset('assets/img/profiles/man.png');
    }

    public function getGenderTextAttribute()
    {
        if ($this->gender !='' || $this->gender !=null){
            return self::GENDERS[$this->gender] ?? 'Unknown';
        }
        return 'N/A';
    }

    public function getMaritalStatusTextAttribute()
    {
        if ($this->marital_status !='' || $this->marital_status !=null){
            return self::MARITAL_STATUSES[$this->marital_status] ?? 'Unknown';
        }
        return 'N/A';
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

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function designation()
    {
        return $this->belongsTo(Designation::class, 'designation_id');
    }

    public function user_role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function userEmergencyContacts(){
        return $this->hasMany(UserEmergencyContact::class, 'user_id');
    }

    public function userEducationInfo()
    {
        return $this->hasMany(UserEducationInfo::class, 'user_id');
    }

    public function userBankInfo()
    {
        return $this->hasMany(UserBankInfo::class, 'user_id');
    }

    public function userExperienceInfo()
    {
        return $this->hasMany(UserExperienceInfo::class, 'user_id');
    }

    public function userContractor()
    {
        return $this->belongsTo(Contractor::class, 'contractor_id');
    }

    public function settingsSalarySetEmployee()
    {
        return $this->belongsTo(SettingsSalarySetEmployee::class, 'id', 'employee_id');
    }
}
