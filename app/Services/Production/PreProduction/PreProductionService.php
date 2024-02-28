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
use App\Models\Production\PreProductionMaterial;
use App\Models\Production\PreProductionProcessPreviousProcess;
use App\Services\Common\ImageUploadService;
use App\Services\Common\FileUploadService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PreProductionService
{
    public function __construct()
    {
        $this->paginate_limit = config('commonData.paginate_limit');
    }

    public function indexFilteredData($request)
    {
        $keyword_filtered = $request->keyword_filtered;
        $data['pre_productions'] = PreProduction::where('deleted', PreProduction::DELETED_NO)
            ->where(function ($q) use ($keyword_filtered){
                if ($keyword_filtered !=''){
                    $q->where('pre_production_no', 'like', '%'.$keyword_filtered.'%');
                }
            })
            ->orderBy('id', 'desc')->paginate($this->paginate_limit);

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
            ->orderBy('id', 'desc')
            ->get();
        return $data;
    }

    public function getProducts($id){
        $data['products'] = ProductMaterial::where('deleted', ProductMaterial::DELETED_NO)
            ->where('status', Machine::STATUS_ACTIVE)
            ->where('product_material_category_id', $id)
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
            $pre_production->order_details = $request->order_details;
            $pre_production->pre_production_no = '';
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
            $processes = [];

            if (isset($request->process_id) && is_array($request->process_id) && count($request->process_id) > 0) {
                foreach ($request->process_id as $key => $process_id) {
                    
                    $process = new PreProductionProcess();
                    $process->pre_production_id = $pre_production->id;
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
                   
                    if (isset($request->product_material_category_id[$key]) && is_array($request->product_material_category_id[$key]) && count($request->product_material_category_id[$key]) > 0) {
                        
                        foreach ($request->product_material_category_id[$key] as $categoryKey => $category_id) {
                            if (
                                ($request->product_material_category_id[$key][$categoryKey] != '') && 
                                ($request->product_material_id[$key][$categoryKey] != '') && 
                                ($request->quantity[$key][$categoryKey] != '')
                                ) {
                                $material = new PreProductionProcessMaterial();
                                $material->pre_production_id = $pre_production->id;
                                $material->pre_production_process_id = $process->id;
                                $material->product_material_category_id = $request->product_material_category_id[$key][$categoryKey];
                                $material->product_material_id = $request->product_material_id[$key][$categoryKey];
                                $material->quantity = $request->quantity[$key][$categoryKey];
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
            
            foreach ($uniqueProductMaterials as $materialData) {
                $material = new PreProductionMaterial();
                $material->pre_production_id = $pre_production->id;
                $material->product_material_category_id = $materialData['category_id'];
                $material->product_material_id = $materialData['material_id'];
                $material->quantity = $materialData['quantity'];
                $material->save();
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
            ->orderBy('id', 'desc')
            ->get();
        return $data;
    }

    public function getProcessData($id){
        $data['processes'] = PreProductionProcess::with('materials', 'estimated_output')
            ->where('deleted', PreProductionProcess::DELETED_NO)
            ->where('status', PreProductionProcess::STATUS_ACTIVE)
            ->where('pre_production_id', $id)
            ->get();
        return $data;
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
        }catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
