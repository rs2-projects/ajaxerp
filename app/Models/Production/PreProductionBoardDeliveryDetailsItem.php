<?php

namespace App\Models\Production;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PreProductionBoardDeliveryDetailsItem extends BaseModel
{
    use HasFactory;

    protected $table = 'pre_production_board_delivery_details_items';
    public $timestamps = false;

    const RECEIVED_NO = 0;
    const RECEIVED_YES = 1;
    const RECEIVEDS = [
        self::RECEIVED_NO => 'No',
        self::RECEIVED_YES => 'Yes',
    ];

    const SCANNED_NO = 0;
    const SCANNED_YES = 1;
    const SCANNEDS = [
        self::SCANNED_NO => 'No',
        self::SCANNED_YES => 'Yes',
    ];

    protected $fillable = [
        'pre_production_id',
        'pre_production_board_delivery_id',
        'pre_production_board_delivery_details_id',
        'pre_production_board_id',
        'finished_board_id',
        'barcode',
        'received',
        'scanned'
    ];
}
