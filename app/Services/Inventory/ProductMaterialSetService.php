<?php

namespace App\Services\Inventory;

use App\Models\Procurements\ProductMaterialPurchaseCalculatedPrice;
use App\Models\Products\ProductMaterial;
use App\Models\Products\ProductMaterialSet;
use App\Models\Products\ProductMaterialSetItem;
use App\Traits\LatestCalculatedPurchaseCostTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ProductMaterialSetService
{   
    private $paginate_limit;
    use LatestCalculatedPurchaseCostTrait;
    
    public function __construct()
    {
        $this->paginate_limit = config('commonData.paginate_limit');
    }

    public function indexFilteredData($request)
    {
        $keyword_filtered = $request->keyword_filtered;
        $data['material_sets'] = ProductMaterialSet::where('deleted', ProductMaterialSet::DELETED_NO)
            ->where(function ($q) use ($keyword_filtered){
                if ($keyword_filtered !=''){
                    $q->where('name', 'like', '%'.$keyword_filtered.'%');
                }
            })
            ->orderBy('id', 'desc')->paginate($this->paginate_limit);

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
                return [
                    'id' => $item->id,
                    'name' => $item->name,
                    'code' => $item->code,
                    'show_image' => asset($item->show_image),
                    'unit_type' => $item::UNIT_TYPES[$item->unit_type],
                    'description' => $item->description,
                    'color' => $item->color,
                    'length' => $item->length,
                    'width' => $item->width,
                    'thickness' => $item->thickness,
                    'cost' => $this->getLatestCalculatedPurchaseCost($item->id),
                    'item_srp' => 0,
                    'item_srp_with_discount' => 0,
                    'item_wholesale' => 0
                ];
            });
        return $data;

    }

    public function storeData($request)
    {

        DB::beginTransaction();
        try {

            $check_code = ProductMaterialSet::where('name', $request->name)
                ->where('deleted', ProductMaterialSet::DELETED_NO)
                ->where('status', ProductMaterialSet::STATUS_ACTIVE)
                ->first();

            if (!empty($check_code)) {
                throw new \Exception("Name already exists");
            }

            $set = new ProductMaterialSet();
            $set->name = $request->name;
            $set->srp_markup_percent = $request->srp_markup_percent;
            $set->wholesale_discount_percent = $request->wholesale_discount_percent;
            $set->created_by = auth()->user()->id;
            $set->created_at = Carbon::now();
            $set->updated_by = auth()->user()->id;
            $set->updated_at = Carbon::now();
            $set->save();

            $rp_cost = 0;
            $rp_srp = 0;
            $srp_with_discount = 0;
            $wholesale = 0;
            $FIXED_PERCENT = 20;

            if(isset($request->product_id) && is_array($request->product_id) && count($request->product_id) > 0){
                foreach ($request->product_id as $key=>$material_id) {
                    $set_item = new ProductMaterialSetItem();
                    $set_item->product_material_set_id = $set->id;
                    $set_item->product_material_id = $material_id;
                    $set_item->quantity = $request->quantity[$key];
                    $set_item->rp_cost = $request->cost[$key];

                    $item_srp_with_discount = ($request->cost[$key] * ($request->srp_markup_percent / 100)) * $request->quantity[$key];
                    $item_srp = $item_srp_with_discount / (1 - ($FIXED_PERCENT / 100));
                    $item_wholesale = $item_srp_with_discount * (1 - ($request->wholesale_discount_percent / 100));

                    $set_item->srp_with_discount = $item_srp_with_discount;
                    $set_item->rp_srp = $item_srp;
                    $set_item->wholesale = $item_wholesale;

                    $set_item->created_by = auth()->user()->id;
                    $set_item->created_at = Carbon::now();
                    $set_item->updated_by = auth()->user()->id;
                    $set_item->updated_at = Carbon::now();
                    $set_item->save();

                    $rp_cost +=  $request->cost[$key] * $request->quantity[$key];
                    $rp_srp += $item_srp;
                    $srp_with_discount += $item_srp_with_discount;
                    $wholesale += $item_wholesale;
                }
            }

            $set->rp_cost = $rp_cost;
            $set->rp_srp = $rp_srp;
            $set->srp_with_discount = $srp_with_discount;
            $set->wholesale = $wholesale;
            $set->price_calculated = ProductMaterialSet::PRICE_CALCULATED_YES;
            $set->save();

        }catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
        DB::commit();
    }

    public function editData($id)
    {
        try {
            $data['material_set'] = ProductMaterialSet::where('id', $id)
                ->where('deleted', ProductMaterialSet::DELETED_NO)
                ->where('status', ProductMaterialSet::STATUS_ACTIVE)
                ->first();

            if (!$data['material_set']) {
                throw new \Exception('Product Material Set not found');
            }

            return $data;
        }catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function getSetItemsData($id)
    {
        $data['material_set'] = ProductMaterialSet::where('id', $id)
                ->where('deleted', ProductMaterialSet::DELETED_NO)
                ->where('status', ProductMaterialSet::STATUS_ACTIVE)
                ->first();

        if (!$data['material_set']) {
            throw new \Exception('Product Material Set not found');
        }

        $cartItems = ProductMaterialSetItem::with('productMaterial')
            ->where('product_material_set_id', $id)
            ->where('deleted', ProductMaterialSetItem::DELETED_NO)
            ->get()
            ->map(function ($item){
                return [
                    'id' => $item->productMaterial->id,
                    'name' => $item->productMaterial->name,
                    'code' => $item->productMaterial->code,
                    'show_image' => asset($item->productMaterial->show_image),
                    'unit_type' => $item->productMaterial::UNIT_TYPES[$item->productMaterial->unit_type],
                    'length' => $item->productMaterial->length,
                    'width' => $item->productMaterial->width,
                    'thickness' => $item->productMaterial->thickness,

                    'product_material_set_item_id' => $item->id,
                    'qty' => $item->quantity,
                    'cost' => $item->rp_cost,
                    'item_srp' => $item->rp_srp,
                    'item_srp_with_discount' => $item->srp_with_discount,
                    'item_wholesale' => $item->wholesale
                ];
            });

        $data['cartItems'] = $cartItems;

        return $data;
    }

    public function updateData($request, $id){
        DB::beginTransaction();
        try {
            $set = ProductMaterialSet::where('id', $id)
                ->where('deleted', ProductMaterialSet::DELETED_NO)
                ->where('status', ProductMaterialSet::STATUS_ACTIVE)
                ->first();

            if(empty($set)){
                throw new \Exception("Product Material Set Not Found");
            }

            $check_name = ProductMaterialSet::where('name', $request->name)
                ->where('deleted', ProductMaterialSet::DELETED_NO)
                ->where('status', ProductMaterialSet::STATUS_ACTIVE)
                ->where('id', '!=', $id)
                ->first();

            if (!empty($check_name)) {
                throw new \Exception("Name already exists");
            }

            $set->name = $request->name;
            $set->srp_markup_percent = $request->srp_markup_percent;
            $set->wholesale_discount_percent = $request->wholesale_discount_percent;
            $set->updated_by = auth()->user()->id;
            $set->updated_at = Carbon::now();
            $set->save();

            $rp_cost = 0;
            $rp_srp = 0;
            $srp_with_discount = 0;
            $wholesale = 0;
            $FIXED_PERCENT = 20;

            if(isset($request->product_id) && is_array($request->product_id) && count($request->product_id) > 0){
                
                $product_material_set_item_ids = $request->product_material_set_item_id ?? [];
                $product_material_set_item_ids = array_filter($product_material_set_item_ids);


                $sets = ProductMaterialSetItem::where('product_material_set_id', $set->id)
                    ->whereNotIn('id', $product_material_set_item_ids)
                    ->where('deleted', ProductMaterialSetItem::DELETED_NO)
                    ->delete();
                
                foreach ($request->product_id as $key=>$material_id) {

                    $set_item = ProductMaterialSetItem::where('product_material_set_id', $set->id)
                        ->where('id', $request->product_material_set_item_id[$key])
                        ->where('deleted', ProductMaterialSetItem::DELETED_NO)
                        ->first();

                    if(empty($set_item)){
                        $set_item = new ProductMaterialSetItem();
                        $set_item->product_material_set_id = $set->id;
                        $set_item->created_at = Carbon::now();
                        $set_item->created_by = auth()->user()->id;
                    }
                    
                    $set_item->product_material_id = $material_id;
                    $set_item->quantity = $request->quantity[$key];
                    $set_item->rp_cost = $request->cost[$key];

                    $item_srp_with_discount = ($request->cost[$key] * ($request->srp_markup_percent / 100)) * $request->quantity[$key];
                    $item_srp = $item_srp_with_discount / (1 - ($FIXED_PERCENT / 100));
                    $item_wholesale = $item_srp_with_discount * (1 - ($request->wholesale_discount_percent / 100));

                    $set_item->srp_with_discount = $item_srp_with_discount;
                    $set_item->rp_srp = $item_srp;
                    $set_item->wholesale = $item_wholesale;

                    $set_item->created_by = auth()->user()->id;
                    $set_item->created_at = Carbon::now();
                    $set_item->updated_by = auth()->user()->id;
                    $set_item->updated_at = Carbon::now();
                    $set_item->save();

                    $rp_cost +=  $request->cost[$key] * $request->quantity[$key];
                    $rp_srp += $item_srp;
                    $srp_with_discount += $item_srp_with_discount;
                    $wholesale += $item_wholesale;
                }
            }

            $set->rp_cost = $rp_cost;
            $set->rp_srp = $rp_srp;
            $set->srp_with_discount = $srp_with_discount;
            $set->wholesale = $wholesale;
            $set->price_calculated = ProductMaterialSet::PRICE_CALCULATED_YES;
            $set->save();

        }catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
        DB::commit();
    }

    public function deleteData($id)
    {
        try {

            $purchase = ProductMaterialSet::where('id', $id)
                ->where('deleted', ProductMaterialSet::DELETED_NO)
                ->first();
            if(empty($purchase)){
                throw new \Exception("Product Material Set Not Found");
            }

            $purchase->deleted = ProductMaterialSet::DELETED_YES;
            $purchase->deleted_at = Carbon::now();
            $purchase->deleted_by = auth()->user()->id;
            $purchase->save();

            $set_items = ProductMaterialSetItem::where('product_material_set_id', $id)
                ->get();

            foreach ($set_items as $item){
                $item->deleted = ProductMaterialSetItem::DELETED_YES;
                $item->deleted_at = Carbon::now();
                $item->deleted_by = auth()->user()->id;
                $item->save();
            }

        }catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function detailsData($id)
    {
        try {
            $data['material_set'] = ProductMaterialSet::where('id', $id)
                ->where('deleted', ProductMaterialSet::DELETED_NO)
                ->where('status', ProductMaterialSet::STATUS_ACTIVE)
                ->first();

            if (!$data['material_set']) {
                throw new \Exception('Product Material Set not found');
            }

            return $data;
        }catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

}
