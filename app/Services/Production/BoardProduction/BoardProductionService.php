<?php

namespace App\Services\Production\BoardProduction;

use App\Models\Machine;
use App\Models\Production\PreProduction;
use App\Models\Production\PreProductionMaterial;
use App\Models\Production\PreProductionMaterialDelivery;
use App\Models\Production\PreProductionMaterialDeliveryDetails;
use App\Models\Production\PreProductionMaterialDeliveryDetailsItems;
use App\Models\Production\PreProductionProcess;
use App\Models\Production\PreProductionProcessMachine;
use App\Models\Production\PreProductionProcessMaterial;
use App\Models\Production\ProductionDispatch;
use App\Models\Production\ProductionStaff;
use App\Models\Products\BoardEmbossed;
use App\Models\Products\FinishedGoods;
use App\Models\Products\ProductMaterial;
use Illuminate\Support\Facades\DB;

class BoardProductionService
{
    private $paginate_limit;
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
            ->where('type', PreProduction::TYPE_BOARD)
            ->where(function ($q) use ($keyword_filtered){
                if ($keyword_filtered !=''){
                    $q->whereHas('finishedGoods', function ($finishedGoodsQuery) use ($keyword_filtered) {
                        $finishedGoodsQuery->where('name', 'like', '%' . $keyword_filtered . '%');
                    })->orWhere('pre_production_no', 'like', '%'.$keyword_filtered.'%');
                }
            })
            ->orderBy('id', 'desc')->paginate($this->paginate_limit);

        $data['view'] = view('production.board-production._index_filtered', $data)->render();
        return $data;
    }

    public function getPendingPreProductions($request){
        $keyword_filtered = $request->keyword_filtered??null;
        $data['pre_productions'] = PreProduction::where('deleted', PreProduction::DELETED_NO)
            ->where('is_verified', PreProduction::VERIFIED_YES)
            ->where('process_status', PreProduction::PROCESS_STATUS_PENDING)
            ->where('type', PreProduction::TYPE_BOARD)
            ->where(function ($q) use ($keyword_filtered){
                if ($keyword_filtered !=''){
                    $q->whereHas('finishedGoods', function ($finishedGoodsQuery) use ($keyword_filtered) {
                        $finishedGoodsQuery->where('name', 'like', '%' . $keyword_filtered . '%');
                    })->orWhere('pre_production_no', 'like', '%'.$keyword_filtered.'%');
                }
            })
            ->orderBy('id', 'desc')->paginate($this->paginate_limit);

        $data['view'] = view('production.board-production._index_filtered', $data)->render();
        return $data;
    }

    public function getPendingForReceivePreProductions($request){
        $keyword_filtered = $request->keyword_filtered ?? null;
        $data['pre_productions'] = PreProduction::with('pendingPreProductionMaterialDeliveries')
            ->where('deleted', PreProduction::DELETED_NO)
            ->where('is_verified', PreProduction::VERIFIED_YES)
            ->where('type', PreProduction::TYPE_BOARD)
            ->where(function ($q) use ($keyword_filtered) {
                if ($keyword_filtered != '') {
                    $q->whereHas('finishedGoods', function ($finishedGoodsQuery) use ($keyword_filtered) {
                        $finishedGoodsQuery->where('name', 'like', '%' . $keyword_filtered . '%');
                    })->orWhere('pre_production_no', 'like', '%' . $keyword_filtered . '%');
                }
            })
            ->has('pendingPreProductionMaterialDeliveries')
            ->orderBy('id', 'desc')->paginate($this->paginate_limit);

        $data['view'] = view('production.board-production._pending_for_receive_filtered', $data)->render();
        return $data;
    }

    public function getPartialPreProductions($request){
        $keyword_filtered = $request->keyword_filtered??null;
        $data['pre_productions'] = PreProduction::where('deleted', PreProduction::DELETED_NO)
            ->where('is_verified', PreProduction::VERIFIED_YES)
            ->where('process_status', PreProduction::PROCESS_STATUS_PROCESSING)
            ->where('type', PreProduction::TYPE_BOARD)
            ->where(function ($q) use ($keyword_filtered){
                if ($keyword_filtered !=''){
                    $q->whereHas('finishedGoods', function ($finishedGoodsQuery) use ($keyword_filtered) {
                        $finishedGoodsQuery->where('name', 'like', '%' . $keyword_filtered . '%');
                    })->orWhere('pre_production_no', 'like', '%'.$keyword_filtered.'%');
                }
            })
            ->orderBy('id', 'desc')->paginate($this->paginate_limit);

        $data['view'] = view('production.board-production._on_process_filtered', $data)->render();
        return $data;
    }

    public function getDeliveredPreProductions($request){
        $keyword_filtered = $request->keyword_filtered??null;
        $data['pre_productions'] = PreProduction::where('deleted', PreProduction::DELETED_NO)
            ->where('is_verified', PreProduction::VERIFIED_YES)
            ->where('process_status', PreProduction::PROCESS_STATUS_COMPLETED)
            ->where('type', PreProduction::TYPE_BOARD)
            ->where(function ($q) use ($keyword_filtered){
                if ($keyword_filtered !=''){
                    $q->whereHas('finishedGoods', function ($finishedGoodsQuery) use ($keyword_filtered) {
                        $finishedGoodsQuery->where('name', 'like', '%' . $keyword_filtered . '%');
                    })->orWhere('pre_production_no', 'like', '%'.$keyword_filtered.'%');
                }
            })
            ->orderBy('id', 'desc')->paginate($this->paginate_limit);

        $data['view'] = view('production.board-production._completed_filtered', $data)->render();
        return $data;
    }

    public function getDispatchedPreProductions($request){
        $keyword_filtered = $request->keyword_filtered??null;
        $data['pre_productions'] = PreProduction::where('deleted', PreProduction::DELETED_NO)
            ->where('is_verified', PreProduction::VERIFIED_YES)
            ->where('dispatched_status', PreProduction::DISPATCH_STATUS_DISPATCHED)
            ->where('type', PreProduction::TYPE_BOARD)
            ->where(function ($q) use ($keyword_filtered){
                if ($keyword_filtered !=''){
                    $q->whereHas('finishedGoods', function ($finishedGoodsQuery) use ($keyword_filtered) {
                        $finishedGoodsQuery->where('name', 'like', '%' . $keyword_filtered . '%');
                    })->orWhere('pre_production_no', 'like', '%'.$keyword_filtered.'%');
                }
            })
            ->orderBy('id', 'desc')->paginate($this->paginate_limit);

        $data['view'] = view('production.board-production._dispatched_filtered', $data)->render();
        return $data;
    }

    // not in use
    // public function editData($id){
    //     $pre_production = PreProduction::where('id', $id)
    //         ->where('deleted', PreProduction::DELETED_NO)
    //         ->where('status', PreProduction::STATUS_ACTIVE)
    //         ->where('type', PreProduction::TYPE_BOARD)
    //         ->where('is_verified', PreProduction::VERIFIED_REVISION)
    //         ->first();

    //     if(!$pre_production){
    //         throw new \Exception("Board Production not found");
    //     }
    //     $data['pre_production'] = $pre_production;

    //     $data['board'] = FinishedGoods::where('deleted', FinishedGoods::DELETED_NO)
    //         ->where('status', FinishedGoods::STATUS_ACTIVE)
    //         ->where('type', FinishedGoods::TYPE_BOARD)
    //         ->where('id',$pre_production->finished_goods_id)
    //         ->first();

    //     $data['machines'] = Machine::where('deleted', Machine::DELETED_NO)
    //         ->where('status', Machine::STATUS_ACTIVE)
    //         ->orderBy('id', 'desc')
    //         ->get();

    //     $process = PreProductionProcess::where('pre_production_id', $pre_production->id)
    //         ->where('deleted', PreProductionProcess::DELETED_NO)
    //         ->where('status', PreProductionProcess::STATUS_ACTIVE)
    //         ->first();

    //     $data['process'] = $process;

    //     $data['process_machine'] = PreProductionProcessMachine::where('pre_production_id', $pre_production->id)
    //         ->where('pre_production_process_id', $process->id)
    //         ->first();

    //     $data['finished_products'] = FinishedGoods::where('deleted', FinishedGoods::DELETED_NO)
    //         ->where('status', FinishedGoods::STATUS_ACTIVE)
    //         ->where('type', FinishedGoods::TYPE_BOARD)
    //         ->orderBy('id', 'desc')
    //         ->get();

    //     $data['staffs'] = ProductionStaff::where('deleted', ProductionStaff::DELETED_NO)
    //         ->where('status', ProductionStaff::STATUS_ACTIVE)
    //         ->orderBy('id', 'desc')
    //         ->get();

    //     $data['boards'] = ProductMaterial::where('deleted', ProductMaterial::DELETED_NO)
    //         ->where('status', ProductMaterial::STATUS_ACTIVE)
    //         ->where('type', ProductMaterial::TYPE_BOARD)
    //         ->orderBy('name', 'asc')
    //         ->get();

    //     $data['plates'] = BoardEmbossed::where('deleted', BoardEmbossed::DELETED_NO)
    //         ->where('status', BoardEmbossed::STATUS_ACTIVE)
    //         ->orderBy('name', 'asc')
    //         ->get();

    //     $data['papers'] = ProductMaterial::where('deleted', ProductMaterial::DELETED_NO)
    //         ->where('status', ProductMaterial::STATUS_ACTIVE)
    //         ->where('type', ProductMaterial::TYPE_PAPER)
    //         ->orderBy('name', 'asc')
    //         ->get();

    //     $data['raw_board_id'] = PreProductionProcessMaterial::where('pre_production_id', $pre_production->id)
    //         ->where('type', PreProductionProcessMaterial::TYPE_RAW_BOARD)
    //         ->first();

    //     $data['paper_up_id'] = PreProductionProcessMaterial::where('pre_production_id', $pre_production->id)
    //         ->where('type', PreProductionProcessMaterial::TYPE_PAPER_UP)
    //         ->first();

    //     $data['paper_down_id'] = PreProductionProcessMaterial::where('pre_production_id', $pre_production->id)
    //         ->where('type', PreProductionProcessMaterial::TYPE_PAPER_DOWN)
    //         ->first();

    //     return $data;
    // }

    public function pendingVerificationData($request)
    {

        $keyword_filtered = $request->keyword_filtered ?? null;
        $verification_status = $request->status_filtered;
        $query = PreProduction::where('deleted', PreProduction::DELETED_NO)
            ->where('status', PreProduction::STATUS_ACTIVE)
            ->where('type', PreProduction::TYPE_BOARD);

        if ($verification_status == 'pending') {
            $query->where('is_verified', PreProduction::VERIFIED_NO);
        } elseif ($verification_status == 'rejected') {
            $query->where('is_verified', PreProduction::VERIFIED_REJECTED);
        }

        $query->where(function ($q) use ($keyword_filtered) {
            if ($keyword_filtered != '') {
                $q->whereHas('finishedGoods', function ($finishedGoodsQuery) use ($keyword_filtered) {
                    $finishedGoodsQuery->where('name', 'like', '%' . $keyword_filtered . '%');
                })->orWhere('pre_production_no', 'like', '%' . $keyword_filtered . '%');
            }
        });
        $data['verification_status'] = $verification_status;
        $data['pre_productions'] = $query->orderBy('id', 'desc')->paginate($this->paginate_limit);
        $data['view'] = view('production.pending-board-production._index_filtered', $data)->render();

        return $data;
    }


    public function detailsData($id){
        $pre_production = PreProduction::where('deleted', PreProduction::DELETED_NO)
            ->where('status', PreProduction::STATUS_ACTIVE)
            ->where('type', PreProduction::TYPE_BOARD)
            ->where('id', $id)
            ->first();
        if(!$pre_production){
            throw new \Exception('Pre Production not found');
        }
        $data['pre_production'] = $pre_production;
        $data['p_machine'] = PreProductionProcessMachine::where('pre_production_id', $pre_production->id)
            ->first();
        $data['board_process'] = PreProductionProcess::where('pre_production_id', $pre_production->id)
            ->where('deleted', PreProductionProcess::DELETED_NO)
            ->where('status', PreProductionProcess::STATUS_ACTIVE)
            ->first();
        return $data;
    }

    public function pendingDetailsData($id){
        $pre_production = PreProduction::where('deleted', PreProduction::DELETED_NO)
            ->where('status', PreProduction::STATUS_ACTIVE)
            ->where('type', PreProduction::TYPE_BOARD)
            ->where('id', $id)
            ->first();
        if(!$pre_production){
            throw new \Exception('Pre Production not found');
        }
        $data['pre_production'] = $pre_production;
        $data['p_machine'] = PreProductionProcessMachine::where('pre_production_id', $pre_production->id)
            ->first();
        $data['board_process'] = PreProductionProcess::where('pre_production_id', $pre_production->id)
            ->where('deleted', PreProductionProcess::DELETED_NO)
            ->where('status', PreProductionProcess::STATUS_ACTIVE)
            ->first();
        return $data;
    }

    public function verificationStatusUpdate($id, $status, $rejectReason = null)
    {
        try {
            $pre_production = PreProduction::where('id', $id)
                ->where('deleted', PreProduction::DELETED_NO)
                ->first();
            if (!$pre_production) {
                throw new \Exception('Pre Production not found');
            }

            $status = (int)$status;
            $rejectReason = is_string($rejectReason) ? trim($rejectReason) : null;
            $pre_production->is_verified = $status;
            $pre_production->reject_reason = $status === PreProduction::VERIFIED_REJECTED ? $rejectReason : null;
            $pre_production->updated_by = auth()->user()->id;
            $pre_production->updated_at = now();
            $pre_production->save();

            $data['status'] = $status;
            return $data;

        }catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function statusUpdateData($id, $processId, $status)
    {
        DB::beginTransaction();
        try {
            $pre_production = PreProduction::where('id', $id)
                ->where('deleted', PreProduction::DELETED_NO)
                ->where('status', PreProduction::STATUS_ACTIVE)
                ->where('type', PreProduction::TYPE_BOARD)
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
            ->where('type', PreProduction::TYPE_BOARD)
            ->where('status', PreProduction::STATUS_ACTIVE)
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

    public function receiveStoreData($request, $id)
    {
        DB::beginTransaction();

        try {
            $pre_production = PreProduction::where('deleted', PreProduction::DELETED_NO)
                ->where('status', PreProduction::STATUS_ACTIVE)
                ->where('type', PreProduction::TYPE_BOARD)
                ->where('id', $id)
                ->first();

            if (!$pre_production) {
                throw new \Exception('Pre Production not found');
            }

            $delivery_id = $request->pre_production_material_delivery_id;

            $delivery = PreProductionMaterialDelivery::where('deleted', PreProductionMaterialDelivery::DELETED_NO)
                ->where('id', $delivery_id)
                ->where('status', PreProductionMaterialDelivery::STATUS_ACTIVE)
                ->first();

            if (!$delivery) {
                throw new \Exception('Pre Production Delivery not found');
            }

            if (!empty($request->pre_production_material_delivery_details_id) && is_array($request->pre_production_material_delivery_details_id)) {
                foreach ($request->pre_production_material_delivery_details_id as $detailsId) {
                    if ($detailsId == '') {
                        continue;
                    }
                    
                    $delivery_details = PreProductionMaterialDeliveryDetails::where('deleted', PreProductionMaterialDeliveryDetails::DELETED_NO)
                        ->where('status', PreProductionMaterialDeliveryDetails::STATUS_ACTIVE)
                        ->where('received_status', '!=', PreProductionMaterialDeliveryDetails::RECEIVED_STATUS_DELIVERED)
                        ->where('pre_production_material_delivery_id', $delivery->id)
                        ->where('id', $detailsId)
                        ->first();

                    if (!$delivery_details) {
                        continue;
                    }

                    $material = PreProductionMaterial::find($delivery_details->pre_production_material_id);
                    if (!$material) {
                        continue;
                    }

                    $material->received_qty = $material->delivered_qty??0;
                    $delivery_details->received_qty = $delivery_details->quantity??0;
                    $material->save();
                    $delivery_details->save();

                    $material->received_status =
                        $material->received_qty == 0
                            ? PreProductionMaterial::RECEIVED_STATUS_PENDING
                            : ($material->received_qty != $material->quantity
                                ? PreProductionMaterial::RECEIVED_STATUS_PARTIAL
                                : PreProductionMaterial::RECEIVED_STATUS_DELIVERED);

                    $delivery_details->received_status =
                        $delivery_details->received_qty == 0
                            ? PreProductionMaterialDeliveryDetails::RECEIVED_STATUS_PENDING
                            : ($delivery_details->received_qty != $delivery_details->quantity
                                ? PreProductionMaterialDeliveryDetails::RECEIVED_STATUS_PARTIAL
                                : PreProductionMaterialDeliveryDetails::RECEIVED_STATUS_DELIVERED);

                    $material->save();
                    $delivery_details->save();
                }

                $pending_details = PreProductionMaterialDeliveryDetails::where('deleted', PreProductionMaterialDeliveryDetails::DELETED_NO)
                    ->where('status', PreProductionMaterialDeliveryDetails::STATUS_ACTIVE)
                    ->where('received_status', '!=', PreProductionMaterialDeliveryDetails::RECEIVED_STATUS_DELIVERED)
                    ->where('pre_production_material_delivery_id', $delivery_id)
                    ->count();

                $delivery->received_status = $pending_details > 0
                    ? PreProductionMaterialDelivery::RECEIVED_STATUS_PARTIAL
                    : PreProductionMaterialDelivery::RECEIVED_STATUS_DELIVERED;

                $delivery->save();
            }

            $pending_deliveries = PreProductionMaterialDelivery::where('received_status', '!=', PreProductionMaterialDelivery::RECEIVED_STATUS_DELIVERED)
                ->where('pre_production_id', $id)
                ->where('deleted', PreProductionMaterialDelivery::DELETED_NO)
                ->where('status', PreProductionMaterialDelivery::STATUS_ACTIVE)
                ->count();

            $pre_production->received_status = $pending_deliveries > 0
                ? PreProduction::RECEIVED_STATUS_PARTIAL
                : PreProduction::RECEIVED_STATUS_DELIVERED;

            $pre_production->save();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
    }


    // public function receiveStoreData($request, $id){
    //     DB::beginTransaction();
    //     try {
    //         $pre_production = PreProduction::where('deleted', PreProduction::DELETED_NO)
    //             ->where('status', PreProduction::STATUS_ACTIVE)
    //             ->where('status', PreProduction::STATUS_ACTIVE)
    //             ->where('type', PreProduction::TYPE_BOARD)
    //             ->where('id', $id)
    //             ->first();
    //         if(!$pre_production){
    //             throw new \Exception('Pre Production not found');
    //         }

    //         $delivery_id = $request->pre_production_material_delivery_id;
    //         $delivery = PreProductionMaterialDelivery::where('deleted', PreProductionMaterialDelivery::DELETED_NO)
    //             ->where('id', $delivery_id)
    //             ->where('status', PreProductionMaterialDelivery::STATUS_ACTIVE)
    //             ->first();
    //         if(!$delivery){
    //             throw new \Exception('Pre Production Delivery not found');
    //         }

    //         if (isset($request->pre_production_material_delivery_details_id) && is_array($request->pre_production_material_delivery_details_id) && count($request->pre_production_material_delivery_details_id) > 0) {

    //             foreach($request->pre_production_material_delivery_details_id as $detailsKey => $detailsId){
    //                 if($detailsId != '' && isset($request->code[$detailsKey]) && is_array($request->code[$detailsKey]) && $request->code[$detailsKey] > 0){

    //                     foreach($request->code[$detailsKey] as $itemKey => $itemCode){
    //                         $item = PreProductionMaterialDeliveryDetailsItems::where('received', PreProductionMaterialDeliveryDetailsItems::RECEIVED_NO)
    //                             ->where('pre_production_id', $id)
    //                             ->where('pre_production_material_delivery_id', $delivery_id)
    //                             ->where('pre_production_material_delivery_details_id', $detailsId)
    //                             ->where('barcode', $itemCode)
    //                             ->first();
    //                         if($item){
    //                             $item->received = PreProductionMaterialDeliveryDetailsItems::RECEIVED_YES;
    //                             $item->save();

    //                             $material = PreProductionMaterial::find($item->pre_production_material_id);
    //                             $material->received_qty = $material->received_qty + 1;
    //                             $material->save();

    //                             $item_details = PreProductionMaterialDeliveryDetails::find($item->pre_production_material_delivery_details_id);
    //                             $item_details->received_qty = $item_details->received_qty + 1;
    //                             $item_details->save();

    //                             if($material->received_qty == 0){
    //                                 $material->received_status = PreProductionMaterial::RECEIVED_STATUS_PENDING;
    //                                 $material->save();
    //                             }else if($material->received_qty != $material->quantity){
    //                                 $material->received_status = PreProductionMaterial::RECEIVED_STATUS_PARTIAL;
    //                                 $material->save();
    //                             }else{
    //                                 $material->received_status = PreProductionMaterial::RECEIVED_STATUS_DELIVERED;
    //                                 $material->save();
    //                             }
    //                         }
    //                     }

    //                     $item_count= PreProductionMaterialDeliveryDetailsItems::where('received', PreProductionMaterialDeliveryDetailsItems::RECEIVED_NO)
    //                         ->where('pre_production_id', $id)
    //                         ->where('pre_production_material_delivery_id', $delivery_id)
    //                         ->where('pre_production_material_delivery_details_id', $detailsId)
    //                         ->count();
    //                     $details = PreProductionMaterialDeliveryDetails::find($detailsId);

    //                     if($item_count > 0){
    //                         $details->received_status = PreProductionMaterialDeliveryDetails::RECEIVED_STATUS_PARTIAL;
    //                         $details->save();
    //                     }else{
    //                         $details->received_status = PreProductionMaterialDeliveryDetails::RECEIVED_STATUS_DELIVERED;
    //                         $details->save();
    //                     }
    //                 }
    //             }

    //             $details_count = PreProductionMaterialDeliveryDetails::where('deleted', PreProductionMaterialDeliveryDetails::DELETED_NO)
    //                 ->where('status', PreProductionMaterialDeliveryDetails::STATUS_ACTIVE)
    //                 ->where('received_status','!=',PreProductionMaterialDeliveryDetails::RECEIVED_STATUS_DELIVERED)
    //                 ->where('pre_production_material_delivery_id', $delivery_id)
    //                 ->count();
    //             $delivery = PreProductionMaterialDelivery::find($delivery_id);

    //             if($details_count > 0){
    //                 $delivery->received_status = PreProductionMaterialDelivery::RECEIVED_STATUS_PARTIAL;
    //                 $delivery->save();
    //             }else{
    //                 $delivery->received_status = PreProductionMaterialDelivery::RECEIVED_STATUS_DELIVERED;
    //                 $delivery->save();
    //             }
    //         }

    //         $delivery_count= PreProductionMaterialDelivery::where('received_status', '!=' , PreProductionMaterialDelivery::RECEIVED_STATUS_DELIVERED)
    //             ->where('pre_production_id', $id)
    //             ->where('deleted', PreProductionMaterialDelivery::DELETED_NO)
    //             ->where('status', PreProductionMaterialDelivery::STATUS_ACTIVE)
    //             ->count();

    //         if($delivery_count > 0){
    //             $pre_production->received_status = PreProduction::RECEIVED_STATUS_PARTIAL;
    //             $pre_production->save();
    //         }else{
    //             $pre_production->received_status = PreProduction::RECEIVED_STATUS_DELIVERED;
    //             $pre_production->save();
    //         }
    //     }catch (\Exception $e) {
    //         DB::rollBack();
    //         throw new \Exception($e->getMessage());
    //     }
    //     DB::commit();
    // }

    public function getDeliveryData($id){
        $pre_production = PreProduction::where('deleted', PreProduction::DELETED_NO)
            ->where('status', PreProduction::STATUS_ACTIVE)
            ->where('type', PreProduction::TYPE_BOARD)
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
            ->where('status', PreProduction::STATUS_ACTIVE)
            ->where('id', $id)
            ->where('type', PreProduction::TYPE_BOARD)
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
            $pre_production = PreProduction::with('finishedGoods')
                ->where('deleted', PreProduction::DELETED_NO)
                ->where('status', PreProduction::STATUS_ACTIVE)
                ->where('type', PreProduction::TYPE_BOARD)
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
}
