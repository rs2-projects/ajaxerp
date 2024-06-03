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

            if(isset($request->product_id) && is_array($request->product_id) && count($request->product_id) > 0){
                foreach ($request->product_id as $key=>$material_id) {
                    $set_item = new ProductMaterialSetItem();
                    $set_item->product_material_set_id = $set->id;
                    $set_item->product_material_id = $material_id;
                    $set_item->quantity = $request->quantity[$key];
                    $set_item->created_by = auth()->user()->id;
                    $set_item->created_at = Carbon::now();
                    $set_item->updated_by = auth()->user()->id;
                    $set_item->updated_at = Carbon::now();
                    $set_item->save();

                }
            }

        }catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
        DB::commit();
    }

}
