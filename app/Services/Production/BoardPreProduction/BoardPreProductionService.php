<?php

namespace App\Services\Production\BoardPreProduction;

use App\Models\Machine;
use App\Models\Production\BoardPreProduction;
use App\Models\Production\BoardPreProductionMaterials;
use App\Models\Production\ProductionStaff;
use App\Models\Products\FinishedGoods;
use App\Models\Products\ProductMaterial;
use App\Models\Products\ProductMaterialCategory;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class BoardPreProductionService
{
    public function __construct()
    {
        $this->paginate_limit = config('commonData.paginate_limit');
    }

    public function indexFilteredData($request)
    {
        $keyword_filtered = $request->keyword_filtered??null;
        $data['pre_productions'] = BoardPreProduction::where('deleted', BoardPreProduction::DELETED_NO)
            ->where('status', BoardPreProduction::STATUS_ACTIVE)
            ->where(function ($q) use ($keyword_filtered){
                if ($keyword_filtered !=''){
                    $q->where('pre_production_no', 'like', '%'.$keyword_filtered.'%');
                }
            })
            ->orderBy('id', 'desc')->paginate($this->paginate_limit);

        $data['view'] = view('production.board-pre-production._index_filtered', $data)->render();
        return $data;
    }

    public function createData(){
        $data['machines'] = Machine::where('deleted', Machine::DELETED_NO)
            ->where('status', Machine::STATUS_ACTIVE)
            ->orderBy('name', 'asc')
            ->get();

        $data['categories'] = ProductMaterialCategory::where('deleted', ProductMaterialCategory::DELETED_NO)
            ->where('status', ProductMaterialCategory::STATUS_ACTIVE)
            ->orderBy('id', 'desc')
            ->get();

        $data['finished_products'] = FinishedGoods::where('deleted', FinishedGoods::DELETED_NO)
            ->where('status', FinishedGoods::STATUS_ACTIVE)
            ->where('type', FinishedGoods::TYPE_BOARD)
            ->orderBy('id', 'desc')
            ->get();

        $data['staffs'] = ProductionStaff::where('deleted', ProductionStaff::DELETED_NO)
            ->where('status', ProductionStaff::STATUS_ACTIVE)
            ->orderBy('id', 'desc')
            ->get();

        return $data;
    }

    public function getMaterialByCategory($request)
    {
        $data['materials'] = ProductMaterial::where('deleted', ProductMaterial::DELETED_NO)
            ->where('status', ProductMaterial::STATUS_ACTIVE)
            ->where('product_material_category_id', $request->category_id)
            ->orderBy('name', 'asc')
            ->get();

        return $data;

    }

    public function store($request)
    {
        DB::beginTransaction();
        try {
            $pre_production = new BoardPreProduction();
            $pre_production->pre_production_no = '';
            $pre_production->finished_goods_id = $request->finished_goods_id;
            $pre_production->estimated_quantity = $request->estimated_quantity;
            $pre_production->machine_id = $request->machine_id;
            $pre_production->staff_id = $request->staff_id;
            $pre_production->note = $request->note??'';
            $pre_production->created_by = auth()->user()->id;
            $pre_production->created_at = Carbon::now();
            $pre_production->updated_by = auth()->user()->id;
            $pre_production->updated_at = Carbon::now();
            $pre_production->save();
            $pre_production->pre_production_no = 1000 + $pre_production->id;
            $pre_production->save();

            if (isset($request->product_material_category_id) && is_array($request->product_material_category_id) && (count($request->product_material_category_id) > 0)) {
                foreach ($request->product_material_category_id as $key=>$category_id) {
                    if(($request->product_material_category_id[$key] != '') &&
                        ($request->product_material_id[$key] != '') &&
                        ($request->quantity[$key] != '')
                    ){
                        $material = new BoardPreProductionMaterials();
                        $material->board_pre_production_id = $pre_production->id;
                        $material->product_material_category_id = $request->product_material_category_id[$key];
                        $material->product_material_id = $request->product_material_id[$key];
                        $material->quantity = $request->quantity[$key];
                        $material->created_by = auth()->user()->id;
                        $material->created_at = now();
                        $material->updated_by = auth()->user()->id;
                        $material->updated_at = now();
                        $material->save();
                    }
                }
            }

        }catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
        DB::commit();
    }

    public function editData($id){
        $data['pre_production'] = BoardPreProduction::find($id);

        $data['machines'] = Machine::where('deleted', Machine::DELETED_NO)
            ->where('status', Machine::STATUS_ACTIVE)
            ->orderBy('id', 'desc')
            ->get();

        $data['categories'] = ProductMaterialCategory::where('deleted', ProductMaterialCategory::DELETED_NO)
            ->where('status', ProductMaterialCategory::STATUS_ACTIVE)
            ->orderBy('id', 'desc')
            ->get();

        $data['materials'] = ProductMaterial::where('deleted', ProductMaterial::DELETED_NO)
            ->where('status', ProductMaterial::STATUS_ACTIVE)
            ->orderBy('id', 'desc')
            ->get();

        $data['finished_products'] = FinishedGoods::where('deleted', FinishedGoods::DELETED_NO)
            ->where('status', FinishedGoods::STATUS_ACTIVE)
            ->where('type', FinishedGoods::TYPE_BOARD)
            ->orderBy('id', 'desc')
            ->get();

        $data['staffs'] = ProductionStaff::where('deleted', ProductionStaff::DELETED_NO)
            ->where('status', ProductionStaff::STATUS_ACTIVE)
            ->orderBy('id', 'desc')
            ->get();

        $data['pre_production_materials'] = BoardPreProductionMaterials::where('deleted', BoardPreProductionMaterials::DELETED_NO)
            ->where('board_pre_production_id', $id)
            ->where('status', BoardPreProductionMaterials::STATUS_ACTIVE)
            ->orderBy('id', 'asc')
            ->get();
        return $data;
    }

    public function update($request, $id)
    {
        DB::beginTransaction();
        try {
            $pre_production = BoardPreProduction::where('id', $id)
                ->where('deleted', BoardPreProduction::DELETED_NO)
                ->where('status', BoardPreProduction::STATUS_ACTIVE)
                ->first();
            if (empty($pre_production)) {
                return redirect()->back()->with(['failed' => 'Pre Production not found!']);
            }
            
            $pre_production->finished_goods_id = $request->finished_goods_id;
            $pre_production->estimated_quantity = $request->estimated_quantity;
            $pre_production->machine_id = $request->machine_id;
            $pre_production->staff_id = $request->staff_id;
            $pre_production->note = $request->note??'';
            $pre_production->created_by = auth()->user()->id;
            $pre_production->created_at = Carbon::now();
            $pre_production->updated_by = auth()->user()->id;
            $pre_production->updated_at = Carbon::now();
            $pre_production->save();

            if (isset($request->product_material_category_id) && is_array($request->product_material_category_id) && (count($request->product_material_category_id) > 0)) {
                $material_ids = $request->board_material_id??[];
                BoardPreProductionMaterials::where('board_pre_production_id', $pre_production->id)
                    ->whereNotIn('id', $material_ids)
                    ->delete();

                foreach ($request->product_material_category_id as $key=>$category_id) {
                    if(isset($request->board_material_id[$key])) {
                        if((
                            // isset($request->board_material_id) &&
                            $request->board_material_id[$key] != "" &&
                            $request->product_material_category_id[$key] != '') &&
                            ($request->product_material_id[$key] != '') &&
                            ($request->quantity[$key] != '')
                        ){
                            $material = BoardPreProductionMaterials::where('board_pre_production_id', $pre_production->id)
                                ->where('id', $request->board_material_id[$key])
                                ->first();
                            if($material){
                                $material->product_material_category_id = $request->product_material_category_id[$key];
                                $material->product_material_id = $request->product_material_id[$key];
                                $material->quantity = $request->quantity[$key];
                                $material->updated_by = auth()->user()->id;
                                $material->updated_at = now();
                                $material->save();
                            }
                        }
                    }else{
                        if((
                            $request->product_material_category_id[$key] != '') &&
                            ($request->product_material_id[$key] != '') &&
                            ($request->quantity[$key] != '')
                        ){
                            $material = new BoardPreProductionMaterials();
                            $material->board_pre_production_id = $pre_production->id;
                            $material->product_material_category_id = $request->product_material_category_id[$key];
                            $material->product_material_id = $request->product_material_id[$key];
                            $material->quantity = $request->quantity[$key];
                            $material->created_by = auth()->user()->id;
                            $material->created_at = now();
                            $material->updated_by = auth()->user()->id;
                            $material->updated_at = now();
                            $material->save();
                        }
                    }
                }
            }

        }catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
        DB::commit();
    }

    public function delete($id)
    {
        $pre_production = BoardPreProduction::where('id', $id)
            ->where('deleted', BoardPreProduction::DELETED_NO)
            ->first();
        if (!$pre_production) {
            throw new \Exception('Pre Production not found');
        }
        $pre_production->deleted = BoardPreProduction::DELETED_YES;
        $pre_production->deleted_by = auth()->user()->id;
        $pre_production->deleted_at = now();
        $pre_production->save();
    }

    public function detailsData($id)
    {
        $data['item'] = BoardPreProduction::where('id', $id)
            ->where('deleted', BoardPreProduction::DELETED_NO)
            ->where('status', BoardPreProduction::STATUS_ACTIVE)
            ->first();
        if (!$data['item']) {
            throw new \Exception('Pre Production not found');
        }
        return $data;
    }
}
