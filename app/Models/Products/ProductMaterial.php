<?php

namespace App\Models\Products;

use App\Models\Accounting\AccCoaAccount;
use App\Models\Inventory\Warehouse;
use App\Models\Procurements\ProductMaterialPurchaseDetails;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductMaterial extends Model
{
    use HasFactory;
    protected $table = 'product_materials';
    public $timestamps = false;

    const TYPE_BOARD = 0;
    const TYPE_OTHERS = 1;
    const TYPES = [
        self::TYPE_BOARD => 'Board',
        self::TYPE_OTHERS => 'Others'
    ];

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

    const BOTH_SIDE_COLOR_NO = 0;
    const BOTH_SIDE_COLOR_YES = 1;

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
        'type',
        'product_material_category_id',
        'tax_id',
        'unit_type',
        'name',
        'code',
        'image',
        'low_stock_warning',
        'low_stock_at_least',
        'description',
        'total_purchased_qty',
        'total_used_qty',
        'total_returned_qty',
        'total_damage_qty',
        'available_qty',
        'both_side_color',
        'color',
        'downside_color',
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
        'deleted_at',
        'deleted_by'
    ];

    public function getShowImageAttribute()
    {
        if ($this->image != null && $this->image != '') {
            return asset($this->image);
        }
        return asset('assets/img/placeholder.jpg');
    }


    public function materialWarehouseSections(){
        return $this->hasMany(ProductMaterialSection::class, 'product_material_id', 'id');
    }

    public function tax(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(AccCoaAccount::class, 'tax_id', 'id');
    }

    public function countPurchaseDetails()
    {
        return $this->hasMany(ProductMaterialPurchaseDetails::class, 'product_material_id', 'id')
            ->where('deleted', self::DELETED_NO)
            ->where('status', self::STATUS_ACTIVE)
            ->count();
    }
}
