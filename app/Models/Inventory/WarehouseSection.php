<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WarehouseSection extends Model
{
    use HasFactory;

    protected $table = 'warehouse_sections';
    public $timestamps = false;

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
        'warehouse_id',
        'name',
        'status',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
        'deleted',
        'deleted_at',
        'deleted_by'
    ];

    public function racks()
    {
        return $this->hasMany(WarehouseSectionRack::class, 'warehouse_section_id', 'id')->where('deleted', WarehouseSectionRack::DELETED_NO);
    }
}
