<?php

namespace App\Services\Procurement\Assets;

use App\Models\Products\AssetProduct;
use App\Models\Products\AssetProductCategory;

class UserPurchaseRequestService
{
    public function __construct()
    {
        $this->paginate_limit = config('commonData.paginate_limit');
    }

    public function createData(){
        $data['asset_categories'] = AssetProductCategory::where('deleted', AssetProductCategory::DELETED_NO)
            ->where('status', AssetProductCategory::STATUS_ACTIVE)
            ->orderBy('name', 'asc')->get();
        return $data;
    }

    public function getAssetProducts($request)
    {
        $category_id = $request->category_id;
        $data['products'] = AssetProduct::where('asset_product_category_id', $category_id)
            ->orderBy('name', 'asc')
            ->get();

        return $data;
    }
}
