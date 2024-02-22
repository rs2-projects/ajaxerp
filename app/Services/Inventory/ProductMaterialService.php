<?php

namespace App\Services\Inventory;

use App\Models\Accounting\AccCoaAccount;
use App\Models\Accounting\AccCoaSubCategory;
use App\Models\Inventory\Warehouse;
use App\Models\Inventory\WarehouseSection;
use App\Models\Inventory\WarehouseSectionRack;
use App\Models\Procurements\ProductMaterialPurchase;
use App\Models\Procurements\ProductMaterialPurchaseCalculatedPrice;
use App\Models\Procurements\ProductMaterialPurchaseDetails;
use App\Models\Products\ProductMaterial;
use App\Models\Products\ProductMaterialCategory;
use App\Models\Products\ProductMaterialRack;
use App\Models\Products\ProductMaterialSection;
use App\Services\Common\ImageUploadService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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

        $data['warehouses'] = Warehouse::where('deleted', Warehouse::DELETED_NO)
            ->where('status', Warehouse::STATUS_ACTIVE)
            ->orderBy('name', 'asc')
            ->get();

        $data['total_product'] = ProductMaterial::where('deleted', ProductMaterial::DELETED_NO)->count();

        return $data;
    }
    public function indexFilteredData($request)
    {

        $keyword_filtered = $request->keyword_filtered;
        $category_filtered = $request->category_filtered;

        $data['product_materials'] = ProductMaterial::where('deleted', ProductMaterial::DELETED_NO)
            ->where(function ($q) use ($keyword_filtered){
                if ($keyword_filtered !=''){
                    $q->where('name', 'like', '%'.$keyword_filtered.'%');
                        $q->orWhere('code', 'like', '%'.$keyword_filtered.'%');

                }
            })
            ->where(function ($q) use ($category_filtered){
                if ($category_filtered !=''){
                    $q->where('product_material_category_id', $category_filtered);
                }
            })
            ->orderBy('name', 'asc')
            ->paginate($this->paginate_limit);

        return $data;
    }

    public function storeData($request)
    {

        DB::beginTransaction();
        try {

            $check_code = ProductMaterial::where('code', $request->code)
                ->where('deleted', ProductMaterial::DELETED_NO)
                ->first();
            if (!empty($check_code)) {
                throw new \Exception("Code already exists");
            }

            $image_path = null;
            if ($request->hasFile('image')) {
                $imageUploadService = new ImageUploadService();
                $image_path = $imageUploadService->store($request->image, 'inventory/product-material');
                $image_path = $image_path['path'];
            }

            $product_material = new ProductMaterial();
            $product_material->name = $request->name;
            $product_material->image = $image_path??null;
            $product_material->product_material_category_id = $request->product_material_category_id;
            $product_material->code = $request->code;
            $product_material->unit_type = $request->unit_type;
            $product_material->low_stock_warning = $request->low_stock_warning;
            $product_material->low_stock_at_least = $request->low_stock_at_least;
            $product_material->tax_id = $request->tax_id;
            $product_material->description = $request->description;
            $product_material->color = $request->color;
            $product_material->working_temperature = $request->working_temperature;
            $product_material->length = $request->length;
            $product_material->width = $request->width;
            $product_material->thickness = $request->thickness;
            $product_material->remarks = $request->remarks;
            $product_material->warehouse_id = $request->warehouse_id;
            $product_material->comments = $request->comments;
            $product_material->created_by = auth()->user()->id;
            $product_material->created_at = Carbon::now();
            $product_material->updated_by = auth()->user()->id;
            $product_material->updated_at = Carbon::now();
            $product_material->save();

            $product_material_section_ids = [];
            if (count($request->sections) > 0) {
                foreach ($request->sections as $key=>$section) {
                    $product_material_section = new ProductMaterialSection();
                    $product_material_section->warehouse_id = $request->warehouse_id;
                    $product_material_section->product_material_id = $product_material->id;
                    $product_material_section->warehouse_section_id = $section;
                    $product_material_section->save();

                    $product_material_section_ids[$section] = $product_material_section->id;
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

                        $product_material_rack = new ProductMaterialRack();
                        $product_material_rack->warehouse_id = $checkRack->warehouse_id;
                        $product_material_rack->product_material_id = $product_material->id;
                        $product_material_rack->product_material_section_id = $product_material_section_ids[$checkRack->warehouse_section_id] ?? null;
                        $product_material_rack->warehouse_section_id = $checkRack->warehouse_section_id;
                        $product_material_rack->warehouse_rack_id = $checkRack->id;
                        $product_material_rack->save();
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

        return $product_material;
    }

    public function editData($id)
    {
        try {
            $data['product_material'] = ProductMaterial::where('id', $id)
                ->where('deleted', ProductMaterial::DELETED_NO)
                ->first();
            if (!$data['product_material']) {
                throw new \Exception('Product Material not found');
            }

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

            $data['warehouses'] = Warehouse::where('deleted', Warehouse::DELETED_NO)
                ->where('status', Warehouse::STATUS_ACTIVE)
                ->orderBy('name', 'asc')
                ->get();

            $data['product_material_sections'] = ProductMaterialSection::where('product_material_id', $id)
                ->where('status', ProductMaterialSection::STATUS_ACTIVE)
                ->pluck('warehouse_section_id')
                ->toArray();

            $data['product_material_racks'] = ProductMaterialRack::where('product_material_id', $id)
                ->where('status', ProductMaterialRack::STATUS_ACTIVE)
                ->pluck('warehouse_rack_id')
                ->toArray();

            $data['sections'] = WarehouseSection::where('warehouse_id', $data['product_material']->warehouse_id)
//                ->whereIn('id', $data['product_material_sections'])
                ->where('deleted', WarehouseSection::DELETED_NO)
                ->where('status', WarehouseSection::STATUS_ACTIVE)
                ->orderBy('name', 'asc')
                ->get();

            $data['racks'] = WarehouseSectionRack::where('warehouse_id', $data['product_material']->warehouse_id)
                ->whereIn('id', $data['product_material_racks'])
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

            $product_material = ProductMaterial::where('id', $id)
                ->where('deleted', ProductMaterial::DELETED_NO)
                ->first();
            if (!$product_material) {
                throw new \Exception('Product Material not found');
            }

            $check_code = ProductMaterial::where('code', $request->code)
                ->where('id', '!=', $id)
                ->where('deleted', ProductMaterial::DELETED_NO)
                ->first();
            if (!empty($check_code)) {
                throw new \Exception("Code already exists");
            }

            $image_path = $product_material->image;
            if ($request->hasFile('image')) {
                $imageUploadService = new ImageUploadService();
                $image_path = $imageUploadService->update($request->image, 'inventory/product-material', $product_material->image);
                $image_path = $image_path['path'];
            }

            $product_material->name = $request->name;
            $product_material->image = $image_path??$product_material->image;
            $product_material->product_material_category_id = $request->product_material_category_id;
            $product_material->warehouse_id = $request->warehouse_id;
            $product_material->code = $request->code;
            $product_material->unit_type = $request->unit_type;
            $product_material->low_stock_warning = $request->low_stock_warning;
            $product_material->low_stock_at_least = $request->low_stock_at_least;
            $product_material->tax_id = $request->tax_id;
            $product_material->description = $request->description;
            $product_material->color = $request->color;
            $product_material->working_temperature = $request->working_temperature;
            $product_material->length = $request->length;
            $product_material->width = $request->width;
            $product_material->thickness = $request->thickness;
            $product_material->remarks = $request->remarks;
            $product_material->comments = $request->comments;
            $product_material->updated_by = auth()->user()->id;
            $product_material->updated_at = Carbon::now();
            $product_material->save();

            $product_material_section_ids = [];

            ProductMaterialRack::where('product_material_id', $id)
                ->whereNotIn('warehouse_rack_id', $request->racks)
                ->delete();

            ProductMaterialSection::where('product_material_id', $id)
                ->whereNotIn('warehouse_section_id', $request->sections)
                ->delete();

            if (count($request->sections) > 0) {
                foreach ($request->sections as $key=>$section) {
                    $product_material_section = ProductMaterialSection::where('product_material_id', $id)
                        ->where('warehouse_section_id', $section)
                        ->first();
                    if (!$product_material_section) {
                        $product_material_section = new ProductMaterialSection();
                    }
                    $product_material_section->warehouse_id = $product_material->warehouse_id;
                    $product_material_section->product_material_id = $product_material->id;
                    $product_material_section->warehouse_section_id = $section;
                    $product_material_section->save();

                    $product_material_section_ids[$section] = $product_material_section->id;
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

                        $product_material_rack = ProductMaterialRack::where('product_material_id', $id)
                            ->where('warehouse_rack_id', $rack)
                            ->first();
                        if (!$product_material_rack) {
                            $product_material_rack = new ProductMaterialRack();
                        }
                        $product_material_rack->warehouse_id = $checkRack->warehouse_id;
                        $product_material_rack->product_material_id = $product_material->id;
                        $product_material_rack->product_material_section_id = $product_material_section_ids[$checkRack->warehouse_section_id] ?? null;
                        $product_material_rack->warehouse_section_id = $checkRack->warehouse_section_id;
                        $product_material_rack->warehouse_rack_id = $checkRack->id;
                        $product_material_rack->save();
                    }
                }
            }

        }catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
        DB::commit();

        return $product_material;
    }

    public function purchaseHistory($id)
    {
        try {
         $data['productMaterial'] = ProductMaterial::where('id', $id)
                ->where('deleted', ProductMaterial::DELETED_NO)
                ->first();
            if (!$data['productMaterial']) {
                throw new \Exception('Product Material not found');
            }

            // $data['purchase_history'] = ProductMaterialPurchaseDetails::where('product_material_id', $id)
            //     ->where('deleted', ProductMaterialPurchaseDetails::DELETED_NO)
            //     ->where('available_qty', '>', 0)
            //     ->orderBy('id', 'desc')
            //     ->get();
        
            $details = ProductMaterialPurchaseDetails::where('product_material_id', $id)
                ->where('deleted', ProductMaterialPurchaseDetails::DELETED_NO)
                ->get();

            $purchaseIds = $details->pluck('product_material_purchase_id')->toArray();

            $purchase = ProductMaterialPurchase::where('deleted', ProductMaterialPurchase::DELETED_NO)
                ->where('price_calculated', 1)
                ->whereIn('id', $purchaseIds)
                ->get();
            
            $calculated = ProductMaterialPurchaseCalculatedPrice::where('deleted', ProductMaterialPurchaseCalculatedPrice::DELETED_NO)
                ->whereIn('product_material_purchase_id', $purchase->pluck('id')->toArray())
                ->get();
            $data['purchase_history'] = $calculated;

            
            return $data;
        }catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function deleteData($id)
    {
        try {
            $product_material = ProductMaterial::where('id', $id)
                ->where('deleted', ProductMaterial::DELETED_NO)
                ->first();
            if (!$product_material) {
                throw new \Exception('Product Material not found');
            }
            $product_material->deleted = ProductMaterial::DELETED_YES;
            $product_material->deleted_by = auth()->user()->id;
            $product_material->deleted_at = now();
            $product_material->save();
        }catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function statusUpdateData($id, $status)
    {
        try {
            $product_material = ProductMaterial::where('id', $id)
                ->where('deleted', ProductMaterial::DELETED_NO)
                ->first();
            if (!$product_material) {
                throw new \Exception('Product Material not found');
            }
            $product_material->status = $status;
            $product_material->updated_by = auth()->user()->id;
            $product_material->updated_at = now();
            $product_material->save();
        }catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
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
}
