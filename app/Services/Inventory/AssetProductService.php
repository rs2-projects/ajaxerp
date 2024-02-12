<?php

namespace App\Services\Inventory;

use App\Models\Products\AssetProduct;
use App\Models\Products\AssetProductCategory;
use App\Services\Common\ImageUploadService;

class AssetProductService
{
    public function __construct()
    {
        $this->paginate_limit = config('commonData.paginate_limit');
    }

    public function indexData(){
        $data['product_count'] = AssetProduct::where('deleted', AssetProduct::DELETED_NO)->count();
        $data['categories'] = AssetProductCategory::where('deleted', AssetProductCategory::DELETED_NO)
            ->where('status', AssetProductCategory::STATUS_ACTIVE)
            ->orderBy('name', 'asc')->get();
        return $data;
    }

    public function indexFilteredData($request)
    {
        $keyword_filtered = $request->keyword_filtered;
        $category_id = $request->category_id;
        $data['product_count'] = AssetProduct::where('deleted', AssetProduct::DELETED_NO)->count();
        $data['products'] = AssetProduct::where('deleted', AssetProduct::DELETED_NO)
            ->where(function ($q) use ($keyword_filtered){
                if ($keyword_filtered !=''){
                    $q->where('name', 'like', '%'.$keyword_filtered.'%');
                }
            })
            ->where(function ($q) use ($category_id){
                if ($category_id !=''){
                    $q->where('asset_product_category_id', $category_id);
                }
            })
            ->orderBy('id', 'desc')->paginate($this->paginate_limit);
        return $data;
    }

    public function store($request)
    {
        $image_path = null;
        if ($request->hasFile('image')) {
            $imageUploadService = new ImageUploadService();
            $image_path = $imageUploadService->store($request->image, 'inventory/asset-product');
            $image_path = $image_path['path'];
        }
        
        $product = new AssetProduct();
        $product->asset_product_category_id = $request->asset_product_category_id;
        $product->name = $request->name;
        $product->image = $image_path??null;
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
        $data['categories'] = AssetProductCategory::where('deleted', AssetProductCategory::DELETED_NO)
            ->where('status', AssetProductCategory::STATUS_ACTIVE)
            ->orderBy('name', 'asc')->get();

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

        $image_path = null;
        if ($request->hasFile('image')) {
            $imageUploadService = new ImageUploadService();
            $image_path = $imageUploadService->store($request->image, 'inventory/asset-product');
            $image_path = $image_path['path'];
        }

        $product->asset_product_category_id = $request->asset_product_category_id;
        $product->name = $request->name;
        $product->image = $image_path?? $product->image;
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
