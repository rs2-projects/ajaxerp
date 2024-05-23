<?php

namespace App\Services\Inventory;

use App\Models\Products\FinishedGoodsCategory;
use Carbon\Carbon;


class FinishedGoodCategoryService
{
    public function __construct()
    {
        $this->paginate_limit = config('commonData.paginate_limit');
    }
    // index data
    public function indexData($request)
    {
        $data['finished_good_categories'] = FinishedGoodsCategory::where('deleted', FinishedGoodsCategory::DELETED_NO)
            ->where('status', FinishedGoodsCategory::STATUS_ACTIVE)
            ->orderBy('name','asc')
            ->get();
        return $data;
    }
    // filtered data
    public function indexFilteredData($request)
    {
        $keyword_filtered = $request->keyword_filtered;
        $data['categories'] = FinishedGoodsCategory::where('deleted', FinishedGoodsCategory::DELETED_NO)
            ->where('type', FinishedGoodsCategory::TYPE_OTHERS)
            ->where(function ($q) use ($keyword_filtered){
                if ($keyword_filtered !=''){
                    $q->where('name', 'like', '%'.$keyword_filtered.'%');
                    $q->orWhere('description', 'like', '%'.$keyword_filtered.'%');
                }
            })
            ->orderBy('id', 'desc')->paginate($this->paginate_limit);

        return $data;
    }
    // category store
    public function store($request)
    {
        $category = new FinishedGoodsCategory();
        $category->name = $request->name;
        $category->description = $request->description;
        $category->created_at = Carbon::now();
        $category->created_by = auth()->id();
        $category->updated_at = Carbon::now();
        $category->updated_by = auth()->id();
        $category->save();
    }
    // edit category data
    public function editData($id)
    {
        $data['category'] = FinishedGoodsCategory::where('deleted', FinishedGoodsCategory::DELETED_NO)
            ->where('status', FinishedGoodsCategory::STATUS_ACTIVE)
            ->where('id', $id)
            ->first();
        return $data;
    }

    public function update($request)
    {
        $category = FinishedGoodsCategory::where('deleted', FinishedGoodsCategory::DELETED_NO)
            ->where('status', FinishedGoodsCategory::STATUS_ACTIVE)
            ->where('id', $request->id)
            ->first();
        if (!$category) {
            throw new \Exception('Finished Good Category not found');
        }
        $category->name = $request->name;
        $category->description = $request->description;
        $category->updated_at = Carbon::now();
        $category->updated_by = auth()->id();
        $category->save();
    }
    //delete category data
    public function destroy($id)
    {
        $category = FinishedGoodsCategory::where('deleted',FinishedGoodsCategory::DELETED_NO)
            ->where('status',FinishedGoodsCategory::STATUS_ACTIVE)
            ->where('id', $id)
            ->first();
        if (!$category){
            throw new \Exception('Finished Good Category not found');
        }
        $category->deleted = FinishedGoodsCategory::DELETED_YES;
        $category->deleted_at = Carbon::now();
        $category->deleted_by = auth()->id();
        $category->save();
    }
}
