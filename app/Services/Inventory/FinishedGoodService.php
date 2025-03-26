<?php

namespace App\Services\Inventory;
use App\Models\Inventory\Warehouse;
use App\Models\Inventory\WarehouseSection;
use App\Models\Inventory\WarehouseSectionRack;
use App\Models\Products\FinishedGoods;
use App\Models\Products\FinishedGoodsCategory;
use App\Models\Products\FinishedGoodsRack;
use App\Models\Products\FinishedGoodsSection;
use App\Services\Common\ImageUploadService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class FinishedGoodService
{
    // Your code here
    public function __construct()
    {
         $this->paginate_limit = config('commonData.paginate_limit');
    }

    public function indexData()
    {
        //finished goods category
        $data['finished_good_categories'] = FinishedGoodsCategory::where('deleted', FinishedGoodsCategory::DELETED_NO)
            ->where('status',FinishedGoodsCategory::STATUS_ACTIVE)
            ->where('type', FinishedGoodsCategory::TYPE_OTHERS)
            ->orderBy('name','asc')
            ->get();
        //Warehouses
        $data['warehouses'] = Warehouse::where('deleted', Warehouse::DELETED_NO)
            ->where('status', Warehouse::STATUS_ACTIVE)
            ->orderBy('name', 'asc')
            ->get();
        //total product
        $data['total_goods'] = FinishedGoods::where('deleted', FinishedGoods::DELETED_NO)
            ->where('status', FinishedGoods::STATUS_ACTIVE)
            ->where('type', FinishedGoods::TYPE_OTHERS)
            ->count();
        return $data;
    }
    //finished good filtered data
    public function indexFilteredData($request)
    {
        $keyword_filtered = $request->keyword_filtered;
        $category_filtered = $request->category_filtered;

        $data['finished_goods'] = FinishedGoods::where('deleted', FinishedGoods::DELETED_NO)
            ->where('type', FinishedGoods::TYPE_OTHERS)
            ->where('status', FinishedGoods::STATUS_ACTIVE)
            ->where(function ($q) use ($keyword_filtered){
                if ($keyword_filtered !=''){
                    $q->where('name', 'like', '%'.$keyword_filtered.'%');
                    $q->orWhere('code', 'like', '%'.$keyword_filtered.'%');

                }
            })
            ->where(function ($q) use ($category_filtered){
                if ($category_filtered !=''){
                    $q->where('finished_goods_category_id', $category_filtered);
                }
            })
            ->orderBy('name', 'asc')
            ->paginate($this->paginate_limit);
        return $data;
    }

    public function getSectionsByWarehouseData($request)
    {
        $warehouse_id = $request->warehouse_id;
        $data['sections'] = WarehouseSection::where('warehouse_id', $warehouse_id)
            ->where('deleted', WarehouseSection::DELETED_NO)
            ->where('status', WarehouseSection::STATUS_ACTIVE)
            ->orderBy('name', 'asc')
            ->get();

        return $data;
    }

    public function getRacksBySectionsData($request)
    {
        $section_ids = $request->section_ids??[];
        $data['racks'] = WarehouseSectionRack::whereIn('warehouse_section_id', $section_ids)
            ->where('deleted', WarehouseSectionRack::DELETED_NO)
            ->where('status', WarehouseSectionRack::STATUS_ACTIVE)
            ->orderBy('name', 'asc')
            ->get();

        return $data;
    }

    public function storeData($request)
    {
        DB::beginTransaction();
        try {

            $check_code = FinishedGoods::where('code', $request->code)
                ->where('deleted', FinishedGoods::DELETED_NO)
                ->first();
            if (!empty($check_code)) {
                throw new \Exception("Code already exists");
            }

            $image_path = null;
            if ($request->hasFile('image')) {
                $imageUploadService = new ImageUploadService();
                $image_path = $imageUploadService->store($request->image, 'inventory/finished-goods');
                $image_path = $image_path['path'];
            }

            $finished_good = new FinishedGoods();
            $finished_good->name = $request->name;
            $finished_good->image = $image_path??null;
            $finished_good->finished_goods_category_id = $request->finished_good_category_id;
            $finished_good->code = $request->code;
            $finished_good->description = $request->description;
            $finished_good->working_temperature = $request->working_temperature;
            $finished_good->length = $request->length;
            $finished_good->width = $request->width;
            $finished_good->thickness = $request->thickness;
            $finished_good->remarks = $request->remarks;
            $finished_good->warehouse_id = $request->warehouse_id;
            $finished_good->comments = $request->comments;
            $finished_good->created_by = auth()->id();
            $finished_good->created_at = Carbon::now();
            $finished_good->updated_by = auth()->id();
            $finished_good->updated_at = Carbon::now();
            $finished_good->save();

            $finished_good_section_ids = [];
            if (count($request->sections) > 0) {
                foreach ($request->sections as $key=>$section) {
                    $finished_good_section = new FinishedGoodsSection();
                    $finished_good_section->warehouse_id = $request->warehouse_id;
                    $finished_good_section->finished_goods_id = $finished_good->id;
                    $finished_good_section->warehouse_section_id = $section;
                    $finished_good_section->save();

                    $finished_good_section_ids[$section] = $finished_good_section->id;
                }
            }else{
                throw new \Exception("Please select at least one section");
            }

            if (count($request->racks) > 0) {
                foreach ($request->racks as $key2=>$rack) {
                    $checkRack = WarehouseSectionRack::where('id', $rack)
                        ->where('deleted', WarehouseSectionRack::DELETED_NO)
                        ->where('status', WarehouseSectionRack::STATUS_ACTIVE)
                        ->first();
                    if (!empty($checkRack)) {

                        $finished_good_rack = new FinishedGoodsRack();
                        $finished_good_rack->warehouse_id = $checkRack->warehouse_id;
                        $finished_good_rack->finished_goods_id = $finished_good->id;
                        $finished_good_rack->finished_goods_section_id = $finished_good_section_ids[$checkRack->warehouse_section_id] ?? null;
                        $finished_good_rack->warehouse_section_id = $checkRack->warehouse_section_id;
                        $finished_good_rack->warehouse_rack_id = $checkRack->id;
                        $finished_good_rack->save();
                    }
                }
            }else{
                throw new \Exception("Please select at least one rack");
            }

//            dd('1ok');

        }catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
        DB::commit();

        return $finished_good;
    }

    public function editData($id)
    {
        try {
            $data['finished_good'] = FinishedGoods::where('id', $id)
                ->where('deleted', FinishedGoods::DELETED_NO)
                ->first();
            if (!$data['finished_good']) {
                throw new \Exception('Finished Goods not found');
            }

            $data['finished_goods_categories'] = FinishedGoodsCategory::where('deleted', FinishedGoodsCategory::DELETED_NO)
                ->where('status', FinishedGoodsCategory::STATUS_ACTIVE)
                ->where('type', FinishedGoodsCategory::TYPE_OTHERS)
                ->orderBy('name', 'asc')
                ->get();

            $data['warehouses'] = Warehouse::where('deleted', Warehouse::DELETED_NO)
                ->where('status', Warehouse::STATUS_ACTIVE)
                ->orderBy('name', 'asc')
                ->get();

            $data['finished_goods_sections'] = FinishedGoodsSection::where('finished_goods_id', $id)
                ->where('status', FinishedGoodsSection::STATUS_ACTIVE)
                ->pluck('warehouse_section_id')
                ->toArray();

            $data['finished_goods_racks'] = FinishedGoodsRack::where('finished_goods_id', $id)
                ->where('status', FinishedGoodsRack::STATUS_ACTIVE)
                ->pluck('warehouse_rack_id')
                ->toArray();

            $data['sections'] = WarehouseSection::where('warehouse_id', $data['finished_good']->warehouse_id)
//                ->whereIn('id', $data['finished_goods_sections'])
                ->where('deleted', WarehouseSection::DELETED_NO)
                ->where('status', WarehouseSection::STATUS_ACTIVE)
                ->orderBy('name', 'asc')
                ->get();

            $data['racks'] = WarehouseSectionRack::where('warehouse_id', $data['finished_good']->warehouse_id)
                ->whereIn('warehouse_section_id', $data['finished_goods_sections'])
                ->where('deleted', WarehouseSectionRack::DELETED_NO)
                ->where('status', WarehouseSectionRack::STATUS_ACTIVE)
                ->orderBy('name', 'asc')
                ->get();

            return $data;
        }catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function updateData($request, $id)
    {


        DB::beginTransaction();
        try {

            $finished_good = FinishedGoods::where('id', $id)
                ->where('deleted', FinishedGoods::DELETED_NO)
                ->first();
            if (!$finished_good) {
                throw new \Exception('Finished goods not found');
            }

            $check_code = FinishedGoods::where('code', $request->code)
                ->where('id', '!=', $id)
                ->where('deleted', FinishedGoods::DELETED_NO)
                ->first();
            if (!empty($check_code)) {
                throw new \Exception("Code already exists");
            }

            $image_path = $finished_good->image;
            if ($request->hasFile('image')) {
                $imageUploadService = new ImageUploadService();
                $image_path = $imageUploadService->update($request->image, 'inventory/finished-good', $finished_good->image);
                $image_path = $image_path['path'];
            }

            $finished_good->name = $request->name;
            $finished_good->image = $image_path??$finished_good->image;
            $finished_good->finished_goods_category_id = $request->finished_goods_category_id;
            $finished_good->warehouse_id = $request->warehouse_id;
            $finished_good->code = $request->code;
            $finished_good->description = $request->description;
            $finished_good->working_temperature = $request->working_temperature;
            $finished_good->length = $request->length;
            $finished_good->width = $request->width;
            $finished_good->thickness = $request->thickness;
            $finished_good->remarks = $request->remarks;
            $finished_good->comments = $request->comments;
            $finished_good->updated_by = auth()->id();
            $finished_good->updated_at = Carbon::now();
            $finished_good->save();

            $finished_good_section_ids = [];

            FinishedGoodsRack::where('finished_goods_id', $id)
                ->whereNotIn('warehouse_rack_id', $request->racks)
                ->delete();

            FinishedGoodsSection::where('finished_goods_id', $id)
                ->whereNotIn('warehouse_section_id', $request->sections)
                ->delete();

            if (count($request->sections) > 0) {
                foreach ($request->sections as $key=>$section) {
                    $finished_good_section = FinishedGoodsSection::where('finished_goods_id', $id)
                        ->where('warehouse_section_id', $section)
                        ->first();
                    if (!$finished_good_section) {
                        $finished_good_section = new FinishedGoodsSection();
                    }
                    $finished_good_section->warehouse_id = $finished_good->warehouse_id;
                    $finished_good_section->finished_goods_id = $finished_good->id;
                    $finished_good_section->warehouse_section_id = $section;
                    $finished_good_section->save();

                    $finished_good_section_ids[$section] = $finished_good_section->id;
                }

            }else{
                throw new \Exception("Please select at least one section");
            }


            if (count($request->racks) > 0) {
                foreach ($request->racks as $key2=>$rack) {
                    $checkRack = WarehouseSectionRack::where('id', $rack)
                        ->where('deleted', WarehouseSectionRack::DELETED_NO)
                        ->where('status', WarehouseSectionRack::STATUS_ACTIVE)
                        ->first();
                    if (!empty($checkRack)) {


                        $finished_good_rack = FinishedGoodsRack::where('finished_goods_id', $id)
                            ->where('warehouse_rack_id', $rack)
                            ->first();
                        if (!$finished_good_rack) {
                            $finished_good_rack = new FinishedGoodsRack();
                        }
                        $finished_good_rack->warehouse_id = $checkRack->warehouse_id;
                        $finished_good_rack->finished_goods_id = $finished_good->id;
                        $finished_good_rack->finished_goods_section_id = $finished_good_section_ids[$checkRack->warehouse_section_id] ?? null;
                        $finished_good_rack->warehouse_section_id = $checkRack->warehouse_section_id;
                        $finished_good_rack->warehouse_rack_id = $checkRack->id;
                        $finished_good_rack->save();
                    }
                }
            }

        }catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
        DB::commit();

        return $finished_good;
    }

    public function deleteData($id)
    {
        try {
            $finished_good = FinishedGoods::where('id', $id)
                ->where('deleted', FinishedGoods::DELETED_NO)
                ->first();
            if (!$finished_good) {
                throw new \Exception('Finished Goods not found');
            }
            $finished_good->deleted = FinishedGoods::DELETED_YES;
            $finished_good->deleted_by = auth()->id();
            $finished_good->deleted_at = now();
            $finished_good->save();
        }catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }

    }


}
