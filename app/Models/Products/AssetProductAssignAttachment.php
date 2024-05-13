<?php

namespace App\Models\Products;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetProductAssignAttachment extends Model
{
    use HasFactory;

    protected $table = 'asset_product_assign_attachments';
    public $timestamps = false;

    protected $fillable = [
        'asset_product_assign_id',
        'attachment',
        'status'
    ];
}
