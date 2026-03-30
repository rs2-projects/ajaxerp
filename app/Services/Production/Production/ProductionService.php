<?php

namespace App\Services\Production\Production;

use App\Models\Machine;
use App\Models\Production\PreProduction;
use App\Models\Production\PreProductionBoard;
use App\Models\Production\PreProductionBoardDelivery;
use App\Models\Production\PreProductionBoardDeliveryDetails;
use App\Models\Production\PreProductionBoardDeliveryDetailsItem;
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
    public $paginate_limit;

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
            ->where('type', PreProduction::TYPE_OTHERS)
            ->where(function ($q) use ($keyword_filtered){
                if ($keyword_filtered !=''){
                    $q->whereHas('finishedGoods', function ($finishedGoodsQuery) use ($keyword_filtered) {
                        $finishedGoodsQuery->where('name', 'like', '%' . $keyword_filtered . '%');
                    })->orWhere('pre_production_no', 'like', '%'.$keyword_filtered.'%');
                }
            })
            ->orderBy('id', 'desc')->paginate($this->paginate_limit);

        $data['view'] = view('production.production._index_filtered', $data)->render();
        return $data;
    }

    public function getPendingPreProductions($request){
        $keyword_filtered = $request->keyword_filtered??null;
        $data['pre_productions'] = PreProduction::where('deleted', PreProduction::DELETED_NO)
            ->where('is_verified', PreProduction::VERIFIED_YES)
            ->where('process_status', PreProduction::PROCESS_STATUS_PENDING)
            ->where('type', PreProduction::TYPE_OTHERS)
            ->where(function ($q) use ($keyword_filtered){
                if ($keyword_filtered !=''){
                    $q->whereHas('finishedGoods', function ($finishedGoodsQuery) use ($keyword_filtered) {
                        $finishedGoodsQuery->where('name', 'like', '%' . $keyword_filtered . '%');
                    })->orWhere('pre_production_no', 'like', '%'.$keyword_filtered.'%');
                }
            })
            ->orderBy('id', 'desc')->paginate($this->paginate_limit);

        $data['view'] = view('production.production._index_filtered', $data)->render();
        return $data;
    }

    public function getPendingForReceivePreProductions($request){
        $keyword_filtered = $request->keyword_filtered ?? null;
        $data['pre_productions'] = PreProduction::with('pendingPreProductionMaterialDeliveries', 'pendingPreProductionBoardDeliveries')
            ->where('deleted', PreProduction::DELETED_NO)
            ->where('is_verified', PreProduction::VERIFIED_YES)
            ->where('type', PreProduction::TYPE_OTHERS)
            ->where(function ($q) use ($keyword_filtered) {
                if ($keyword_filtered != '') {
                    $q->whereHas('finishedGoods', function ($finishedGoodsQuery) use ($keyword_filtered) {
                        $finishedGoodsQuery->where('name', 'like', '%' . $keyword_filtered . '%');
                    })->orWhere('pre_production_no', 'like', '%' . $keyword_filtered . '%');
                }
            })
            ->where(function ($q) {
                $q->has('pendingPreProductionMaterialDeliveries')
                  ->orHas('pendingPreProductionBoardDeliveries');
            })
            // ->has('pendingPreProductionMaterialDeliveries')
            ->orderBy('id', 'desc')->paginate($this->paginate_limit);
        
        $data['view'] = view('production.production._pending_for_receive_filtered', $data)->render();
        return $data;
    }

    public function getPartialPreProductions($request){
        $keyword_filtered = $request->keyword_filtered??null;
        $data['pre_productions'] = PreProduction::where('deleted', PreProduction::DELETED_NO)
            ->where('is_verified', PreProduction::VERIFIED_YES)
            ->where('process_status', PreProduction::PROCESS_STATUS_PROCESSING)
            ->where('type', PreProduction::TYPE_OTHERS)
            ->where(function ($q) use ($keyword_filtered){
                if ($keyword_filtered !=''){
                    $q->whereHas('finishedGoods', function ($finishedGoodsQuery) use ($keyword_filtered) {
                        $finishedGoodsQuery->where('name', 'like', '%' . $keyword_filtered . '%');
                    })->orWhere('pre_production_no', 'like', '%'.$keyword_filtered.'%');
                }
            })
            ->orderBy('id', 'desc')->paginate($this->paginate_limit);

        $data['view'] = view('production.production._on_process_filtered', $data)->render();
        return $data;
    }

    public function getDeliveredPreProductions($request){
        $keyword_filtered = $request->keyword_filtered??null;
        $data['pre_productions'] = PreProduction::where('deleted', PreProduction::DELETED_NO)
            ->where('is_verified', PreProduction::VERIFIED_YES)
            ->where('process_status', PreProduction::PROCESS_STATUS_COMPLETED)
            ->where('type', PreProduction::TYPE_OTHERS)
            ->where(function ($q) use ($keyword_filtered){
                if ($keyword_filtered !=''){
                    $q->whereHas('finishedGoods', function ($finishedGoodsQuery) use ($keyword_filtered) {
                        $finishedGoodsQuery->where('name', 'like', '%' . $keyword_filtered . '%');
                    })->orWhere('pre_production_no', 'like', '%'.$keyword_filtered.'%');
                }
            })
            ->orderBy('id', 'desc')->paginate($this->paginate_limit);

        $data['view'] = view('production.production._completed_filtered', $data)->render();
        return $data;
    }

    public function getDispatchedPreProductions($request){
        $keyword_filtered = $request->keyword_filtered??null;
        $data['pre_productions'] = PreProduction::where('deleted', PreProduction::DELETED_NO)
            ->where('is_verified', PreProduction::VERIFIED_YES)
            ->where('dispatched_status', PreProduction::DISPATCH_STATUS_DISPATCHED)
            ->where('type', PreProduction::TYPE_OTHERS)
            ->where(function ($q) use ($keyword_filtered){
                if ($keyword_filtered !=''){
                    $q->whereHas('finishedGoods', function ($finishedGoodsQuery) use ($keyword_filtered) {
                        $finishedGoodsQuery->where('name', 'like', '%' . $keyword_filtered . '%');
                    })->orWhere('pre_production_no', 'like', '%'.$keyword_filtered.'%');
                }
            })
            ->orderBy('id', 'desc')->paginate($this->paginate_limit);

        $data['view'] = view('production.production._dispatched_filtered', $data)->render();
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

                if($pre_production->scan_status != PreProduction::SCAN_STATUS_SCANNED){
                    throw new \Exception('All Production Materials not scanned!');
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
            ->where('status', PreProduction::STATUS_ACTIVE)
            ->where('type', PreProduction::TYPE_OTHERS)
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

        if($request->type == 'other'){
            $valid_code = PreProductionMaterialDeliveryDetailsItems::where('received', PreProductionMaterialDeliveryDetailsItems::RECEIVED_NO)
                ->where('pre_production_id', $id)
                ->where('pre_production_material_delivery_id', $request->delivery_id)
                ->where('pre_production_material_delivery_details_id', $request->delivery_details_id)
                ->where('barcode', $request->barcode)
                ->get();
        }else{
            $valid_code = PreProductionBoardDeliveryDetailsItem::where('received', PreProductionBoardDeliveryDetailsItem::RECEIVED_NO)
                ->where('pre_production_id', $id)
                ->where('pre_production_board_delivery_id', $request->delivery_id)
                ->where('pre_production_board_delivery_details_id', $request->delivery_details_id)
                ->where('barcode', $request->barcode)
                ->get();
        }

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
            // dd($request->all());
            $pre_production = PreProduction::where('deleted', PreProduction::DELETED_NO)
                ->where('status', PreProduction::STATUS_ACTIVE)
                ->where('type', PreProduction::TYPE_OTHERS)
                ->where('id', $id)
                ->first();
            if(!$pre_production){
                throw new \Exception('Pre Production not found');
            }

            $delivery_id = $request->pre_production_material_delivery_id;
            $type = $request->type;
            $delivery_model = ($type === 'board') ? PreProductionBoardDelivery::class : PreProductionMaterialDelivery::class;

            $delivery = $delivery_model::where('deleted', $delivery_model::DELETED_NO)
                ->where('pre_production_id', $id)
                ->where('id', $delivery_id)
                ->where('status', $delivery_model::STATUS_ACTIVE)
                ->first();

            if(!$delivery){
                throw new \Exception('Pre Production Delivery not found');
            }

            if (isset($request->pre_production_material_delivery_details_id) && is_array($request->pre_production_material_delivery_details_id) && count($request->pre_production_material_delivery_details_id) > 0) {
                foreach($request->pre_production_material_delivery_details_id as $detailsKey => $detailsId){
                    $item_model = ($type === 'board') ? PreProductionBoardDeliveryDetailsItem::class : PreProductionMaterialDeliveryDetailsItems::class;
                    $material_model = ($type === 'board') ? PreProductionBoard::class : PreProductionMaterial::class;
                    $details_model = ($type === 'board') ? PreProductionBoardDeliveryDetails::class : PreProductionMaterialDeliveryDetails::class;
                    
                    
                    if ($detailsId == '') {
                        continue;
                    }

                    $delivery_details = $details_model::find($detailsId);

                    if (!$delivery_details) {
                        continue;
                    }

                    $material = $type === 'board'
                        ? $material_model::find($delivery_details->pre_production_board_id)
                        : $material_model::find($delivery_details->pre_production_material_id);

                    if (!$material) {
                        continue;
                    }

                    $material->received_qty += $delivery_details->quantity??0;
                    $material->save();
                    
                    $delivery_details->received_qty = $delivery_details->quantity??0;
                    $delivery_details->save();

                    $material->received_status =
                        $material->received_qty == 0
                            ? $material_model::RECEIVED_STATUS_PENDING
                            : ($material->received_qty != $material->quantity
                                ? $material_model::RECEIVED_STATUS_PARTIAL
                                : $material_model::RECEIVED_STATUS_DELIVERED);
                            
                    $delivery_details->received_status =
                        $delivery_details->received_qty == 0
                            ? $details_model::RECEIVED_STATUS_PENDING
                            : ($delivery_details->received_qty != $delivery_details->quantity
                                ? $details_model::RECEIVED_STATUS_PARTIAL
                                : $details_model::RECEIVED_STATUS_DELIVERED);

                    $material->save();
                    $delivery_details->save();
                }

                $pending_details = $details_model::where('deleted', $details_model::DELETED_NO)
                    ->where('status', $details_model::STATUS_ACTIVE)
                    ->where('received_status','!=',$details_model::RECEIVED_STATUS_DELIVERED)
                    ->where('pre_production_id', $id)
                    ->where(($type === 'board' ? 'pre_production_board_delivery_id' : 'pre_production_material_delivery_id'), $delivery_id)
                    ->count();

                $delivery->received_status = $pending_details > 0
                    ? $delivery_model::RECEIVED_STATUS_PARTIAL
                    : $delivery_model::RECEIVED_STATUS_DELIVERED;

                $delivery->save();
            }

            $other_delivery_count= PreProductionMaterialDelivery::where('received_status', '!=' , PreProductionMaterialDelivery::RECEIVED_STATUS_DELIVERED)
                ->where('pre_production_id', $id)
                ->where('deleted', PreProductionMaterialDelivery::DELETED_NO)
                ->where('status', PreProductionMaterialDelivery::STATUS_ACTIVE)
                ->count();

            $board_delivery_count= PreProductionBoardDelivery::where('received_status', '!=' , PreProductionBoardDelivery::RECEIVED_STATUS_DELIVERED)
                ->where('pre_production_id', $id)
                ->where('deleted', PreProductionBoardDelivery::DELETED_NO)
                ->where('status', PreProductionBoardDelivery::STATUS_ACTIVE)
                ->count();

            $pre_production->received_status = ($other_delivery_count === 0 && $board_delivery_count === 0)
                ? PreProduction::RECEIVED_STATUS_DELIVERED
                : PreProduction::RECEIVED_STATUS_PARTIAL;

            $pre_production->save();

        }catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
        DB::commit();
    }

    // public function receiveStoreData($request, $id){
    //     DB::beginTransaction();
    //     try {
    //         dd($request->all());
    //         $pre_production = PreProduction::where('deleted', PreProduction::DELETED_NO)
    //             ->where('status', PreProduction::STATUS_ACTIVE)
    //             ->where('type', PreProduction::TYPE_OTHERS)
    //             ->where('id', $id)
    //             ->first();
    //         if(!$pre_production){
    //             throw new \Exception('Pre Production not found');
    //         }

    //         $delivery_id = $request->pre_production_material_delivery_id;
    //         $type = $request->type;
    //         $item_model = ($type === 'board') ? PreProductionBoardDeliveryDetailsItem::class : PreProductionMaterialDeliveryDetailsItems::class;
    //         $material_model = ($type === 'board') ? PreProductionBoard::class : PreProductionMaterial::class;
    //         $details_model = ($type === 'board') ? PreProductionBoardDeliveryDetails::class : PreProductionMaterialDeliveryDetails::class;
    //         $delivery_model = ($type === 'board') ? PreProductionBoardDelivery::class : PreProductionMaterialDelivery::class;

    //         $delivery = $delivery_model::where('deleted', $delivery_model::DELETED_NO)
    //             ->where('pre_production_id', $id)
    //             ->where('id', $delivery_id)
    //             ->where('status', $delivery_model::STATUS_ACTIVE)
    //             ->first();

    //         if(!$delivery){
    //             throw new \Exception('Pre Production Delivery not found');
    //         }

    //         if (isset($request->pre_production_material_delivery_details_id) && is_array($request->pre_production_material_delivery_details_id) && count($request->pre_production_material_delivery_details_id) > 0) {
                
    //             foreach($request->pre_production_material_delivery_details_id as $detailsKey => $detailsId){
    //                 if($detailsId != '' && isset($request->code[$detailsKey]) && is_array($request->code[$detailsKey]) && $request->code[$detailsKey] > 0){
                        
    //                     foreach($request->code[$detailsKey] as $itemKey => $itemCode){
    //                         if($type == 'board'){
    //                             $item = PreProductionBoardDeliveryDetailsItem::where('received', PreProductionBoardDeliveryDetailsItem::RECEIVED_NO)
    //                                 ->where('pre_production_id', $id)
    //                                 ->where('pre_production_board_delivery_id', $delivery_id)
    //                                 ->where('pre_production_board_delivery_details_id', $detailsId)
    //                                 ->where('barcode', $itemCode)
    //                                 ->first();
    //                         }else{
    //                             $item = PreProductionMaterialDeliveryDetailsItems::where('received', PreProductionMaterialDeliveryDetailsItems::RECEIVED_NO)
    //                                 ->where('pre_production_id', $id)
    //                                 ->where('pre_production_material_delivery_id', $delivery_id)
    //                                 ->where('pre_production_material_delivery_details_id', $detailsId)
    //                                 ->where('barcode', $itemCode)
    //                                 ->first();
    //                         }
    //                         if($item){
    //                             $item->received = $item_model::RECEIVED_YES;
    //                             $item->save();
    //                             if($type == 'board'){
    //                                 $material = $material_model::find($item->pre_production_board_id);
    //                             }else{
    //                                 $material = $material_model::find($item->pre_production_material_id);
    //                             }
    //                             $material->received_qty = $material->received_qty + 1;
    //                             $material->save();

    //                             // update details table
    //                             if($type == 'board'){
    //                                 $item_details = $details_model::find($item->pre_production_board_delivery_details_id);
    //                             }else{
    //                                 $item_details = $details_model::find($item->pre_production_material_delivery_details_id);
    //                             }
    //                             $item_details->received_qty = $item_details->received_qty + 1;
    //                             $item_details->save();

    //                             if($material->received_qty == 0){
    //                                 $material->received_status = $material_model::RECEIVED_STATUS_PENDING;
    //                                 $material->save();
    //                             }else if($material->received_qty != $material->quantity){
    //                                 $material->received_status = $material_model::RECEIVED_STATUS_PARTIAL;
    //                                 $material->save();
    //                             }else{
    //                                 $material->received_status = $material_model::RECEIVED_STATUS_DELIVERED;
    //                                 $material->save();
    //                             }
    //                         }
    //                     }

    //                     if($type == 'board'){
    //                         $item_count = PreProductionBoardDeliveryDetailsItem::where('received', PreProductionBoardDeliveryDetailsItem::RECEIVED_NO)
    //                             ->where('pre_production_id', $id)
    //                             ->where('pre_production_board_delivery_id', $delivery_id)
    //                             ->where('pre_production_board_delivery_details_id', $detailsId)
    //                             ->where('barcode', $itemCode)
    //                             ->count();
    //                     }else{
    //                         $item_count = PreProductionMaterialDeliveryDetailsItems::where('received', PreProductionMaterialDeliveryDetailsItems::RECEIVED_NO)
    //                             ->where('pre_production_id', $id)
    //                             ->where('pre_production_material_delivery_id', $delivery_id)
    //                             ->where('pre_production_material_delivery_details_id', $detailsId)
    //                             ->where('barcode', $itemCode)
    //                             ->count();
    //                     }
                        
    //                     $details = $details_model::find($detailsId);

    //                     if($item_count > 0){
    //                         $details->received_status = $details_model::RECEIVED_STATUS_PARTIAL;
    //                         $details->save();
    //                     }else{
    //                         $details->received_status = $details_model::RECEIVED_STATUS_DELIVERED;
    //                         $details->save();
    //                     }
    //                 }
    //             }

    //             if($type == 'board'){
    //                 $details_count = $details_model::where('deleted', $details_model::DELETED_NO)
    //                     ->where('status', $details_model::STATUS_ACTIVE)
    //                     ->where('received_status','!=',$details_model::RECEIVED_STATUS_DELIVERED)
    //                     ->where('pre_production_id', $id)
    //                     ->where('pre_production_board_delivery_id', $delivery_id)
    //                     ->count();
                    
    //                 // $processing_count = $details_model::where('pre_production_board_delivery_id', $delivery_id)
    //                 //     ->where('pre_production_id', $id)
    //                 //     ->where('received_status', $details_model::RECEIVED_STATUS_PARTIAL)
    //                 //     ->exists();
                    
    //             }else{
    //                 $details_count = $details_model::where('deleted', $details_model::DELETED_NO)
    //                     ->where('status', $details_model::STATUS_ACTIVE)
    //                     ->where('received_status','!=',$details_model::RECEIVED_STATUS_DELIVERED)
    //                     ->where('pre_production_id', $id)
    //                     ->where('pre_production_material_delivery_id', $delivery_id)
    //                     ->count();

    //                 // $processing_count = $details_model::where('pre_production_material_delivery_id', $delivery_id)
    //                 //     ->where('received_status', $details_model::RECEIVED_STATUS_PARTIAL)
    //                 //     ->where('pre_production_id', $id)
    //                 //     ->exists();
    //             }
    //             $delivery = $delivery_model::find($delivery_id);

    //             if($details_count == 0){
    //                 $delivery->received_status = $delivery_model::RECEIVED_STATUS_DELIVERED;
    //             }else{
    //                 $delivery->received_status = $delivery_model::RECEIVED_STATUS_PARTIAL;
    //             }

    //             $delivery->save();
    //         }

    //         $other_delivery_count= PreProductionMaterialDelivery::where('received_status', '!=' , PreProductionMaterialDelivery::RECEIVED_STATUS_DELIVERED)
    //             ->where('pre_production_id', $id)
    //             ->where('deleted', PreProductionMaterialDelivery::DELETED_NO)
    //             ->where('status', PreProductionMaterialDelivery::STATUS_ACTIVE)
    //             ->count();

    //         // $other_delivery_processing = PreProductionMaterialDelivery::where('pre_production_id', $id)
    //         //     ->where('received_status', PreProductionMaterialDelivery::RECEIVED_STATUS_PARTIAL)
    //         //     ->where('deleted', PreProductionMaterialDelivery::DELETED_NO)
    //         //     ->where('status', PreProductionMaterialDelivery::STATUS_ACTIVE)
    //         //     ->exists();

    //         $board_delivery_count= PreProductionBoardDelivery::where('received_status', '!=' , PreProductionBoardDelivery::RECEIVED_STATUS_DELIVERED)
    //             ->where('pre_production_id', $id)
    //             ->where('deleted', PreProductionBoardDelivery::DELETED_NO)
    //             ->where('status', PreProductionBoardDelivery::STATUS_ACTIVE)
    //             ->count();

    //         // $board_delivery_processing = PreProductionBoardDelivery::where('pre_production_id', $id)
    //         //     ->where('received_status', PreProductionBoardDelivery::RECEIVED_STATUS_PARTIAL)
    //         //     ->where('deleted', PreProductionBoardDelivery::DELETED_NO)
    //         //     ->where('status', PreProductionBoardDelivery::STATUS_ACTIVE)
    //         //     ->exists();

    //         // if($other_delivery_count == 0 && $board_delivery_count){
    //         //     $pre_production->received_status = PreProduction::RECEIVED_STATUS_DELIVERED;
    //         // }else if($other_delivery_processing || $board_delivery_processing){
    //         //     $pre_production->received_status = PreProduction::RECEIVED_STATUS_PARTIAL;
    //         // }
            
    //         if ($other_delivery_count == 0 && $board_delivery_count == 0) {
    //             $pre_production->received_status = PreProduction::RECEIVED_STATUS_DELIVERED;
    //         } else {
    //             $pre_production->received_status = PreProduction::RECEIVED_STATUS_PARTIAL;
    //         }

    //         $pre_production->save();

    //     }catch (\Exception $e) {
    //         DB::rollBack();
    //         throw new \Exception($e->getMessage());
    //     }
    //     DB::commit();
    // }

    public function getDeliveryData($id){
        $pre_production = PreProduction::where('deleted', PreProduction::DELETED_NO)
            ->where('status', PreProduction::STATUS_ACTIVE)
            ->where('type', PreProduction::TYPE_OTHERS)
            ->where('id', $id)
            ->first();
        if(!$pre_production){
            throw new \Exception('Pre Production not found');
        }

        $material_deliveries= PreProductionMaterialDelivery::where('deleted', PreProductionMaterialDelivery::DELETED_NO)
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

        $board_deliveries= PreProductionBoardDelivery::where('deleted', PreProductionBoardDelivery::DELETED_NO)
            ->where('status', PreProductionBoardDelivery::STATUS_ACTIVE)
            ->where('pre_production_id', $id)
            ->with(
                'board_delivery_details', 
                'board_delivery_details.board',
                'board_delivery_details.board.category',
                'board_delivery_details.board.product',
                'board_delivery_details.pending_items',
            )
            ->get();

        $deliveredMaterials = $material_deliveries->map(function ($delivery) {
            return [
                'type' => 'other',
                'delivery' => $delivery
            ];
        });

        $deliveredBoards = $board_deliveries->map(function ($board_delivery) {
            return [
                'type' => 'board',
                'delivery' => $board_delivery
            ];
        });

        $data['deliveries'] = $deliveredMaterials->concat($deliveredBoards)->toArray();
        return $data;
    }

    // dispatch
    public function dispatchData($id){
        $pre_production = PreProduction::where('deleted', PreProduction::DELETED_NO)
            ->where('status', PreProduction::STATUS_ACTIVE)
            ->where('type', PreProduction::TYPE_OTHERS)
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

            $finishedGoods = $pre_production->finishedGoods;
            $finishedGoods->total_finished_qty += $request->dispatched_qty;
            $finishedGoods->available_qty += $request->dispatched_qty;
            $finishedGoods->save();

        }catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
        DB::commit();
    }

    public function monitoringPerDayData() {
        $data = [];
        $data['productions'] = PreProduction::where('deleted', PreProduction::DELETED_NO)
            ->where('status', PreProduction::STATUS_ACTIVE)
            ->where('process_status', PreProduction::PROCESS_STATUS_PROCESSING)
            ->where('type', PreProduction::TYPE_OTHERS)
            ->orderBy('id', 'asc')
            ->get();

        $data['machines'] = Machine::where('deleted', Machine::DELETED_NO)
            ->where('status', Machine::STATUS_ACTIVE)
            ->orderBy('id', 'asc')
            ->get();
            

        return $data;
    }

    // public function printBarcodeData($id, $type){
    //     try {

    //         $production = PreProduction::where('deleted', PreProduction::DELETED_NO)
    //             ->where('status', PreProduction::STATUS_ACTIVE)
    //             ->where('id', $id)
    //             ->first();
    //         if (empty($production)) {
    //             return redirect()->back()->with(['failed' => 'Invalid Production!']);
    //         }

    //         $code_generator = new BarcodeGeneratorPNG();
    //         if($type == 'printer'){
    //             return view('print-barcode-printer', compact(
    //                 'code_generator',
    //                 'production'
    //             ));
    //         }
    //         $pdf = PDF::loadView('print-barcode-pdf', compact(
    //             'code_generator',
    //             'production'
    //         ));
    //         $pdf->setPaper('a4');
    //         $pdf->setOrientation('portrait');
    //         // $footer_text = CommonHelper::getInvoiceFooterText('');
    //         $pdf->setOption('footer-html', "hello");
    //         return $pdf->inline();

    //     } catch (\Exception $exception) {
    //         return redirect()->back()->with(['failed' => $exception->getMessage()]);
    //     }
    // }
}
