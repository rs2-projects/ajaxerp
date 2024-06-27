<?php

namespace App\Models\Products;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AssetProductAssignAttachment extends BaseModel
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
