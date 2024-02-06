<?php

namespace App\Services\Procurement\ProductMaterial;

use App\Models\Products\ProductMaterial;

class ProductMaterialPurchaseService
{

    public function indexFilteredData($request)
    {
        $data = [];
        return $data;
    }

    public function getAllProductMaterials($reqeust)
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
                return [
                    'id' => $item->id,
                    'name' => $item->name,
                    'code' => $item->code,
                    'show_image' => asset($item->show_image),
                    'tax' => $item->tax,
                    'tax_rate' => $item->tax->rate,
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
}
