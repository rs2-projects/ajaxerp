<?php

namespace App\Services\Procurement\ProductMaterial;

use App\Models\Accounting\AccCoaAccount;
use App\Models\Accounting\AccCoaSubCategory;
use App\Models\Products\ProductMaterial;

class ProductMaterialPurchaseService
{

    public function indexFilteredData($request)
    {
        $data = [];
        return $data;
    }

    public function getAllProductMaterials($request)
    {
        if(isset($request->q) && ($request->q != '') && ($request->q != null)) {
            $search_keyword = $request->q;
        } else {
            $search_keyword = null;
        }
        $data['product_materials'] = ProductMaterial::with('tax')
            ->when($search_keyword, function ($q) use($search_keyword){
                return $q->where('name', 'LIKE', '%'.$search_keyword.'%');
            })
            ->where('status', ProductMaterial::STATUS_ACTIVE)
            ->where('deleted', ProductMaterial::DELETED_NO)
            ->get()
            ->map(function ($item) {
                if($item->tax == null) {
                    $itemTax = (object) [
                        'id' => null,
                        'name' => null,
                        'tax_rate' => 0,
                    ];
                } else {
                    $itemTax = $item->tax;
                }
                return [
                    'id' => $item->id,
                    'name' => $item->name,
                    'code' => $item->code,
                    'show_image' => asset($item->show_image),
                    'tax' => $itemTax,
                    'unit_type' => $item::UNIT_TYPES[$item->unit_type],
                    'description' => $item->description,
                    'color' => $item->color,
                    'length' => $item->length,
                    'width' => $item->width,
                    'thickness' => $item->thickness,
                ];
            });
        return $data;

    }

    public function getAllTaxes($request)
    {
        $coaSubCat = AccCoaSubCategory::where('is_sales_tax', AccCoaSubCategory::IS_SALES_TAX_YES)
            ->where('status', AccCoaSubCategory::STATUS_ACTIVE)
            ->where('deleted', AccCoaSubCategory::DELETED_NO)
            ->first();
        if (!empty($coaSubCat)) {
            $data['vat_taxes'] = AccCoaAccount::where('acc_coa_sub_category_id', $coaSubCat->id)

                ->where('status', AccCoaAccount::STATUS_ACTIVE)
                ->where('deleted',AccCoaAccount::DELETED_NO)
                ->get();
        } else {
            $data['vat_taxes'] = [];
        }


        return $data;
    }
}
