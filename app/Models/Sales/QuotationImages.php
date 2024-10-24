<?php

namespace App\Models\Sales;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuotationImages extends Model
{
    use HasFactory;
    protected $table = 'quotation_images';
    public $timestamps = false;

    //Delete status const
    const DELETED_NO = 0;
    const DELETED_YES = 1;
    const DELETEDS = [
        self::DELETED_NO => 'No',
        self::DELETED_YES => 'Yes',
    ];

    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUSES = [
        self::STATUS_INACTIVE => 'Inactive',
        self::STATUS_ACTIVE => 'Active',
    ];

    protected $fillable = [
        'quotation_id',
        'image',
        'title',
        'image_name',
        'status',
        'deleted',
        'deleted_at',
        'deleted_by',
        'created_at',
        'updated_at',
        'created_by',
        'updated_by'
    ];


    public function quotation()
    {
        return $this->belongsTo(Quotation::class, 'quotation_id', 'id');
    }
}
