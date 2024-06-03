<?php

namespace App\Traits;

use App\Models\Procurements\ProductMaterialPurchaseCalculatedPrice;

trait LatestCalculatedPurchaseCostTrait
{
    public function getLatestCalculatedPurchaseCost($id){
        $cost = ProductMaterialPurchaseCalculatedPrice::where('product_material_id', $id)
            ->where('deleted', ProductMaterialPurchaseCalculatedPrice::DELETED_NO)
            ->where('status', ProductMaterialPurchaseCalculatedPrice::STATUS_ACTIVE)
            ->orderBy('id', 'desc')
            ->first();

        return $cost->price_excluding_vat??0;
    }
}
