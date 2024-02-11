<?php

namespace App\Services\Procurement\ProductMaterial;

use App\Models\Procurements\ProductMaterialPurchase;

class PurchaseInvestigationService
{
    public function indexData($purchase_id)
    {
        try {

            $data['purchase'] = ProductMaterialPurchase::with('purchaseDetails')
                ->where('id', $purchase_id)
                ->where('deleted', ProductMaterialPurchase::DELETED_NO)
                ->first();

            if (!$data['purchase']) {
                throw new \Exception('Purchase Order Not Found');
            }

            return $data;

        }catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
