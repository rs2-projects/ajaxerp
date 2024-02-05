<?php

namespace App\Services\Inventory;

use App\Models\Accounting\AccCoaAccount;
use App\Models\Accounting\AccCoaSubCategory;
use App\Models\Products\ProductMaterial;
use App\Models\Products\ProductMaterialCategory;

class ProductMaterialService
{
    public function __construct()
    {
        $this->paginate_limit = config('commonData.paginate_limit');
    }

    public function indexData()
    {
        $data['material_categories'] = ProductMaterialCategory::where('deleted', ProductMaterialCategory::DELETED_NO)
            ->where('status', ProductMaterialCategory::STATUS_ACTIVE)
            ->orderBy('name', 'asc')
            ->get();

        $subCat = AccCoaSubCategory::where('is_sales_tax', AccCoaSubCategory::IS_SALES_TAX_YES)
            ->where('status', AccCoaSubCategory::STATUS_ACTIVE)
            ->where('deleted', AccCoaSubCategory::DELETED_NO)
            ->first();
        $subCatId = $subCat->id;
        if (empty($subCat)) {
            $subCatId = 0;
        }
        $data['vats'] = AccCoaAccount::where('acc_coa_sub_category_id', $subCatId)
            ->where('deleted', AccCoaAccount::DELETED_NO)
            ->orderBy('name', 'asc')
            ->get();

        $data['units'] = ProductMaterial::UNIT_TYPES;

        return $data;
    }
    public function indexFilteredData($request)
    {
        $data['product_materials'] =[];

        return $data;
    }
}
