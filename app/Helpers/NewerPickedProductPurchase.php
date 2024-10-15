<?php

namespace App\Helpers;

use App\Models\Production\NewerPickedProductHistory;

class NewerPickedProductPurchase
{
    public static function getNewerPickedProduct($limit = 5)
    {
        return NewerPickedProductHistory::with(['productMaterial', 'productMaterialPurchaseDetails', 'user'])
            ->where('deleted', NewerPickedProductHistory::DELETED_NO)
            ->where('status', NewerPickedProductHistory::STATUS_ACTIVE)
            ->orderBy('id', 'DESC')
            ->take($limit)
            ->get();
    }
}