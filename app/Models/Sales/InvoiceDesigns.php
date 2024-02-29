<?php

namespace App\Models\Sales;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceDesigns extends Model
{
    use HasFactory;
    protected $table = 'invoice_designs';
    public $timestamps = false;
    //status const
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
    const STATUSES = [
        self::STATUS_ACTIVE => 'Active',
        self::STATUS_INACTIVE => 'Inactive',
    ];
    //Delete status const
    const DELETED_NO = 0;
    const DELETED_YES = 1;
    const DELETEDS = [
        self::DELETED_NO => 'No',
        self::DELETED_YES => 'Yes',
    ];
    protected $fillable = [
        'invoice_id',
        'design',
        'status',
        'deleted',
        'deleted_by',
        'deleted_at',
        'created_at',
        'updated_at',
        'created_by',
        'updated_by',
    ];

    //show image
    public function getShowImageAttribute()
    {
        if ($this->design != null && $this->design != '') {
            return asset($this->design);
        }
        return asset('assets/img/product/documents.png');
    }
    //relation with invoice
    public function invoice(){
        return $this->belongsTo(Invoice::class, 'invoice_id', 'id');
    }
}
