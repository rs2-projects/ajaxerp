<?php

namespace App\Services\ProductionStaff;
use App\Models\Production\PreProduction;
use App\Models\Production\PreProductionMaterial;
use App\Models\Production\PreProductionMaterialDelivery;
use App\Models\Production\PreProductionMaterialDeliveryDetails;
use App\Models\Production\PreProductionMaterialDeliveryDetailsItems;
use App\Models\Production\PreProductionProcess;
use App\Models\Production\ProductionDispatch;
use Barryvdh\DomPDF\PDF;
use Illuminate\Support\Facades\DB;
use Picqer\Barcode\BarcodeGeneratorPNG;

class ProductionService
{
    public function __construct()
    {
        $this->paginate_limit = config('commonData.paginate_limit');
    }

    public function indexFilteredData($request)
    {
        $delivery_status = $request->status_filtered;

        switch ($delivery_status){
            case 'all_pre_production':
                return $this->getAllPreProductions($request);
                break;
            case 'pre_production':
                return $this->getPendingPreProductions($request);
                break;
            case 'pending_for_receive':
                return $this->getPendingForReceivePreProductions($request);
                break;
            case 'on_process':
                return $this->getPartialPreProductions($request);
                break;
            case 'completed':
                return $this->getDeliveredPreProductions($request);
                break;
            case 'dispatched':
                return $this->getDispatchedPreProductions($request);
                break;
        }
    }

    public function getAllPreProductions($request){
        $keyword_filtered = $request->keyword_filtered??null;
        $data['pre_productions'] = PreProduction::where('deleted', PreProduction::DELETED_NO)
            ->where('is_verified', PreProduction::VERIFIED_YES)
            ->where(function ($q) use ($keyword_filtered){
                if ($keyword_filtered !=''){
                    $q->where('pre_production_no', 'like', '%'.$keyword_filtered.'%');
                }
            })
            ->orderBy('id', 'desc')->paginate($this->paginate_limit);

        $data['view'] = view('production-staff.production._index_filtered', $data)->render();
        return $data;
    }

    public function getPendingPreProductions($request){
        $keyword_filtered = $request->keyword_filtered??null;
        $data['pre_productions'] = PreProduction::where('deleted', PreProduction::DELETED_NO)
            ->where('is_verified', PreProduction::VERIFIED_YES)
            ->where('process_status', PreProduction::PROCESS_STATUS_PENDING)
            ->where(function ($q) use ($keyword_filtered){
                if ($keyword_filtered !=''){
                    $q->where('pre_production_no', 'like', '%'.$keyword_filtered.'%');
                }
            })
            ->orderBy('id', 'desc')->paginate($this->paginate_limit);

        $data['view'] = view('production-staff.production._index_filtered', $data)->render();
        return $data;
    }

    public function getPendingForReceivePreProductions($request){
        $keyword_filtered = $request->keyword_filtered ?? null;
        $data['pre_productions'] = PreProduction::with('pendingPreProductionMaterialDeliveries')
            ->where('deleted', PreProduction::DELETED_NO)
            ->where('is_verified', PreProduction::VERIFIED_YES)
            ->where(function ($q) use ($keyword_filtered) {
                if ($keyword_filtered != '') {
                    $q->where('pre_production_no', 'like', '%' . $keyword_filtered . '%');
                }
            })
            ->has('pendingPreProductionMaterialDeliveries')
            ->orderBy('id', 'desc')->paginate($this->paginate_limit);
        
        $data['view'] = view('production-staff.production._pending_for_receive_filtered', $data)->render();
        return $data;
    }

    public function getPartialPreProductions($request){
        $keyword_filtered = $request->keyword_filtered??null;
        $data['pre_productions'] = PreProduction::where('deleted', PreProduction::DELETED_NO)
            ->where('is_verified', PreProduction::VERIFIED_YES)
            ->where('process_status', PreProduction::PROCESS_STATUS_PROCESSING)
            ->where(function ($q) use ($keyword_filtered){
                if ($keyword_filtered !=''){
                    $q->where('pre_production_no', 'like', '%'.$keyword_filtered.'%');
                }
            })
            ->orderBy('id', 'desc')->paginate($this->paginate_limit);

        $data['view'] = view('production-staff.production._on_process_filtered', $data)->render();
        return $data;
    }

    public function getDeliveredPreProductions($request){
        $keyword_filtered = $request->keyword_filtered??null;
        $data['pre_productions'] = PreProduction::where('deleted', PreProduction::DELETED_NO)
            ->where('is_verified', PreProduction::VERIFIED_YES)
            ->where('process_status', PreProduction::PROCESS_STATUS_COMPLETED)
            ->where(function ($q) use ($keyword_filtered){
                if ($keyword_filtered !=''){
                    $q->where('pre_production_no', 'like', '%'.$keyword_filtered.'%');
                }
            })
            ->orderBy('id', 'desc')->paginate($this->paginate_limit);

        $data['view'] = view('production-staff.production._completed_filtered', $data)->render();
        return $data;
    }

    public function getDispatchedPreProductions($request){
        $keyword_filtered = $request->keyword_filtered??null;
        $data['pre_productions'] = PreProduction::where('deleted', PreProduction::DELETED_NO)
            ->where('is_verified', PreProduction::VERIFIED_YES)
            ->where('dispatched_status', PreProduction::DISPATCH_STATUS_DISPATCHED)
            ->where(function ($q) use ($keyword_filtered){
                if ($keyword_filtered !=''){
                    $q->where('pre_production_no', 'like', '%'.$keyword_filtered.'%');
                }
            })
            ->orderBy('id', 'desc')->paginate($this->paginate_limit);

        $data['view'] = view('production-staff.production._dispatched_filtered', $data)->render();
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

    public function detailsData($id){
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

    public function statusUpdateData($id, $processId, $status)
    {
        DB::beginTransaction();
        try {
            $pre_production = PreProduction::where('id', $id)
                ->where('deleted', PreProduction::DELETED_NO)
                ->where('status', PreProduction::STATUS_ACTIVE)
                ->first();
            if (!$pre_production) {
                throw new \Exception('Pre Production not found');
            }

            if($pre_production->received_status == PreProduction::RECEIVED_STATUS_PENDING){
                throw new \Exception('Raw materials has not yet been received!');
            }

            $process = PreProductionProcess::where('id', $processId)
                ->where('deleted', PreProductionProcess::DELETED_NO)
                ->where('status', PreProductionProcess::STATUS_ACTIVE)
                ->first();
            if($process){
                $process->process_status = $status;
                $process->updated_by = auth()->user()->id;
                $process->updated_at = now();
                $process->save();
            }

            $count_processing = PreProductionProcess::where('pre_production_id', $id)
                ->where('deleted', PreProductionProcess::DELETED_NO)
                ->where('status', PreProductionProcess::STATUS_ACTIVE)
                ->where('process_status', PreProductionProcess::PROCESS_STATUS_PROCESSING)
                ->count();
            if($count_processing > 0){
                $pre_production->process_status = PreProduction::PROCESS_STATUS_PROCESSING;
                $pre_production->updated_by = auth()->user()->id;
                $pre_production->updated_at = now();
                $pre_production->save();  
            }

            $count_completed = PreProductionProcess::where('pre_production_id', $id)
                ->where('deleted', PreProductionProcess::DELETED_NO)
                ->where('status', PreProductionProcess::STATUS_ACTIVE)
                ->where('process_status', '!=' , PreProductionProcess::PROCESS_STATUS_COMPLETED)
                ->count();

            if($count_completed == 0){
                if($pre_production->delivery_status != PreProduction::DELIVERY_STATUS_DELIVERED){
                    throw new \Exception('All Production Materials not delivered!');
                }
                if($pre_production->received_status != PreProduction::RECEIVED_STATUS_DELIVERED){
                    throw new \Exception('All Production Materials not received!');
                }

                $pre_production->process_status = PreProduction::PROCESS_STATUS_COMPLETED;
                $pre_production->updated_by = auth()->user()->id;
                $pre_production->updated_at = now();
                $pre_production->save();  
            }
        }catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
        DB::commit();
    }

    public function receiveData($id){
        $pre_production = PreProduction::where('deleted', PreProduction::DELETED_NO)
            ->where('id', $id)
            ->first();
        if(!$pre_production){
            throw new \Exception('Pre Production not found');
        }
        $data['deliveries'] = PreProductionMaterialDelivery::where('deleted', PreProductionMaterialDelivery::DELETED_NO)
            ->where('status', PreProductionMaterialDelivery::STATUS_ACTIVE)
            ->where('pre_production_id', $id)
            ->get();
        $data['pre_production'] = $pre_production;
        return $data;
    }

    public function checkBarCode($request, $id){
        $pre_production = PreProduction::where('deleted', PreProduction::DELETED_NO)
            ->where('status', PreProduction::STATUS_ACTIVE)
            ->where('id', $id)
            ->first();
        if(!$pre_production){
            throw new \Exception('Pre Production not found');
        }

        $valid_code = PreProductionMaterialDeliveryDetailsItems::where('received', PreProductionMaterialDeliveryDetailsItems::RECEIVED_NO)
            ->where('pre_production_id', $id)
            ->where('pre_production_material_delivery_id', $request->delivery_id)
            ->where('pre_production_material_delivery_details_id', $request->delivery_details_id)
            ->where('barcode', $request->barcode)
            ->get();

        $data['is_valid_code'] = 0;
        $data['code_quantity'] = 0;

        if($valid_code->count() > 0){
            $data['is_valid_code'] = 1;
            $data['code_quantity'] = $valid_code->count();
            $data['code'] = $valid_code->first()->barcode;
        }
        return $data;
    }

    public function receiveStoreData($request, $id){
        DB::beginTransaction();
        try {
            $pre_production = PreProduction::where('deleted', PreProduction::DELETED_NO)
                ->where('status', PreProduction::STATUS_ACTIVE)
                ->where('id', $id)
                ->first();
            if(!$pre_production){
                throw new \Exception('Pre Production not found');
            }

            $delivery_id = $request->pre_production_material_delivery_id;
            $delivery = PreProductionMaterialDelivery::where('deleted', PreProductionMaterialDelivery::DELETED_NO)
                ->where('id', $delivery_id)
                ->where('status', PreProductionMaterialDelivery::STATUS_ACTIVE)
                ->first();
            if(!$delivery){
                throw new \Exception('Pre Production Delivery not found');
            }

            if (isset($request->pre_production_material_delivery_details_id) && is_array($request->pre_production_material_delivery_details_id) && count($request->pre_production_material_delivery_details_id) > 0) {
                
                foreach($request->pre_production_material_delivery_details_id as $detailsKey => $detailsId){
                    if($detailsId != '' && isset($request->code[$detailsKey]) && is_array($request->code[$detailsKey]) && $request->code[$detailsKey] > 0){
                        
                        foreach($request->code[$detailsKey] as $itemKey => $itemCode){
                            $item = PreProductionMaterialDeliveryDetailsItems::where('received', PreProductionMaterialDeliveryDetailsItems::RECEIVED_NO)
                                ->where('pre_production_id', $id)
                                ->where('pre_production_material_delivery_id', $delivery_id)
                                ->where('pre_production_material_delivery_details_id', $detailsId)
                                ->where('barcode', $itemCode)
                                ->first();
                            if($item){
                                $item->received = PreProductionMaterialDeliveryDetailsItems::RECEIVED_YES;
                                $item->save();

                                $material = PreProductionMaterial::find($item->pre_production_material_id);
                                $material->received_qty = $material->received_qty + 1;
                                $material->save();

                                $item_details = PreProductionMaterialDeliveryDetails::find($item->pre_production_material_delivery_details_id);
                                $item_details->received_qty = $item_details->received_qty + 1;
                                $item_details->save();

                                if($material->received_qty == 0){
                                    $material->received_status = PreProductionMaterial::RECEIVED_STATUS_PENDING;
                                    $material->save();
                                }else if($material->received_qty != $material->quantity){
                                    $material->received_status = PreProductionMaterial::RECEIVED_STATUS_PARTIAL;
                                    $material->save();
                                }else{
                                    $material->received_status = PreProductionMaterial::RECEIVED_STATUS_DELIVERED;
                                    $material->save();
                                }
                            }
                        }

                        $item_count= PreProductionMaterialDeliveryDetailsItems::where('received', PreProductionMaterialDeliveryDetailsItems::RECEIVED_NO)
                            ->where('pre_production_id', $id)
                            ->where('pre_production_material_delivery_id', $delivery_id)
                            ->where('pre_production_material_delivery_details_id', $detailsId)
                            ->count();
                        $details = PreProductionMaterialDeliveryDetails::find($detailsId);

                        if($item_count > 0){
                            $details->received_status = PreProductionMaterialDeliveryDetails::RECEIVED_STATUS_PARTIAL;
                            $details->save();
                        }else{
                            $details->received_status = PreProductionMaterialDeliveryDetails::RECEIVED_STATUS_DELIVERED;
                            $details->save();
                        }
                    }
                }

                $details_count = PreProductionMaterialDeliveryDetails::where('deleted', PreProductionMaterialDeliveryDetails::DELETED_NO)
                    ->where('status', PreProductionMaterialDeliveryDetails::STATUS_ACTIVE)
                    ->where('received_status','!=',PreProductionMaterialDeliveryDetails::RECEIVED_STATUS_DELIVERED)
                    ->where('pre_production_material_delivery_id', $delivery_id)
                    ->count();
                $delivery = PreProductionMaterialDelivery::find($delivery_id);

                if($details_count > 0){
                    $delivery->received_status = PreProductionMaterialDelivery::RECEIVED_STATUS_PARTIAL;
                    $delivery->save();
                }else{
                    $delivery->received_status = PreProductionMaterialDelivery::RECEIVED_STATUS_DELIVERED;
                    $delivery->save();
                }
            }

            $delivery_count= PreProductionMaterialDelivery::where('received_status', '!=' , PreProductionMaterialDelivery::RECEIVED_STATUS_DELIVERED)
                ->where('pre_production_id', $id)
                ->where('deleted', PreProductionMaterialDelivery::DELETED_NO)
                ->where('status', PreProductionMaterialDelivery::STATUS_ACTIVE)
                ->count();

            if($delivery_count > 0){
                $pre_production->received_status = PreProduction::RECEIVED_STATUS_PARTIAL;
                $pre_production->save();
            }else{
                $pre_production->received_status = PreProduction::RECEIVED_STATUS_DELIVERED;
                $pre_production->save();
            }
        
            // $data['deliveries'] = PreProductionMaterialDelivery::where('deleted', PreProductionMaterialDelivery::DELETED_NO)
            //     ->where('status', PreProductionMaterialDelivery::STATUS_ACTIVE)
            //     ->where('pre_production_id', $id)
            //     ->with(
            //         'delivery_details', 
            //         'delivery_details.material',
            //         'delivery_details.material.category',
            //         'delivery_details.material.product',
            //         'delivery_details.pending_items',
            //     )
            //     ->get();
            // return $data;

        }catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
        DB::commit();
    }

    public function getDeliveryData($id){
        $pre_production = PreProduction::where('deleted', PreProduction::DELETED_NO)
            ->where('id', $id)
            ->first();
        if(!$pre_production){
            throw new \Exception('Pre Production not found');
        }
        $data['deliveries'] = PreProductionMaterialDelivery::where('deleted', PreProductionMaterialDelivery::DELETED_NO)
            ->where('status', PreProductionMaterialDelivery::STATUS_ACTIVE)
            ->where('pre_production_id', $id)
            ->with(
                'delivery_details', 
                'delivery_details.material',
                'delivery_details.material.category',
                'delivery_details.material.product',
                'delivery_details.pending_items',
            )
            ->get();
        //$data['pre_production'] = $pre_production;
        return $data;
    }

    // dispatch
    public function dispatchData($id){
        $pre_production = PreProduction::where('deleted', PreProduction::DELETED_NO)
            ->where('id', $id)
            ->first();
        if(!$pre_production){
            throw new \Exception('Pre Production not found');
        }
        $data['pre_production'] = $pre_production;
        return $data;
    }

    public function dispatchStoreData($request, $id){
        DB::beginTransaction();
        try {
            $pre_production = PreProduction::where('deleted', PreProduction::DELETED_NO)
                ->where('status', PreProduction::STATUS_ACTIVE)
                ->where('id', $id)
                ->first();
            if(!$pre_production){
                throw new \Exception('Pre Production not found');
            }

            if($request->pre_production_no != $pre_production->pre_production_no){
                throw new \Exception('Invalid QR Code!');
            }

            if($request->dispatched_qty > ($pre_production->estimated_production_qty - $pre_production->dispatched_qty) || $request->dispatched_qty == 0){
                throw new \Exception('Invalid Quantity!');
            }
            
            $pre_production->dispatched_qty += $request->dispatched_qty;
            $pre_production->updated_by = auth()->user()->id;
            $pre_production->updated_at = now();
            $pre_production->save();

            if($pre_production->estimated_production_qty - $pre_production->dispatched_qty > 0){
                $pre_production->dispatched_status = PreProduction::DISPATCH_STATUS_PARTIAL;
            }else{
                $pre_production->dispatched_status = PreProduction::DISPATCH_STATUS_DISPATCHED;
            }
            $pre_production->save();

            $dispatch = new ProductionDispatch();
            $dispatch->dispatch_no = '';
            $dispatch->pre_production_no = $pre_production->pre_production_no;
            $dispatch->pre_production_id = $pre_production->id;
            $dispatch->finished_goods_id = $pre_production->finished_goods_id;
            $dispatch->dispatched_qty = $request->dispatched_qty;
            $dispatch->dispatched_by = auth()->user()->id;
            $dispatch->dispatched_at = now();
            $dispatch->created_by = auth()->user()->id;
            $dispatch->created_at = now();
            $dispatch->updated_by = auth()->user()->id;
            $dispatch->updated_at = now();
            $dispatch->save();
            $dispatch->dispatch_no = 1000 + $dispatch->id;
            $dispatch->save();

        }catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
        DB::commit();
    }
}
