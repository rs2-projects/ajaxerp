<?php

namespace App\Helpers;

use App\Models\Sales\Quotation;

class PendingQuotation
{
    public static function getPendingQuotations($limit = 5)
    {
        $threeDaysAgo = now()->subDays(3)->startOfDay();
        
        return Quotation::with('customer')
            ->where('quotation_status', Quotation::QUOTATION_STATUS_PENDING)
            ->where('deleted', Quotation::DELETED_NO)
            ->where('status', Quotation::STATUS_ACTIVE)
            ->whereDate('quotation_date', '<=', $threeDaysAgo)
            ->orderBy('id', 'DESC')
            ->take($limit)
            ->get();
    }
}