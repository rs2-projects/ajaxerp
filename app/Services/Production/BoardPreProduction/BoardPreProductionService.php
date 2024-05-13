<?php

namespace App\Services\Production\BoardPreProduction;

use App\Models\Machine;
use App\Models\Production\BoardPreProduction;
use App\Models\Production\BoardPreProductionMaterials;
use App\Models\Production\PreProduction;
use App\Models\Production\PreProductionMaterial;
use App\Models\Production\PreProductionProcess;
use App\Models\Production\PreProductionProcessEstimatedOutput;
use App\Models\Production\PreProductionProcessMachine;
use App\Models\Production\PreProductionProcessMaterial;
use App\Models\Production\ProductionStaff;
use App\Models\Products\BoardEmbossed;
use App\Models\Products\FinishedGoods;
use App\Models\Products\ProductMaterial;
use App\Models\Products\ProductMaterialCategory;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class BoardPreProductionService
{
    /**
     * @var int
     */
    private int $paginate_limit;

    public function __construct()
    {
        $this->paginate_limit = config('commonData.paginate_limit');
    }

    public function indexFilteredData($request)
    {
        $keyword_filtered = $request->keyword_filtered ?? null;
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

        $data['finished_products'] = FinishedGoods::where('deleted', FinishedGoods::DELETED_NO)
            ->where('status', FinishedGoods::STATUS_ACTIVE)
            ->where('type', FinishedGoods::TYPE_BOARD)
            ->orderBy('id', 'desc')
            ->get();

        $data['staffs'] = ProductionStaff::where('deleted', ProductionStaff::DELETED_NO)
            ->where('status', ProductionStaff::STATUS_ACTIVE)
            ->orderBy('id', 'desc')
            ->get();

        $data['boards'] = ProductMaterial::where('deleted', ProductMaterial::DELETED_NO)
            ->where('status', ProductMaterial::STATUS_ACTIVE)
            ->where('type', ProductMaterial::TYPE_BOARD)
            ->orderBy('name', 'asc')
            ->get();

        $data['plates'] = BoardEmbossed::where('deleted', BoardEmbossed::DELETED_NO)
            ->where('status', BoardEmbossed::STATUS_ACTIVE)
            ->orderBy('name', 'asc')
            ->get();

        $data['papers'] = ProductMaterial::where('deleted', ProductMaterial::DELETED_NO)
            ->where('status', ProductMaterial::STATUS_ACTIVE)
            ->where('type', ProductMaterial::TYPE_PAPER)
            ->orderBy('name', 'asc')
            ->get();



        return $data;
    }

    public function getMaterialByCategory($request)
    {
        $data['materials'] = ProductMaterial::where('deleted', ProductMaterial::DELETED_NO)
            ->where('status', ProductMaterial::STATUS_ACTIVE)
            ->where('type', ProductMaterial::TYPE_BOARD)
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

    public function sendToProduction($request, $id){
        DB::beginTransaction();
        try {
            $board_pre_production = BoardPreProduction::where('id', $id)
                ->where('deleted', BoardPreProduction::DELETED_NO)
                ->where('status', BoardPreProduction::STATUS_ACTIVE)
                ->first();

            if (empty($board_pre_production)) {
                return redirect()->back()->with(['failed' => 'Board Pre Production not found!']);
            }

            $check_duplicate_batch_no = PreProduction::where('pre_production_batch_no', $request->pre_production_batch_no)
                ->where('deleted', PreProduction::DELETED_NO)
                ->first();

            if (!empty($check_duplicate_batch_no)) {
                throw new \Exception("Batch No already exists");
            }

            $pre_production = new PreProduction();
            $pre_production->type = PreProduction::TYPE_BOARD;
            $pre_production->board_pre_production_id = $board_pre_production->id;
            $pre_production->pre_production_no = '';
            $pre_production->pre_production_batch_no = $request->pre_production_batch_no;
            $pre_production->order_details = "";
            $pre_production->finished_goods_id = $board_pre_production->finished_goods_id;
            $pre_production->estimated_production_qty = $board_pre_production->estimated_quantity*$request->unit;
            $pre_production->notes = $board_pre_production->note;
            $pre_production->is_verified = PreProduction::VERIFIED_YES;
            $pre_production->created_by = auth()->user()->id;
            $pre_production->created_at = Carbon::now();
            $pre_production->updated_by = auth()->user()->id;
            $pre_production->updated_at = Carbon::now();
            $pre_production->save();
            $pre_production->pre_production_no = 1000 + $pre_production->id;
            $pre_production->save();

            $process = new PreProductionProcess();
            $process->pre_production_id = $pre_production->id;
            $process->production_staff_id = $board_pre_production->staff_id??null;
            $process->created_by = auth()->user()->id;
            $process->created_at = Carbon::now();
            $process->updated_by = auth()->user()->id;
            $process->updated_at = Carbon::now();
            $process->save();

            $machine = new PreProductionProcessMachine();
            $machine->pre_production_id = $pre_production->id;
            $machine->pre_production_process_id = $process->id;
            $machine->machine_id = $board_pre_production->machine_id??null;
            $machine->save();

            $board_name = FinishedGoods::where('id', $board_pre_production->finished_goods_id)
                ->where('deleted', FinishedGoods::DELETED_NO)
                ->where('status', FinishedGoods::STATUS_ACTIVE)
                ->where('type', FinishedGoods::TYPE_BOARD)
                ->first();

            $output = new PreProductionProcessEstimatedOutput();
            $output->pre_production_id = $pre_production->id;
            $output->pre_production_process_id = $process->id;
            $output->name = $board_name->name;
            $output->quantity = $pre_production->estimated_production_qty;
            $output->created_by = auth()->user()->id;
            $output->created_at = Carbon::now();
            $output->updated_by = auth()->user()->id;
            $output->updated_at = Carbon::now();
            $output->save();

            $board_materials = BoardPreProductionMaterials::where('board_pre_production_id', $board_pre_production->id)
                ->where('deleted', BoardPreProductionMaterials::DELETED_NO)
                ->where('status', BoardPreProductionMaterials::STATUS_ACTIVE)
                ->get();

            $uniqueProductMaterials = [];

            foreach ($board_materials as $key => $data) {
                $material = new PreProductionProcessMaterial();
                $material->pre_production_id = $pre_production->id;
                $material->pre_production_process_id = $process->id;
                $material->product_material_category_id = $data->product_material_category_id;
                $material->product_material_id = $data->product_material_id;
                $material->quantity = $data->quantity * $request->unit;
                $material->base_quantity = $data->quantity * $request->unit;
                $material->save();

                $material_id = $data->product_material_id;
                $quantity = $data->quantity * $request->unit;
                $category_id = $data->product_material_category_id;

                if(isset($uniqueProductMaterials[$material_id])) {
                    $uniqueProductMaterials[$material_id]['quantity'] += $quantity;
                } else {
                    $uniqueProductMaterials[$material_id] = [
                        'material_id' => $material_id,
                        'category_id' => $category_id,
                        'quantity' => $quantity,
                    ];
                }
            }

            foreach ($uniqueProductMaterials as $materialData) {
                $material = new PreProductionMaterial();
                $material->pre_production_id = $pre_production->id;
                $material->product_material_category_id = $materialData['category_id'];
                $material->product_material_id = $materialData['material_id'];
                $material->quantity = $materialData['quantity'];
                $material->base_quantity = $materialData['quantity'];
                $material->created_by = auth()->user()->id;
                $material->created_at = Carbon::now();
                $material->updated_by = auth()->user()->id;
                $material->updated_at = Carbon::now();
                $material->save();
            }

        }catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
        DB::commit();
    }
}
