<?php

namespace App\Models\Products;

use App\Models\Accounting\AccCoaAccount;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinishedGoods extends Model
{
    use HasFactory;

    protected $table = 'finished_goods';
    public $timestamps = false;
    //unit constant
    const UNIT_TYPE_BOX = 1;
    const UNIT_TYPE_CM = 2;
    const UNIT_TYPE_DZ = 3;
    const UNIT_TYPE_FT = 4;
    const UNIT_TYPE_G = 5;
    const UNIT_TYPE_IN = 6;
    const UNIT_TYPE_KG = 7;
    const UNIT_TYPE_KM = 8;
    const UNIT_TYPE_LB = 9;
    const UNIT_TYPE_MG = 10;
    const UNIT_TYPE_ML = 11;
    const UNIT_TYPE_M = 12;
    const UNIT_TYPE_PCS = 13;
    const UNIT_TYPE_SET = 14;
    const UNIT_TYPE_YD = 15;
    const UNIT_TYPES = [
        self::UNIT_TYPE_BOX => 'Box',
        self::UNIT_TYPE_CM => 'CM',
        self::UNIT_TYPE_DZ => 'DZ',
        self::UNIT_TYPE_FT => 'FT',
        self::UNIT_TYPE_G => 'G',
        self::UNIT_TYPE_IN => 'IN',
        self::UNIT_TYPE_KG => 'KG',
        self::UNIT_TYPE_KM => 'KM',
        self::UNIT_TYPE_LB => 'LB',
        self::UNIT_TYPE_MG => 'MG',
        self::UNIT_TYPE_ML => 'ML',
        self::UNIT_TYPE_M => 'M',
        self::UNIT_TYPE_PCS => 'PCS',
        self::UNIT_TYPE_SET => 'SET',
        self::UNIT_TYPE_YD => 'YD',
    ];
    //status constant
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUSES = [
        self::STATUS_INACTIVE => 'Inactive',
        self::STATUS_ACTIVE => 'Active',
    ];
    //delete constant
    const DELETED_NO = 0;
    const DELETED_YES = 1;
    const DELETEDS = [
        self::DELETED_NO => 'No',
        self::DELETED_YES => 'Yes',
    ];

    protected $fillable = [
        'finished_goods_category_id',
        'name',
        'code',
        'image',
        'description',
        'total_finished_qty',
        'total_sale_qty',
        'total_returned_qty',
        'total_damage_qty',
        'available_qty',
        'working_temperature',
        'length',
        'width',
        'thickness',
        'remarks',
        'warehouse_id',
        'comments',
        'status',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
        'deleted',
        'deleted_by',
        'deleted_at',
    ];

    public function getShowImageAttribute()
    {
        if ($this->image != null && $this->image != '') {
            return asset($this->image);
        }
        return asset('assets/img/placeholder.jpg');
    }
    public function finishedGoodWarehouseSections(){
        return $this->hasMany(FinishedGoodsSection::class, 'finished_goods_id', 'id');
    }
}
