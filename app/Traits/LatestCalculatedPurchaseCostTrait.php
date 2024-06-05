<?php

namespace App\Traits;

use App\Models\Procurements\ProductMaterialPurchaseCalculatedPrice;
use App\Models\Production\BoardPreProduction;
use App\Models\Production\BoardPreProductionCalculatedPrice;

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

    public function getLatestCalculatedBoardCost($id){
        $pre_production = BoardPreProduction::where('finished_goods_id', $id)
            ->where('deleted', BoardPreProduction::DELETED_NO)
            ->where('status', BoardPreProduction::STATUS_ACTIVE)
            ->orderBy('id', 'desc')
            ->first();
        if ($pre_production) {
            $cost = BoardPreProductionCalculatedPrice::where('board_pre_production_id', $pre_production->id)
                ->where('deleted', BoardPreProductionCalculatedPrice::DELETED_NO)
                ->where('status', BoardPreProductionCalculatedPrice::STATUS_ACTIVE)
                ->orderBy('id', 'desc')
                ->first();
            if ($cost) {
                return $cost->retail_price ?? 0;
            }
        }
        return 0;
    }    
}
