<?php

namespace App\Services\Inventory;

use App\Models\Products\AssetProductCategory;

class AssetProductCategoryService
{
    public function __construct()
    {
        $this->paginate_limit = config('commonData.paginate_limit');
    }
    public function indexFilteredData($request)
    {
        $keyword_filtered = $request->keyword_filtered;
        $data['categories'] = AssetProductCategory::where('deleted', AssetProductCategory::DELETED_NO)
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
        $check_duplicate = AssetProductCategory::where('name', $request->name)
                ->where('deleted', AssetProductCategory::DELETED_NO)
                ->first();
        if (!empty($check_duplicate)) {
            throw new \Exception("Asset Product Category already exists");
        }

        $category = new AssetProductCategory();
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
        $data['item'] = AssetProductCategory::where('id', $id)
            ->where('deleted', AssetProductCategory::DELETED_NO)
            ->first();
        if (!$data['item']) {
            throw new \Exception('Asset Product Category not found');
        }
        return $data;
    }

    public function update($request, $id)
    {
        $category = AssetProductCategory::where('id', $id)
            ->where('deleted', AssetProductCategory::DELETED_NO)
            ->first();
        if (!$category) {
            throw new \Exception('Asset Product Category not found');
        }

        $check_duplicate = AssetProductCategory::where('name', $request->name)
                ->where('deleted', AssetProductCategory::DELETED_NO)
                ->where('id', '!=', $id)
                ->first();
        if (!empty($check_duplicate)) {
            throw new \Exception("Asset Product Category already exists");
        }
        $category->name = $request->name;
        $category->description = $request->description;
        $category->updated_by = auth()->user()->id;
        $category->updated_at = now();
        $category->save();
    }

    public function delete($id)
    {
        $category = AssetProductCategory::where('id', $id)
            ->where('deleted', AssetProductCategory::DELETED_NO)
            ->first();
        if (!$category) {
            throw new \Exception('Asset Product Category not found');
        }
        $category->deleted = AssetProductCategory::DELETED_YES;
        $category->deleted_by = auth()->user()->id;
        $category->deleted_at = now();
        $category->save();
    }
}
