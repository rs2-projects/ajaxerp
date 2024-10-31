<?php

namespace App\Services\Production\PreProduction;

use App\Models\Machine;
use App\Models\Products\FinishedGoods;
use App\Models\Products\ProductMaterial;
use App\Models\Products\ProductMaterialCategory;
use App\Models\Production\PreProductionProcess;
use App\Models\Production\PreProductionProcessMachine;
use App\Models\Production\PreProductionProcessMaterial;
use App\Models\Production\PreProductionProcessEstimatedOutput;
use App\Models\Production\PreProduction;
use App\Models\Production\PreProductionBoard;
use App\Models\Production\PreProductionMaterial;
use App\Models\Production\PreProductionProcessBoard;
use App\Models\Production\PreProductionProcessPreviousProcess;
use App\Models\Production\ProductionStaff;
use App\Models\Products\FinishedGoodsCategory;
use App\Models\Sales\Invoice;
use App\Services\Common\ImageUploadService;
use App\Services\Common\FileUploadService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PreProductionService
{
    private $paginate_limit;
    public function __construct()
    {
        $this->paginate_limit = config('commonData.paginate_limit');
    }

    public function indexFilteredData($request)
    {
        $status = $request->status_filtered;

        switch ($status){
            case 'all':
                return $this->getAllPreProductions($request);
                break;
            case 'pending':
                return $this->getPendingPreProductions($request);
                break;
            case 'verified':
                return $this->getVerfiedPreProductions($request);
                break;
            case 'revision':
                return $this->getRevisionedPreProductions($request);
                break;
        }
    }

    public function getAllPreProductions($request)
    {
        $keyword_filtered = $request->keyword_filtered??null;
        $data['pre_productions'] = PreProduction::where('deleted', PreProduction::DELETED_NO)
            ->where('status', PreProduction::STATUS_ACTIVE)
            ->where('type', PreProduction::TYPE_OTHERS)
            ->where(function ($q) use ($keyword_filtered){
                if ($keyword_filtered !=''){
                    $q->where('pre_production_no', 'like', '%'.$keyword_filtered.'%');
                }
            })
            ->orderBy('id', 'desc')->paginate($this->paginate_limit);

        $data['view'] = view('production.pre-production._index_filtered', $data)->render();
        return $data;
    }

    public function getPendingPreProductions($request){
        $keyword_filtered = $request->keyword_filtered??null;
        $data['pre_productions'] = PreProduction::where('deleted', PreProduction::DELETED_NO)
            ->where('status', PreProduction::STATUS_ACTIVE)
            ->where('is_verified', PreProduction::VERIFIED_NO)
            ->where('type', PreProduction::TYPE_OTHERS)
            ->where(function ($q) use ($keyword_filtered){
                if ($keyword_filtered !=''){
                    $q->where('pre_production_no', 'like', '%'.$keyword_filtered.'%');
                }
            })
            ->orderBy('id', 'desc')->paginate($this->paginate_limit);

        $data['view'] = view('production.pre-production._index_filtered', $data)->render();
        return $data;
    }

    public function getVerfiedPreProductions($request){
        $keyword_filtered = $request->keyword_filtered??null;
        $data['pre_productions'] = PreProduction::where('deleted', PreProduction::DELETED_NO)
            ->where('status', PreProduction::STATUS_ACTIVE)
            ->where('is_verified', PreProduction::VERIFIED_YES)
            ->where('type', PreProduction::TYPE_OTHERS)
            ->where(function ($q) use ($keyword_filtered){
                if ($keyword_filtered !=''){
                    $q->where('pre_production_no', 'like', '%'.$keyword_filtered.'%');
                }
            })
            ->orderBy('id', 'desc')->paginate($this->paginate_limit);

        $data['view'] = view('production.pre-production._index_filtered', $data)->render();
        return $data;
    }

    public function getRevisionedPreProductions($request){
        $keyword_filtered = $request->keyword_filtered??null;
        $data['pre_productions'] = PreProduction::where('deleted', PreProduction::DELETED_NO)
            ->where('status', PreProduction::STATUS_ACTIVE)
            ->where('is_verified', PreProduction::VERIFIED_REVISION)
            ->where('type', PreProduction::TYPE_OTHERS)
            ->where(function ($q) use ($keyword_filtered){
                if ($keyword_filtered !=''){
                    $q->where('pre_production_no', 'like', '%'.$keyword_filtered.'%');
                }
            })
            ->orderBy('id', 'desc')->paginate($this->paginate_limit);

        $data['view'] = view('production.pre-production._index_filtered', $data)->render();
        return $data;
    }

    public function getDocument($id)
    {
        $data['item'] = PreProduction::where('id', $id)
            ->where('deleted', PreProduction::DELETED_NO)
            ->first();
        if (!$data['item']) {
            throw new \Exception('Pre Production not found');
        }
        return $data;
    }

    public function createData(){
        $pre_production_count = PreProduction::where('deleted', PreProduction::DELETED_NO)
            ->count();
        if($pre_production_count > 0){
            $data['pre_production_batch_no'] = 10001 + $pre_production_count;
        }else{
            $data['pre_production_batch_no'] = 10001;
        }

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
            ->where('type', FinishedGoods::TYPE_OTHERS)
            ->orderBy('id', 'desc')
            ->get();
        
        $data['finished_categoris'] = FinishedGoodsCategory::where('deleted', FinishedGoodsCategory::DELETED_NO)
            ->where('status', FinishedGoodsCategory::STATUS_ACTIVE)
            ->orderBy('id', 'desc')
            ->get();

        $data['staffs'] = ProductionStaff::where('deleted', ProductionStaff::DELETED_NO)
            ->where('status', ProductionStaff::STATUS_ACTIVE)
            ->orderBy('id', 'desc')
            ->get();

        return $data;
    }

    public function getProducts($id){
        $data['products'] = ProductMaterial::where('deleted', ProductMaterial::DELETED_NO)
            ->where('status', ProductMaterial::STATUS_ACTIVE)
            ->where('product_material_category_id', $id)
            ->orderBy('id', 'desc')
            ->get();
        return $data;
    }

    public function getBoardProducts($id){
        $data['products'] = FinishedGoods::where('deleted', FinishedGoods::DELETED_NO)
            ->where('status', FinishedGoods::STATUS_ACTIVE)
            ->where('type', FinishedGoods::TYPE_BOARD)
            ->where('finished_goods_category_id', $id)
            ->orderBy('id', 'desc')
            ->get();
        return $data;
    }

    public function store($request)
    {
        DB::beginTransaction();
        try {

            // $check_duplicate = PreProduction::where('order_details', $request->order_details)
            //         ->where('deleted', PreProduction::DELETED_NO)
            //         ->first();
            // if (!empty($check_duplicate)) {
            //     throw new \Exception("Pre Production already exists");
            // }

            $check_duplicate_batch_no = PreProduction::where('pre_production_batch_no', $request->pre_production_batch_no)
                ->where('deleted', PreProduction::DELETED_NO)
                ->first();

            if (!empty($check_duplicate_batch_no)) {
                throw new \Exception("Batch No already exists");
            }

            $image_path = null;
            $document_path = null;
            if ($request->hasFile('image')) {
                $imageUploadService = new ImageUploadService();
                $image_path = $imageUploadService->store($request->image, 'production/pre_production');
                $image_path = $image_path['path'];
            }
            if ($request->hasFile('image')) {
                $imageUploadService = new FileUploadService();
                $document_path = $imageUploadService->store($request->design_of_documents, 'production/pre_production');
                $document_path = $document_path['path'];
            }

            $pre_production = new PreProduction();
            $pre_production->date = $request->date;
            $pre_production->invoice_id = $request->invoice_id ?? null;
            $pre_production->order_details = $request->order_details;
            $pre_production->pre_production_no = '';
            $pre_production->pre_production_batch_no = $request->pre_production_batch_no;
            $pre_production->image = $image_path??null;
            $pre_production->design_of_documents = $document_path??null;
            $pre_production->description = $request->description;
            $pre_production->finished_goods_id = $request->finished_goods_id;
            $pre_production->estimated_production_qty = $request->estimated_production_qty;
            $pre_production->notes = $request->notes;
            $pre_production->created_by = auth()->user()->id;
            $pre_production->created_at = Carbon::now();
            $pre_production->updated_by = auth()->user()->id;
            $pre_production->updated_at = Carbon::now();
            $pre_production->save();
            $pre_production->pre_production_no = 1000 + $pre_production->id;
            $pre_production->save();

            $category_id = $request->product_material_category_id;
            $material_id = $request->product_material_id;
            $quantity = $request->quantity;

            $uniqueProductMaterials = [];
            $uniqueBoards = [];
            $processes = [];

            if (isset($request->process_id) && is_array($request->process_id) && count($request->process_id) > 0) {
                foreach ($request->process_id as $key => $process_id) {

                    $process = new PreProductionProcess();
                    $process->pre_production_id = $pre_production->id;
                    $process->production_staff_id = $request->production_staff_id[$key];
                    $process->instruction = $request->instruction[$key];
                    $process->created_by = auth()->user()->id;
                    $process->created_at = Carbon::now();
                    $process->updated_by = auth()->user()->id;
                    $process->updated_at = Carbon::now();
                    $process->save();

                    // previous processes
                    $processes[$key] = $process->id;
                    if (isset($request->previous_process[$key]) && is_array($request->previous_process[$key]) && count($request->previous_process[$key]) > 0) {
                        foreach ($request->previous_process[$key] as $previous_process_key) {
                            $previous_process_id = $processes[$previous_process_key];
                            if($previous_process_id != ""){
                                $previous_process = new PreProductionProcessPreviousProcess();
                                $previous_process->pre_production_id = $pre_production->id;
                                $previous_process->pre_production_process_id = $process->id;
                                $previous_process->process_id = $previous_process_id;
                                $previous_process->save();
                            }
                        }
                    }

                    // machines
                    if (isset($request->machine_id[$key]) && is_array($request->machine_id[$key]) && count($request->machine_id[$key]) > 0) {
                        foreach ($request->machine_id[$key] as $machine_id) {
                            if ($machine_id !="") {
                                $machine = new PreProductionProcessMachine();
                                $machine->pre_production_id = $pre_production->id;
                                $machine->pre_production_process_id = $process->id;
                                $machine->machine_id = $machine_id;
                                $machine->save();
                            }
                        }
                    }

                    // process materials
                    if (isset($request->product_material_category_id[$key]) && is_array($request->product_material_category_id[$key]) && count($request->product_material_category_id[$key]) > 0) {
                        foreach ($request->product_material_category_id[$key] as $categoryKey => $category_id) {
                            if (
                                ($request->product_material_category_id[$key][$categoryKey] != '') &&
                                ($request->product_material_id[$key][$categoryKey] != '') &&
                                ($request->quantity[$key][$categoryKey] != '')
                                ) {
                                    if($request->material_type[$key][$categoryKey] == 'other'){
                                        $material = new PreProductionProcessMaterial();
                                        $material->pre_production_id = $pre_production->id;
                                        $material->pre_production_process_id = $process->id;
                                        $material->product_material_category_id = $request->product_material_category_id[$key][$categoryKey];
                                        $material->product_material_id = $request->product_material_id[$key][$categoryKey];
                                        $material->quantity = $request->quantity[$key][$categoryKey];
                                        $material->base_quantity = $request->quantity[$key][$categoryKey];
                                        $material->save();

                                        $material_id = $request->product_material_id[$key][$categoryKey];
                                        $quantity = $request->quantity[$key][$categoryKey];
                                        $category_id = $request->product_material_category_id[$key][$categoryKey];
                                        if(isset($uniqueProductMaterials[$material_id])) {
                                            $uniqueProductMaterials[$material_id]['quantity'] += $quantity;
                                        } else {
                                            $uniqueProductMaterials[$material_id] = [
                                                'material_id' => $material_id,
                                                'category_id' => $category_id,
                                                'quantity' => $quantity,
                                            ];
                                        }
                                    }else if($request->material_type[$key][$categoryKey] == 'board'){
                                        $board = new PreProductionProcessBoard();
                                        $board->pre_production_id = $pre_production->id;
                                        $board->pre_production_process_id = $process->id;
                                        $board->finished_board_category_id = $request->product_material_category_id[$key][$categoryKey];
                                        $board->finished_board_id = $request->product_material_id[$key][$categoryKey];
                                        $board->quantity = $request->quantity[$key][$categoryKey];
                                        $board->base_quantity = $request->quantity[$key][$categoryKey];
                                        $board->save();

                                        $board_id = $request->product_material_id[$key][$categoryKey];
                                        $quantity = $request->quantity[$key][$categoryKey];
                                        $category_id = $request->product_material_category_id[$key][$categoryKey];
                                        if(isset($uniqueBoards[$board_id])) {
                                            $uniqueBoards[$board_id]['quantity'] += $quantity;
                                        } else {
                                            $uniqueBoards[$board_id] = [
                                                'board_id' => $board_id,
                                                'category_id' => $category_id,
                                                'quantity' => $quantity,
                                            ];
                                        }
                                    }
                            }
                        }
                    }

                    if (isset($request->name[$key]) && is_array($request->name[$key]) && count($request->name[$key]) > 0) {
                        foreach ($request->name[$key] as $outputKey => $name) {
                            if ($request->name[$key][$outputKey] != '' && $request->output_quantity[$key][$outputKey] != '') {
                                $output = new PreProductionProcessEstimatedOutput();
                                $output->pre_production_id = $pre_production->id;
                                $output->pre_production_process_id = $process->id;
                                $output->name = $request->name[$key][$outputKey];
                                $output->unit = '';
                                $output->quantity = $request->output_quantity[$key][$outputKey];
                                $output->created_by = auth()->user()->id;
                                $output->created_at = Carbon::now();
                                $output->updated_by = auth()->user()->id;
                                $output->updated_at = Carbon::now();
                                $output->save();
                            }
                        }
                    }
                }
            }

            // pre production materials
            foreach ($uniqueProductMaterials as $materialData) {
                if($materialData['category_id'] !="" && $materialData['material_id'] !="" && $materialData['quantity'] !=""){
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
            }

            // pre production boards
            foreach ($uniqueBoards as $boardData) {
                if($boardData['category_id']!= "" && $boardData['board_id'] !="" && $boardData['quantity'] !=""){
                    $board = new PreProductionBoard();
                    $board->pre_production_id = $pre_production->id;
                    $board->finished_board_category_id = $boardData['category_id'];
                    $board->finished_board_id = $boardData['board_id'];
                    $board->quantity = $boardData['quantity'];
                    $board->base_quantity = $boardData['quantity'];
                    $board->created_by = auth()->user()->id;
                    $board->created_at = Carbon::now();
                    $board->updated_by = auth()->user()->id;
                    $board->updated_at = Carbon::now();
                    $board->save();
                }
            }

        }catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
        DB::commit();
    }

    public function editData($id){
        $data['pre_production'] = PreProduction::find($id);

        $data['machines'] = Machine::where('deleted', Machine::DELETED_NO)
            ->where('status', Machine::STATUS_ACTIVE)
            ->orderBy('id', 'desc')
            ->get();

        $data['categories'] = ProductMaterialCategory::where('deleted', ProductMaterialCategory::DELETED_NO)
            ->where('status', ProductMaterialCategory::STATUS_ACTIVE)
            ->orderBy('id', 'desc')
            ->get();

        $data['finished_products'] = FinishedGoods::where('deleted', FinishedGoods::DELETED_NO)
            ->where('status', FinishedGoods::STATUS_ACTIVE)
            ->where('type', FinishedGoods::TYPE_OTHERS)
            ->orderBy('id', 'desc')
            ->get();

        return $data;
    }

    public function getProcessData($id){
        $data['processes'] = PreProductionProcess::with('materials', 'board_materials', 'estimated_output', 'processMachines', 'previousProcess')
            ->where('deleted', PreProductionProcess::DELETED_NO)
            ->where('status', PreProductionProcess::STATUS_ACTIVE)
            ->where('pre_production_id', $id)
            ->get();

        $data['categories'] = ProductMaterialCategory::where('deleted', ProductMaterialCategory::DELETED_NO)
            ->where('status', ProductMaterialCategory::STATUS_ACTIVE)
            ->orderBy('id', 'desc')
            ->get();

        $data['finished_categoris'] = FinishedGoodsCategory::where('deleted', FinishedGoodsCategory::DELETED_NO)
            ->where('status', FinishedGoodsCategory::STATUS_ACTIVE)
            ->orderBy('id', 'desc')
            ->get();

        $data['machines'] = Machine::where('deleted', Machine::DELETED_NO)
            ->where('status', Machine::STATUS_ACTIVE)
            ->orderBy('id', 'desc')
            ->get();

        $data['staffs'] = ProductionStaff::where('deleted', ProductionStaff::DELETED_NO)
            ->where('status', ProductionStaff::STATUS_ACTIVE)
            ->orderBy('id', 'desc')
            ->get();

        $process_ids = PreProductionProcess::where('pre_production_id', $id)
            ->where('deleted', PreProductionProcess::DELETED_NO)
            ->where('status', PreProductionProcess::STATUS_ACTIVE)
            ->pluck('id')->toArray();
        $data['process_indexes'] = array_flip($process_ids);

        return $data;
    }

    public function update($request, $id)
    {
        DB::beginTransaction();
        try {
            $pre_production = PreProduction::where('id', $id)
                ->where('deleted', PreProduction::DELETED_NO)
                ->where('status', PreProduction::STATUS_ACTIVE)
                ->first();
            if (empty($pre_production)) {
                return redirect()->back()->with(['failed' => 'Pre Production not found!']);
            }

            $check_duplicate_batch_no = PreProduction::where('pre_production_batch_no', $request->pre_production_batch_no)
                ->where('deleted', PreProduction::DELETED_NO)
                ->where('id', '!=', $id)
                ->first();

            if (!empty($check_duplicate_batch_no)) {
                throw new \Exception("Batch No already exists");
            }

            $image_path = null;
            $document_path = null;
            if ($request->hasFile('image')) {
                $imageUploadService = new ImageUploadService();
                $image_path = $imageUploadService->store($request->image, 'production/pre_production');
                $image_path = $image_path['path'];
            }
            if ($request->hasFile('image')) {
                $imageUploadService = new FileUploadService();
                $document_path = $imageUploadService->store($request->design_of_documents, 'production/pre_production');
                $document_path = $document_path['path'];
            }

            $pre_production->date = $request->date;
            $pre_production->pre_production_batch_no = $request->pre_production_batch_no;
            $pre_production->order_details = $request->order_details;
            $pre_production->image = $image_path??$pre_production->image;
            $pre_production->design_of_documents = $document_path??$pre_production->design_of_documents;
            $pre_production->description = $request->description;
            $pre_production->finished_goods_id = $request->finished_goods_id;
            $pre_production->estimated_production_qty = $request->estimated_production_qty;
            $pre_production->notes = $request->notes;
            $pre_production->updated_by = auth()->user()->id;
            $pre_production->updated_at = Carbon::now();
            $pre_production->save();

            $uniqueProductMaterials = [];
            $uniqueBoards = [];
            $processes = [];

            if (isset($request->pre_production_process_id) && is_array($request->pre_production_process_id) && count($request->pre_production_process_id) > 0) {

                $processes_id = $request->pre_production_process_id??[];
                PreProductionProcess::where('pre_production_id', $pre_production->id)
                    ->whereNotIn('id', $processes_id)
                    ->delete();

                foreach ($request->pre_production_process_id as $key=>$process_id) {

                    if ($process_id != ""){
                        // update process
                        $process = PreProductionProcess::where('id', $process_id)
                            ->where('pre_production_id', $pre_production->id)
                            ->first();
                        if ($process){
                            $process->pre_production_id = $pre_production->id;
                            $process->production_staff_id = $request->production_staff_id[$key];
                            $process->instruction = $request->instruction[$key];
                            $process->updated_by = auth()->user()->id;
                            $process->updated_at = Carbon::now();
                            $process->save();

                            // previous processes
                            PreProductionProcessPreviousProcess::where('pre_production_id', $pre_production->id)
                                    ->where('pre_production_process_id', $process_id)->delete();

                            $processes[$key] = $process->id;
                            if (isset($request->previous_process[$key]) && is_array($request->previous_process[$key]) && count($request->previous_process[$key]) > 0) {
                                foreach ($request->previous_process[$key] as $previous_process_key) {
                                    $previous_process_id = $processes[$previous_process_key];
                                    if($previous_process_id != ""){
                                        $previous_process = new PreProductionProcessPreviousProcess();
                                        $previous_process->pre_production_id = $pre_production->id;
                                        $previous_process->pre_production_process_id = $process->id;
                                        $previous_process->process_id = $previous_process_id;
                                        $previous_process->save();
                                    }
                                }
                            }

                            //update machines
                            if (isset($request->machine_id[$key]) && is_array($request->machine_id[$key]) && count($request->machine_id[$key]) > 0) {
                                $machine_ids = $request->machine_id[$key]??[];
                                PreProductionProcessMachine::where('pre_production_id', $pre_production->id)
                                    ->where('pre_production_process_id', $process_id)
                                    ->whereNotIn('id', $machine_ids)
                                    ->delete();
                                foreach ($request->machine_id[$key] as $machine_id) {
                                    if ($machine_id !="") {
                                        $machine = PreProductionProcessMachine::where('pre_production_id', $pre_production->id)
                                            ->where('pre_production_process_id', $process_id)
                                            ->where('machine_id', $machine_id)
                                            ->first();
                                        if ($machine){
                                            continue;
                                        }else{
                                            $machine = new PreProductionProcessMachine();
                                            $machine->pre_production_id = $pre_production->id;
                                            $machine->pre_production_process_id = $process->id;
                                            $machine->machine_id = $machine_id;
                                            $machine->save();
                                        }
                                    }
                                }
                            }

                            // update process materials
                            if (isset($request->product_material_category_id[$key]) && is_array($request->product_material_category_id[$key]) && count($request->product_material_category_id[$key]) > 0) {
                                $material_ids = $request->process_material_id[$key]??[];
                                
                                PreProductionProcessMaterial::where('pre_production_id', $pre_production->id)
                                    ->where('pre_production_process_id', $process_id)
                                    ->whereNotIn('id', $material_ids)
                                    ->delete();

                                PreProductionProcessBoard::where('pre_production_id', $pre_production->id)
                                    ->where('pre_production_process_id', $process_id)
                                    ->whereNotIn('id', $material_ids)
                                    ->delete();

                                foreach ($request->product_material_category_id[$key] as $categoryKey => $category_id) {
                                    if (
                                        $request->process_material_id[$key][$categoryKey] != "" &&
                                        $request->product_material_category_id[$key][$categoryKey] != '' &&
                                        $request->product_material_id[$key][$categoryKey] != '' &&
                                        $request->quantity[$key][$categoryKey] != ''
                                    ){
                                        if($request->material_type[$key][$categoryKey] == 'other'){

                                            $material = PreProductionProcessMaterial::where('pre_production_id', $pre_production->id)
                                                ->where('pre_production_process_id', $process_id)
                                                ->where('id', $request->process_material_id[$key][$categoryKey])
                                                ->first();
                                            if($material){
                                                $material->product_material_category_id = $request->product_material_category_id[$key][$categoryKey];
                                                $material->product_material_id = $request->product_material_id[$key][$categoryKey];
                                                $material->quantity = $request->quantity[$key][$categoryKey];
                                                $material->base_quantity = $request->quantity[$key][$categoryKey];
                                                $material->save();

                                                $material_id = $request->product_material_id[$key][$categoryKey];
                                                $quantity = $request->quantity[$key][$categoryKey];
                                                $category_id = $request->product_material_category_id[$key][$categoryKey];
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
                                        }else if($request->material_type[$key][$categoryKey] == 'board'){
                                            $board = PreProductionProcessBoard::where('pre_production_id', $pre_production->id)
                                                ->where('pre_production_process_id', $process_id)
                                                ->where('id', $request->process_material_id[$key][$categoryKey])
                                                ->first();
                                            if($board){
                                                $board->finished_board_category_id = $request->product_material_category_id[$key][$categoryKey];
                                                $board->finished_board_id = $request->product_material_id[$key][$categoryKey];
                                                $board->quantity = $request->quantity[$key][$categoryKey];
                                                $board->base_quantity = $request->quantity[$key][$categoryKey];
                                                $board->save();

                                                $board_id = $request->product_material_id[$key][$categoryKey];
                                                $quantity = $request->quantity[$key][$categoryKey];
                                                $category_id = $request->product_material_category_id[$key][$categoryKey];
                                                if(isset($uniqueBoards[$board_id])) {
                                                    $uniqueBoards[$board_id]['quantity'] += $quantity;
                                                } else {
                                                    $uniqueBoards[$board_id] = [
                                                        'board_id' => $board_id,
                                                        'category_id' => $category_id,
                                                        'quantity' => $quantity,
                                                    ];
                                                }
                                            }
                                        }
                                    }else{
                                        if($request->material_type[$key][$categoryKey] == 'other'){
                                            $material = new PreProductionProcessMaterial();
                                            $material->pre_production_id = $pre_production->id;
                                            $material->pre_production_process_id = $process->id;
                                            $material->product_material_category_id = $request->product_material_category_id[$key][$categoryKey];
                                            $material->product_material_id = $request->product_material_id[$key][$categoryKey];
                                            $material->quantity = $request->quantity[$key][$categoryKey];
                                            $material->base_quantity = $request->quantity[$key][$categoryKey];
                                            $material->save();

                                            $material_id = $request->product_material_id[$key][$categoryKey];
                                            $quantity = $request->quantity[$key][$categoryKey];
                                            $category_id = $request->product_material_category_id[$key][$categoryKey];
                                            if(isset($uniqueProductMaterials[$material_id])) {
                                                $uniqueProductMaterials[$material_id]['quantity'] += $quantity;
                                            } else {
                                                $uniqueProductMaterials[$material_id] = [
                                                    'material_id' => $material_id,
                                                    'category_id' => $category_id,
                                                    'quantity' => $quantity,
                                                ];
                                            }
                                        }else if($request->material_type[$key][$categoryKey] == 'board'){
                                            $board = new PreProductionProcessBoard();
                                            $board->pre_production_id = $pre_production->id;
                                            $board->pre_production_process_id = $process->id;
                                            $board->finished_board_category_id = $request->product_material_category_id[$key][$categoryKey];
                                            $board->finished_board_id = $request->product_material_id[$key][$categoryKey];
                                            $board->quantity = $request->quantity[$key][$categoryKey];
                                            $board->base_quantity = $request->quantity[$key][$categoryKey];
                                            $board->save();
    
                                            $board_id = $request->product_material_id[$key][$categoryKey];
                                            $quantity = $request->quantity[$key][$categoryKey];
                                            $category_id = $request->product_material_category_id[$key][$categoryKey];
                                            if(isset($uniqueBoards[$board_id])) {
                                                $uniqueBoards[$board_id]['quantity'] += $quantity;
                                            } else {
                                                $uniqueBoards[$board_id] = [
                                                    'board_id' => $board_id,
                                                    'category_id' => $category_id,
                                                    'quantity' => $quantity,
                                                ];
                                            }
                                        }
                                    }
                                }
                            }

                            //update estimated outputs
                            if (isset($request->name[$key]) && is_array($request->name[$key]) && count($request->name[$key]) > 0) {
                                $output_ids = $request->process_output_id[$key]??[];
                                PreProductionProcessEstimatedOutput::where('pre_production_id', $pre_production->id)
                                    ->where('pre_production_process_id', $process_id)
                                    ->whereNotIn('id', $output_ids)
                                    ->delete();
                                foreach ($request->name[$key] as $outputKey => $name) {
                                    if ($request->process_output_id[$key][$outputKey] != '' && $request->name[$key][$outputKey] != '' && $request->output_quantity[$key][$outputKey] != '') {
                                        $output = PreProductionProcessEstimatedOutput::where('pre_production_id', $pre_production->id)
                                            ->where('pre_production_process_id', $process_id)
                                            ->where('id', $request->process_output_id[$key][$outputKey])
                                            ->first();
                                        if ($output){
                                            $output->pre_production_id = $pre_production->id;
                                            $output->pre_production_process_id = $process->id;
                                            $output->name = $request->name[$key][$outputKey];
                                            $output->unit = '';
                                            $output->quantity = $request->output_quantity[$key][$outputKey];
                                            $output->updated_by = auth()->user()->id;
                                            $output->updated_at = Carbon::now();
                                            $output->save();
                                        }
                                    }else{
                                        $output = new PreProductionProcessEstimatedOutput();
                                        $output->pre_production_id = $pre_production->id;
                                        $output->pre_production_process_id = $process->id;
                                        $output->name = $request->name[$key][$outputKey];
                                        $output->unit = '';
                                        $output->quantity = $request->output_quantity[$key][$outputKey];
                                        $output->created_by = auth()->user()->id;
                                        $output->created_at = Carbon::now();
                                        $output->updated_by = auth()->user()->id;
                                        $output->updated_at = Carbon::now();
                                        $output->save();
                                    }
                                }
                            }
                        }
                    }else{
                        // create new process
                        $process = new PreProductionProcess();
                        $process->pre_production_id = $pre_production->id;
                        $process->production_staff_id = $request->production_staff_id[$key];
                        $process->instruction = $request->instruction[$key];
                        $process->created_by = auth()->user()->id;
                        $process->created_at = Carbon::now();
                        $process->updated_by = auth()->user()->id;
                        $process->updated_at = Carbon::now();
                        $process->save();

                        // previous processes
                        $processes[$key] = $process->id;
                        if (isset($request->previous_process[$key]) && is_array($request->previous_process[$key]) && count($request->previous_process[$key]) > 0) {
                            foreach ($request->previous_process[$key] as $previous_process_key) {
                                $previous_process_id = $processes[$previous_process_key];
                                if($previous_process_id != ""){
                                    $previous_process = new PreProductionProcessPreviousProcess();
                                    $previous_process->pre_production_id = $pre_production->id;
                                    $previous_process->pre_production_process_id = $process->id;
                                    $previous_process->process_id = $previous_process_id;
                                    $previous_process->save();
                                }
                            }
                        }

                        //create process machines
                        if (isset($request->machine_id[$key]) && is_array($request->machine_id[$key]) && count($request->machine_id[$key]) > 0) {
                            foreach ($request->machine_id[$key] as $machine_id) {
                                if ($machine_id !="") {
                                    $machine = new PreProductionProcessMachine();
                                    $machine->pre_production_id = $pre_production->id;
                                    $machine->pre_production_process_id = $process->id;
                                    $machine->machine_id = $machine_id;
                                    $machine->save();
                                }
                            }
                        }

                        // create process materials
                        if (isset($request->product_material_category_id[$key]) && is_array($request->product_material_category_id[$key]) && count($request->product_material_category_id[$key]) > 0) {

                            foreach ($request->product_material_category_id[$key] as $categoryKey => $category_id) {
                                if (
                                    ($request->product_material_category_id[$key][$categoryKey] != '') &&
                                    ($request->product_material_id[$key][$categoryKey] != '') &&
                                    ($request->quantity[$key][$categoryKey] != '')
                                    ){

                                    if($request->material_type[$key][$categoryKey] == 'other'){
                                        $material = new PreProductionProcessMaterial();
                                        $material->pre_production_id = $pre_production->id;
                                        $material->pre_production_process_id = $process->id;
                                        $material->product_material_category_id = $request->product_material_category_id[$key][$categoryKey];
                                        $material->product_material_id = $request->product_material_id[$key][$categoryKey];
                                        $material->quantity = $request->quantity[$key][$categoryKey];
                                        $material->base_quantity = $request->quantity[$key][$categoryKey];
                                        $material->save();

                                        $material_id = $request->product_material_id[$key][$categoryKey];
                                        $quantity = $request->quantity[$key][$categoryKey];
                                        $category_id = $request->product_material_category_id[$key][$categoryKey];
                                        if(isset($uniqueProductMaterials[$material_id])) {
                                            $uniqueProductMaterials[$material_id]['quantity'] += $quantity;
                                        } else {
                                            $uniqueProductMaterials[$material_id] = [
                                                'material_id' => $material_id,
                                                'category_id' => $category_id,
                                                'quantity' => $quantity,
                                            ];
                                        }
                                    }else if($request->material_type[$key][$categoryKey] == 'board'){
                                        $board = new PreProductionProcessBoard();
                                        $board->pre_production_id = $pre_production->id;
                                        $board->pre_production_process_id = $process->id;
                                        $board->finished_board_category_id = $request->product_material_category_id[$key][$categoryKey];
                                        $board->finished_board_id = $request->product_material_id[$key][$categoryKey];
                                        $board->quantity = $request->quantity[$key][$categoryKey];
                                        $board->base_quantity = $request->quantity[$key][$categoryKey];
                                        $board->save();

                                        $board_id = $request->product_material_id[$key][$categoryKey];
                                        $quantity = $request->quantity[$key][$categoryKey];
                                        $category_id = $request->product_material_category_id[$key][$categoryKey];
                                        if(isset($uniqueBoards[$board_id])) {
                                            $uniqueBoards[$board_id]['quantity'] += $quantity;
                                        } else {
                                            $uniqueBoards[$board_id] = [
                                                'board_id' => $board_id,
                                                'category_id' => $category_id,
                                                'quantity' => $quantity,
                                            ];
                                        }
                                    }
                                }
                            }
                        }

                        // create estimated outputs
                        if (isset($request->name[$key]) && is_array($request->name[$key]) && count($request->name[$key]) > 0) {
                            foreach ($request->name[$key] as $outputKey => $name) {
                                if ($request->name[$key][$outputKey] != '' && $request->output_quantity[$key][$outputKey] != '') {
                                    $output = new PreProductionProcessEstimatedOutput();
                                    $output->pre_production_id = $pre_production->id;
                                    $output->pre_production_process_id = $process->id;
                                    $output->name = $request->name[$key][$outputKey];
                                    $output->unit = '';
                                    $output->quantity = $request->output_quantity[$key][$outputKey];
                                    $output->created_by = auth()->user()->id;
                                    $output->created_at = Carbon::now();
                                    $output->updated_by = auth()->user()->id;
                                    $output->updated_at = Carbon::now();
                                    $output->save();
                                }
                            }
                        }

                    }
                }
            }

            PreProductionMaterial::where('pre_production_id', $pre_production->id)->delete();
            PreProductionBoard::where('pre_production_id', $pre_production->id)->delete();
                
            // pre production materials
            foreach ($uniqueProductMaterials as $materialData) {
                if($materialData['category_id'] !="" && $materialData['material_id'] !="" && $materialData['quantity'] !=""){
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
            }

            // pre production boards
            foreach ($uniqueBoards as $boardData) {
                if($boardData['category_id']!= "" && $boardData['board_id'] !="" && $boardData['quantity'] !=""){
                    $board = new PreProductionBoard();
                    $board->pre_production_id = $pre_production->id;
                    $board->finished_board_category_id = $boardData['category_id'];
                    $board->finished_board_id = $boardData['board_id'];
                    $board->quantity = $boardData['quantity'];
                    $board->base_quantity = $boardData['quantity'];
                    $board->created_by = auth()->user()->id;
                    $board->created_at = Carbon::now();
                    $board->updated_by = auth()->user()->id;
                    $board->updated_at = Carbon::now();
                    $board->save();
                }
            }

            // foreach ($uniqueProductMaterials as $materialData) {
            //     $material = PreProductionMaterial::where('pre_production_id', $pre_production->id)
            //         ->where('product_material_category_id', $materialData['category_id'])
            //         ->where('product_material_id', $materialData['material_id'])
            //         ->where('deleted', PreProductionMaterial::DELETED_NO)
            //         ->where('status', PreProductionMaterial::STATUS_ACTIVE)
            //         ->first();
            //     if($material){
            //         $material->quantity = $materialData['quantity'];
            //         $material->updated_by = auth()->user()->id;
            //         $material->updated_at = Carbon::now();
            //         $material->save();
            //     }else{
            //         $material = new PreProductionMaterial();
            //         $material->pre_production_id = $pre_production->id;
            //         $material->product_material_category_id = $materialData['category_id'];
            //         $material->product_material_id = $materialData['material_id'];
            //         $material->quantity = $materialData['quantity'];
            //         $material->base_quantity = $materialData['quantity'];
            //         $material->created_by = auth()->user()->id;
            //         $material->created_at = Carbon::now();
            //         $material->updated_by = auth()->user()->id;
            //         $material->updated_at = Carbon::now();
            //         $material->save();
            //     }
            // }
            

        }catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
        DB::commit();
    }

    public function delete($id)
    {
        $pre_production = PreProduction::where('id', $id)
            ->where('deleted', PreProduction::DELETED_NO)
            ->first();
        if (!$pre_production) {
            throw new \Exception('Pre Production not found');
        }
        $pre_production->deleted = PreProduction::DELETED_YES;
        $pre_production->deleted_by = auth()->user()->id;
        $pre_production->deleted_at = now();
        $pre_production->save();
    }

    public function statusUpdateData($id, $status)
    {
        try {
            $pre_production = PreProduction::where('id', $id)
                ->where('deleted', PreProduction::DELETED_NO)
                ->first();
            if (!$pre_production) {
                throw new \Exception('Pre Production not found');
            }
            $pre_production->is_verified = $status;
            $pre_production->updated_by = auth()->user()->id;
            $pre_production->updated_at = now();
            $pre_production->save();
            
            $data['status'] = $status;
            return $data;

        }catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function detailsData($id)
    {
        $pre_production = PreProduction::where('deleted', PreProduction::DELETED_NO)
            ->where('status', PreProduction::STATUS_ACTIVE)
            ->where('id', $id)
            ->first();
        if(!$pre_production){
            throw new \Exception('Pre Production not found');
        }
        $data['pre_production'] = $pre_production;

        return $data;
    }

    public function getInvoiceListData($request) {
        $data['results'] = Invoice::select('id', 'invoice_no')
            ->where('deleted', Invoice::DELETED_NO)
            ->where('status', Invoice::STATUS_ACTIVE)
            ->where(function($q) use($request) {
                if ($request->has('q')) {
                    $q->where('invoice_no', 'like', '%'.$request->q.'%')
                        ->orWhere('order_no', 'like', '%'.$request->q.'%');
                }
            })
            ->orderBy('id', 'desc')
            ->take(10)
            ->get()
            ->map(function ($invoice) {
                return [
                    'id' => $invoice->id,
                    'text' => $invoice->invoice_no,
                ];
            });

        return $data;
    }
}
