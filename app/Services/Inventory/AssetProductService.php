<?php

namespace App\Services\Inventory;

use App\Models\Products\AssetProduct;
use App\Models\Products\AssetProductCategory;

class AssetProductService
{
    public function __construct()
    {
        $this->paginate_limit = config('commonData.paginate_limit');
    }
    public function indexFilteredData($request)
    {
        $keyword_filtered = $request->keyword_filtered;
        $data['products'] = AssetProduct::where('deleted', AssetProduct::DELETED_NO)
            ->where(function ($q) use ($keyword_filtered){
                if ($keyword_filtered !=''){
                    $q->where('name', 'like', '%'.$keyword_filtered.'%');
                }
            })
            ->orderBy('id', 'desc')->paginate($this->paginate_limit);
            
        $data['categories'] = AssetProductCategory::where('deleted', AssetProductCategory::DELETED_NO)
            ->where('status', AssetProductCategory::STATUS_ACTIVE)
            ->orderBy('id', 'desc')->get();
        
        dd($data['categories']);
        return $data;
    }

    public function store($request)
    {
        $product = new AssetProduct();
        $product->asset_product_category_id = $request->category;
        $product->name = $request->name;
        $product->description = $request->description;
        $product->created_by = auth()->user()->id;
        $product->created_at = now();
        $product->updated_by = auth()->user()->id;
        $product->updated_at = now();
        $product->save();
    }

    public function editData($id)
    {
        $data['item'] = AssetProduct::where('id', $id)
            ->where('deleted', AssetProduct::DELETED_NO)
            ->first();
        if (!$data['item']) {
            throw new \Exception('Asset Product not found');
        }
        return $data;
    }

    public function update($request, $id)
    {
        $product = AssetProduct::where('id', $id)
            ->where('deleted', AssetProduct::DELETED_NO)
            ->first();
        if (!$product) {
            throw new \Exception('Asset Product not found');
        }
        $product->name = $request->name;
        $product->description = $request->description;
        $product->updated_by = auth()->user()->id;
        $product->updated_at = now();
        $product->save();
    }

    public function delete($id)
    {
        $product = AssetProduct::where('id', $id)
            ->where('deleted', AssetProduct::DELETED_NO)
            ->first();
        if (!$product) {
            throw new \Exception('Asset Product not found');
        }
        $product->deleted = AssetProduct::DELETED_YES;
        $product->deleted_by = auth()->user()->id;
        $product->deleted_at = now();
        $product->save();
    }
}
