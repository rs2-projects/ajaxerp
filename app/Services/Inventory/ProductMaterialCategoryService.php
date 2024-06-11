<?php

namespace App\Services\Inventory;

use App\Models\Products\ProductMaterialCategory;

class ProductMaterialCategoryService
{
    public function __construct()
    {
        $this->paginate_limit = config('commonData.paginate_limit');
    }
    public function indexFilteredData($request)
    {
        $keyword_filtered = $request->keyword_filtered;
        $data['categories'] = ProductMaterialCategory::where('deleted', ProductMaterialCategory::DELETED_NO)
            ->where('type', ProductMaterialCategory::TYPE_OTHERS)
            ->where(function ($q) use ($keyword_filtered){
                if ($keyword_filtered !=''){
                    $q->where('name', 'like', '%'.$keyword_filtered.'%');
                    $q->orWhere('description', 'like', '%'.$keyword_filtered.'%');
                }
            })
            ->orderBy('id', 'desc')->paginate($this->paginate_limit);

        return $data;
    }

    public function store($request)
    {
        $category = new ProductMaterialCategory();
        $category->name = $request->name;
        $category->srp_markup_percent = $request->srp_markup_percent;
        $category->wholesale_discount_percent = $request->wholesale_discount_percent;
        $category->description = $request->description;
        $category->created_by = auth()->user()->id;
        $category->created_at = now();
        $category->updated_by = auth()->user()->id;
        $category->updated_at = now();
        $category->save();
    }

    public function editData($id)
    {
        $data['item'] = ProductMaterialCategory::where('id', $id)
            ->where('deleted', ProductMaterialCategory::DELETED_NO)
            ->first();
        if (!$data['item']) {
            throw new \Exception('Product Material Category not found');
        }
        return $data;
    }

    public function update($request, $id)
    {
        $category = ProductMaterialCategory::where('id', $id)
            ->where('deleted', ProductMaterialCategory::DELETED_NO)
            ->first();
        if (!$category) {
            throw new \Exception('Product Material Category not found');
        }
        $category->name = $request->name;
        $category->srp_markup_percent = $request->srp_markup_percent;
        $category->wholesale_discount_percent = $request->wholesale_discount_percent;
        $category->description = $request->description;
        $category->updated_by = auth()->user()->id;
        $category->updated_at = now();
        $category->save();
    }

    public function delete($id)
    {
        $category = ProductMaterialCategory::where('id', $id)
            ->where('deleted', ProductMaterialCategory::DELETED_NO)
            ->first();
        if (!$category) {
            throw new \Exception('Product Material Category not found');
        }
        $category->deleted = ProductMaterialCategory::DELETED_YES;
        $category->deleted_by = auth()->user()->id;
        $category->deleted_at = now();
        $category->save();
    }

}
