<?php

namespace App\Services\Inventory;

use App\Models\Products\AssetProduct;

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

        return $data;
    }

    public function store($request)
    {
        $category = new AssetProduct();
        $category->name = $request->name;
        $category->description = $request->description;
        $category->created_by = auth()->user()->id;
        $category->created_at = now();
        $category->updated_by = auth()->user()->id;
        $category->updated_at = now();
        $category->save();
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
        $category = AssetProduct::where('id', $id)
            ->where('deleted', AssetProduct::DELETED_NO)
            ->first();
        if (!$category) {
            throw new \Exception('Asset Product not found');
        }
        $category->name = $request->name;
        $category->description = $request->description;
        $category->updated_by = auth()->user()->id;
        $category->updated_at = now();
        $category->save();
    }

    public function delete($id)
    {
        $category = AssetProduct::where('id', $id)
            ->where('deleted', AssetProduct::DELETED_NO)
            ->first();
        if (!$category) {
            throw new \Exception('Asset Product not found');
        }AssetProduct
        $category->deleted = AssetProduct::DELETED_YES;
        $category->deleted_by = auth()->user()->id;
        $category->deleted_at = now();
        $category->save();
    }
}
