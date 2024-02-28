<?php

namespace App\Models\Sales;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceDesigns extends Model
{
    use HasFactory;
    protected $table = 'invoice_designs';
    public $timestamps = false;
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
