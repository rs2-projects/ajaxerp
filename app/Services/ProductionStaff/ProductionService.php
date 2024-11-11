<?php

namespace App\Services\ProductionStaff;

use App\Models\Procurements\ProductMaterialPurchaseDetails;
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
use App\Models\Production\PreProductionProcessBoard;
use App\Models\Production\PreProductionProcessEstimatedOutput;
use App\Models\Production\PreProductionProcessMachine;
use App\Models\Production\PreProductionProcessMaterial;
use App\Models\Production\ProductionDispatch;
use App\Models\Products\FinishedGoods;
use App\Models\Products\FinishedGoodsCategory;
use App\Models\Products\ProductMaterial;
use App\Models\Products\ProductMaterialCategory;
use Barryvdh\DomPDF\PDF;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Picqer\Barcode\BarcodeGeneratorPNG;

class ProductionService
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

    // public function getAllPreProductions($request){
    //     $keyword_filtered = $request->keyword_filtered??null;
    //     $data['pre_productions'] = PreProduction::where('deleted', PreProduction::DELETED_NO)
    //         ->where('is_verified', PreProduction::VERIFIED_YES)
    //         ->where(function ($q) use ($keyword_filtered){
    //             if ($keyword_filtered !=''){
    //                 $q->where('pre_production_no', 'like', '%'.$keyword_filtered.'%');
    //             }
    //         })
    //         ->orderBy('id', 'desc')->paginate($this->paginate_limit);

    //     $data['view'] = view('production-staff.production._index_filtered', $data)->render();
    //     return $data;
    // }

    public function getAllPreProductions($request){
        $staffId = auth()->guard('production-staff')->user()->id;
        $keyword_filtered = $request->keyword_filtered??null;
        $data['pre_productions'] = PreProduction::where('deleted', PreProduction::DELETED_NO)
            ->where('is_verified', PreProduction::VERIFIED_YES)
            ->whereHas('process', function ($q) use ($staffId){
                $q->where('production_staff_id', $staffId);
            })
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
        $staffId = auth()->guard('production-staff')->user()->id;
        $keyword_filtered = $request->keyword_filtered??null;
        $data['pre_productions'] = PreProduction::where('deleted', PreProduction::DELETED_NO)
            ->where('is_verified', PreProduction::VERIFIED_YES)
            ->where('process_status', PreProduction::PROCESS_STATUS_PENDING)
            ->whereHas('process', function ($q) use ($staffId){
                $q->where('production_staff_id', $staffId);
            })
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
        $staffId = auth()->guard('production-staff')->user()->id;
        $keyword_filtered = $request->keyword_filtered ?? null;
        $data['pre_productions'] = PreProduction::with('pendingPreProductionMaterialDeliveries')
            ->where('deleted', PreProduction::DELETED_NO)
            ->where('is_verified', PreProduction::VERIFIED_YES)
            ->whereHas('process', function ($q) use ($staffId){
                $q->where('production_staff_id', $staffId);
            })
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
        $staffId = auth()->guard('production-staff')->user()->id;
        $keyword_filtered = $request->keyword_filtered??null;
        $data['pre_productions'] = PreProduction::where('deleted', PreProduction::DELETED_NO)
            ->where('is_verified', PreProduction::VERIFIED_YES)
            ->where('process_status', PreProduction::PROCESS_STATUS_PROCESSING)
            ->whereHas('process', function ($q) use ($staffId){
                $q->where('production_staff_id', $staffId);
            })
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
        $staffId = auth()->guard('production-staff')->user()->id;
        $keyword_filtered = $request->keyword_filtered??null;
        $data['pre_productions'] = PreProduction::where('deleted', PreProduction::DELETED_NO)
            ->where('is_verified', PreProduction::VERIFIED_YES)
            ->where('process_status', PreProduction::PROCESS_STATUS_COMPLETED)
            ->whereHas('process', function ($q) use ($staffId){
                $q->where('production_staff_id', $staffId);
            })
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
        $staffId = auth()->guard('production-staff')->user()->id;
        $keyword_filtered = $request->keyword_filtered??null;
        $data['pre_productions'] = PreProduction::where('deleted', PreProduction::DELETED_NO)
            ->where('is_verified', PreProduction::VERIFIED_YES)
            ->where('dispatched_status', PreProduction::DISPATCH_STATUS_DISPATCHED)
            ->whereHas('process', function ($q) use ($staffId){
                $q->where('production_staff_id', $staffId);
            })
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

        $data['categories'] = ProductMaterialCategory::where('deleted', ProductMaterialCategory::DELETED_NO)
            ->where('status', ProductMaterialCategory::STATUS_ACTIVE)
            ->orderBy('id', 'desc')
            ->get();

        $data['finished_categoris'] = FinishedGoodsCategory::where('deleted', FinishedGoodsCategory::DELETED_NO)
            ->where('status', FinishedGoodsCategory::STATUS_ACTIVE)
            ->orderBy('id', 'desc')
            ->get();

        $data['p_machine'] = PreProductionProcessMachine::where('pre_production_id', $pre_production->id)
            ->first();
        $data['board_process'] = PreProductionProcess::where('pre_production_id', $pre_production->id)
            ->where('deleted', PreProductionProcess::DELETED_NO)
            ->where('status', PreProductionProcess::STATUS_ACTIVE)
            ->first();
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

            if($pre_production->scan_status == PreProduction::SCAN_STATUS_PENDING){
                throw new \Exception('Raw materials has not yet been scanned!');
            }

            $process = PreProductionProcess::where('id', $processId)
                ->where('deleted', PreProductionProcess::DELETED_NO)
                ->where('status', PreProductionProcess::STATUS_ACTIVE)
                ->first();
            if($process){
                $process->process_status = $status;
                $process->updated_by = auth()->guard('production-staff')->user()->id;
                $process->updated_at = now();
                $process->save();
            }

            //TODO: why check this?
            $count_processing = PreProductionProcess::where('pre_production_id', $id)
                ->where('deleted', PreProductionProcess::DELETED_NO)
                ->where('status', PreProductionProcess::STATUS_ACTIVE)
                ->where('process_status', PreProductionProcess::PROCESS_STATUS_PROCESSING)
                ->count();
            if($count_processing > 0){
                $pre_production->process_status = PreProduction::PROCESS_STATUS_PROCESSING;
                $pre_production->updated_by = auth()->guard('production-staff')->user()->id;
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
                $pre_production->updated_by = auth()->guard('production-staff')->user()->id;
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

    
    public function barcodeDetails($id, $type) {
        //find pre production
        if($type == 'other'){
            
            $delivery = PreProductionMaterialDelivery::where('deleted', PreProductionMaterialDelivery::DELETED_NO)
                ->where('status', PreProductionMaterialDelivery::STATUS_ACTIVE)
                ->where('id', $id)
                ->first();
            if(!$delivery){
                throw new \Exception('Invalid Delivery!');
            }

            $delivery_details = PreProductionMaterialDeliveryDetails::where('deleted', PreProductionMaterialDeliveryDetails::DELETED_NO)
                ->where('pre_production_material_delivery_id', $id)
                ->get();
            $product_material_ids = $delivery_details
                ->pluck('product_material_id')
                ->toArray();
            
            $data['product_materials'] = ProductMaterial::where('deleted', ProductMaterial::DELETED_NO)
                ->whereIn('id', $product_material_ids)
                ->get()
                ->map(function ($product_material) use ($id, $delivery_details) {
                    //get delivered purchase detail ids
                    $deliveryDetailsItems = PreProductionMaterialDeliveryDetailsItems::where('pre_production_material_delivery_id', $id)
                        ->where('product_material_id', $product_material->id)
                        ->get();
                    $purchaseDetailIds = $deliveryDetailsItems
                        ->pluck('product_material_purchase_details_id')
                        ->toArray();
                    //get purchase details
                    // dd($deliveryDetailsItems);
                    $purchase_details = ProductMaterialPurchaseDetails::with('materialPurchase')
                        ->where('deleted', ProductMaterialPurchaseDetails::DELETED_NO)
                        ->whereIn('id', $purchaseDetailIds)
                        ->get();
                    $product_material->purchase_details = $purchase_details;
                    $product_material->delivery_details = $delivery_details->where('product_material_id', $product_material->id)->first();
                    return $product_material;
                });
            $data['finished_boards'] = [];
        } else {

            $delivery_details = PreProductionBoardDeliveryDetails::where('deleted', PreProductionBoardDeliveryDetails::DELETED_NO)
            ->where('pre_production_board_delivery_id', $id)
            ->get();
            $finished_borad_ids = $delivery_details
                ->pluck('finished_board_id')
                ->toArray();

        // $finished_borad_ids = PreProductionBoard::where('deleted', PreProductionBoard::DELETED_NO)
        //     ->where('pre_production_id', $id)
        //     ->pluck('finished_board_id')
        //     ->toArray();
        
            $data['finished_boards'] = FinishedGoods::where('deleted', FinishedGoods::DELETED_NO)
                ->whereIn('id', $finished_borad_ids)
                ->get()
                ->map(function ($finished_board) use ($id, $delivery_details) {
                    //get purchase details
                    $availableProductions = PreProduction::where('deleted', PreProduction::DELETED_NO)
                        ->where('finished_goods_id', $finished_board->id)
                        ->where('is_verified', PreProduction::VERIFIED_YES)
                        ->where('type', PreProduction::TYPE_BOARD)
                        ->where('available_qty', '>', 0)
                        ->where('status', PreProduction::STATUS_ACTIVE)
                        ->get();
                    $finished_board->purchase_details = $availableProductions;
                    $finished_board->delivery_details = $delivery_details->where('finished_board_id', $finished_board->id)->first();
                    return $finished_board;
                });
            $data['product_materials'] = [];
        }


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

    // public function receiveStoreData($request, $id){
    //     DB::beginTransaction();
    //     try {
    //         $pre_production = PreProduction::where('deleted', PreProduction::DELETED_NO)
    //             ->where('status', PreProduction::STATUS_ACTIVE)
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

    //         // $data['deliveries'] = PreProductionMaterialDelivery::where('deleted', PreProductionMaterialDelivery::DELETED_NO)
    //         //     ->where('status', PreProductionMaterialDelivery::STATUS_ACTIVE)
    //         //     ->where('pre_production_id', $id)
    //         //     ->with(
    //         //         'delivery_details',
    //         //         'delivery_details.material',
    //         //         'delivery_details.material.category',
    //         //         'delivery_details.material.product',
    //         //         'delivery_details.pending_items',
    //         //     )
    //         //     ->get();
    //         // return $data;

    //     }catch (\Exception $e) {
    //         DB::rollBack();
    //         throw new \Exception($e->getMessage());
    //     }
    //     DB::commit();
    // }

    public function receiveStoreData($request, $id){
        DB::beginTransaction();
        try {
            // dd($request->all());
            $pre_production = PreProduction::where('deleted', PreProduction::DELETED_NO)
                ->where('status', PreProduction::STATUS_ACTIVE)
                ->where('id', $id)
                ->first();
            if(!$pre_production){
                throw new \Exception('Pre Production not found');
            }

            $delivery_id = $request->pre_production_material_delivery_id;
            $type = $request->type;
            $item_model = ($type === 'board') ? PreProductionBoardDeliveryDetailsItem::class : PreProductionMaterialDeliveryDetailsItems::class;
            $material_model = ($type === 'board') ? PreProductionBoard::class : PreProductionMaterial::class;
            $details_model = ($type === 'board') ? PreProductionBoardDeliveryDetails::class : PreProductionMaterialDeliveryDetails::class;
            $delivery_model = ($type === 'board') ? PreProductionBoardDelivery::class : PreProductionMaterialDelivery::class;

            $delivery = $delivery_model::where('deleted', $delivery_model::DELETED_NO)
                ->where('pre_production_id', $id)
                ->where('id', $delivery_id)
                ->where('status', $delivery_model::STATUS_ACTIVE)
                ->first();

            if(!$delivery){
                throw new \Exception('Pre Production Delivery not found');
            }

            if (isset($request->delivery_items) && is_array($request->delivery_items) && count($request->delivery_items) > 0) {

                foreach($request->delivery_items as $detailsKey => $deliveryItemId){
                    if($deliveryItemId != ''){
                        $item = null;
                        foreach($request->delivery_items[$detailsKey] as $itemKey => $itemId){
                            if($type == 'board'){
                                $item = PreProductionBoardDeliveryDetailsItem::where('received_status', '!=', PreProductionBoardDeliveryDetailsItem::RECEIVED_STATUS_RECEIVED)
                                    ->where('id', $itemId)
                                    ->where('pre_production_id', $id)
                                    ->where('pre_production_board_delivery_id', $delivery_id)
                                    // ->where('pre_production_board_delivery_details_id', $detailsId)
                                    // ->where('barcode', $itemCode)
                                    ->first();
                            }else{
                                $item = PreProductionMaterialDeliveryDetailsItems::where('received_status', '!=', PreProductionMaterialDeliveryDetailsItems::RECEIVED_STATUS_RECEIVED)
                                    ->where('id', $itemId)
                                    ->where('pre_production_id', $id)
                                    ->where('pre_production_material_delivery_id', $delivery_id)
                                    // ->where('pre_production_material_delivery_details_id', $detailsId)
                                    // ->where('barcode', $itemCode)
                                    ->first();
                            }
                            if($item){
                                $qty = $request->selected_qty[$detailsKey][$itemKey];
                                
                                $received_qty = $item->received_qty + $qty;
                                $item->received_qty = $received_qty;
                                
                                if($received_qty == $item->quantity){
                                    $item->received_status = $item_model::RECEIVED_STATUS_RECEIVED;
                                    $item->received = $item_model::RECEIVED_YES;
                                } else {
                                    $item->received_status = $item_model::RECEIVED_STATUS_PARTIAL;
                                }
                                $item->save();

                                if($type == 'board'){
                                    $material = $material_model::find($item->pre_production_board_id);
                                }else{
                                    $material = $material_model::find($item->pre_production_material_id);
                                }

                                $material->received_qty = $material->received_qty + $qty;
                                $material->save();

                                // update details table
                                if($type == 'board'){
                                    $item_details = $details_model::find($item->pre_production_board_delivery_details_id);
                                }else{
                                    $item_details = $details_model::find($item->pre_production_material_delivery_details_id);
                                }
                                $item_details->received_qty = $item_details->received_qty + $qty;
                                $item_details->save();

                                if($material->received_qty == 0){
                                    $material->received_status = $material_model::RECEIVED_STATUS_PENDING;
                                    $material->save();
                                }else if($material->received_qty != $material->quantity){
                                    $material->received_status = $material_model::RECEIVED_STATUS_PARTIAL;
                                    $material->save();
                                }else{
                                    
                                    $material->received_status = $material_model::RECEIVED_STATUS_DELIVERED;
                                    $material->save();
                                }
                            }
                        }

                        if(($item != null) && !empty($item)) {
                            if($type == 'board'){
                                $item_count = PreProductionBoardDeliveryDetailsItem::where('received_status', '!=', PreProductionBoardDeliveryDetailsItem::RECEIVED_STATUS_RECEIVED)
                                    ->where('pre_production_id', $id)
                                    ->where('pre_production_board_delivery_id', $delivery_id)
                                    ->where('pre_production_board_delivery_details_id', $item->pre_production_board_delivery_details_id)
                                    // ->where('barcode', $itemCode)
                                    ->count();
                            }else{
                                $item_count = PreProductionMaterialDeliveryDetailsItems::where('received_status', '!=', PreProductionMaterialDeliveryDetailsItems::RECEIVED_STATUS_RECEIVED)
                                    ->where('pre_production_id', $id)
                                    ->where('pre_production_material_delivery_id', $delivery_id)
                                    ->where('pre_production_material_delivery_details_id', $item->pre_production_material_delivery_details_id)
                                    // ->where('barcode', $itemCode)
                                    ->count();
                            }

                            $details = $details_model::find($item->pre_production_material_delivery_details_id);

                            if($item_count > 0){
                                $details->received_status = $details_model::RECEIVED_STATUS_PARTIAL;
                                $details->save();
                            }else{
                                $details->received_status = $details_model::RECEIVED_STATUS_DELIVERED;
                                $details->save();
                            }
                        }
                    }
                }

                if($type == 'board'){
                    $details_count = $details_model::where('deleted', $details_model::DELETED_NO)
                        ->where('status', $details_model::STATUS_ACTIVE)
                        ->where('received_status','!=',$details_model::RECEIVED_STATUS_DELIVERED)
                        ->where('pre_production_id', $id)
                        ->where('pre_production_board_delivery_id', $delivery_id)
                        ->count();

                    // $processing_count = $details_model::where('pre_production_board_delivery_id', $delivery_id)
                    //     ->where('pre_production_id', $id)
                    //     ->where('received_status', $details_model::RECEIVED_STATUS_PARTIAL)
                    //     ->exists();

                }else{
                    $details_count = $details_model::where('deleted', $details_model::DELETED_NO)
                        ->where('status', $details_model::STATUS_ACTIVE)
                        ->where('received_status','!=',$details_model::RECEIVED_STATUS_DELIVERED)
                        ->where('pre_production_id', $id)
                        ->where('pre_production_material_delivery_id', $delivery_id)
                        ->count();

                    // $processing_count = $details_model::where('pre_production_material_delivery_id', $delivery_id)
                    //     ->where('received_status', $details_model::RECEIVED_STATUS_PARTIAL)
                    //     ->where('pre_production_id', $id)
                    //     ->exists();
                }
                $delivery = $delivery_model::find($delivery_id);

                if($details_count == 0){
                    $delivery->received_status = $delivery_model::RECEIVED_STATUS_DELIVERED;
                }else{
                    $delivery->received_status = $delivery_model::RECEIVED_STATUS_PARTIAL;
                }

                $delivery->save();
            }

            $other_delivery_count= PreProductionMaterialDelivery::where('received_status', '!=' , PreProductionMaterialDelivery::RECEIVED_STATUS_DELIVERED)
                ->where('pre_production_id', $id)
                ->where('deleted', PreProductionMaterialDelivery::DELETED_NO)
                ->where('status', PreProductionMaterialDelivery::STATUS_ACTIVE)
                ->count();

            // $other_delivery_processing = PreProductionMaterialDelivery::where('pre_production_id', $id)
            //     ->where('received_status', PreProductionMaterialDelivery::RECEIVED_STATUS_PARTIAL)
            //     ->where('deleted', PreProductionMaterialDelivery::DELETED_NO)
            //     ->where('status', PreProductionMaterialDelivery::STATUS_ACTIVE)
            //     ->exists();

            $board_delivery_count= PreProductionBoardDelivery::where('received_status', '!=' , PreProductionBoardDelivery::RECEIVED_STATUS_DELIVERED)
                ->where('pre_production_id', $id)
                ->where('deleted', PreProductionBoardDelivery::DELETED_NO)
                ->where('status', PreProductionBoardDelivery::STATUS_ACTIVE)
                ->count();

            // $board_delivery_processing = PreProductionBoardDelivery::where('pre_production_id', $id)
            //     ->where('received_status', PreProductionBoardDelivery::RECEIVED_STATUS_PARTIAL)
            //     ->where('deleted', PreProductionBoardDelivery::DELETED_NO)
            //     ->where('status', PreProductionBoardDelivery::STATUS_ACTIVE)
            //     ->exists();

            // if($other_delivery_count == 0 && $board_delivery_count){
            //     $pre_production->received_status = PreProduction::RECEIVED_STATUS_DELIVERED;
            // }else if($other_delivery_processing || $board_delivery_processing){
            //     $pre_production->received_status = PreProduction::RECEIVED_STATUS_PARTIAL;
            // }

            if ($other_delivery_count == 0 && $board_delivery_count == 0) {
                $pre_production->received_status = PreProduction::RECEIVED_STATUS_DELIVERED;
            } else {
                $pre_production->received_status = PreProduction::RECEIVED_STATUS_PARTIAL;
            }

            $pre_production->save();

        }catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
        DB::commit();
    }

    public function getDeliveryData($id){
        $pre_production = PreProduction::where('deleted', PreProduction::DELETED_NO)
            ->where('status', PreProduction::STATUS_ACTIVE)
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
                'delivery_details.pending_items.purchase_details',
                'delivery_details.pending_items.purchase_details.materialPurchase',
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
                'board_delivery_details.pending_items.production',
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

    // scan raw material
    public function checkScanBarCode($request, $id){
        $pre_production = PreProduction::where('deleted', PreProduction::DELETED_NO)
            ->where('status', PreProduction::STATUS_ACTIVE)
            ->where('id', $id)
            ->first();
        if(!$pre_production){
            throw new \Exception('Pre Production not found');
        }

        if($request->type == 'other'){
            $valid_code = PreProductionMaterialDeliveryDetailsItems::where('received', PreProductionMaterialDeliveryDetailsItems::RECEIVED_YES)
                ->where('scanned', PreProductionMaterialDeliveryDetailsItems::SCANNED_NO)
                ->where('pre_production_id', $id)
                ->where('pre_production_material_delivery_id', $request->delivery_id)
                ->where('pre_production_material_delivery_details_id', $request->delivery_details_id)
                ->where('barcode', $request->barcode)
                ->get();
        }else{
            $valid_code = PreProductionBoardDeliveryDetailsItem::where('received', PreProductionBoardDeliveryDetailsItem::RECEIVED_YES)
                ->where('scanned', PreProductionBoardDeliveryDetailsItem::SCANNED_NO)
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

    public function getDeliveryScanData($id){
        $material_deliveries= PreProductionMaterialDelivery::where('deleted', PreProductionMaterialDelivery::DELETED_NO)
            ->where('status', PreProductionMaterialDelivery::STATUS_ACTIVE)
            ->where('pre_production_id', $id)
            ->where('received_status', '!=', PreProductionMaterialDelivery::RECEIVED_STATUS_PENDING)
            ->with(
                'scan_details',
                'scan_details.material',
                'scan_details.material.category',
                'scan_details.material.product',
                'scan_details.pending_scans',
            )
            ->get();

        $board_deliveries= PreProductionBoardDelivery::where('deleted', PreProductionBoardDelivery::DELETED_NO)
            ->where('status', PreProductionBoardDelivery::STATUS_ACTIVE)
            ->where('pre_production_id', $id)
            ->where('received_status', '!=', PreProductionBoardDelivery::RECEIVED_STATUS_PENDING)
            ->with(
                'board_scan_details',
                'board_scan_details.board',
                'board_scan_details.board.category',
                'board_scan_details.board.product',
                'board_scan_details.pending_scans',
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

    public function scanStoreData($request, $id){
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
            $type = $request->type;
            $item_model = ($type === 'board') ? PreProductionBoardDeliveryDetailsItem::class : PreProductionMaterialDeliveryDetailsItems::class;
            $material_model = ($type === 'board') ? PreProductionBoard::class : PreProductionMaterial::class;
            $details_model = ($type === 'board') ? PreProductionBoardDeliveryDetails::class : PreProductionMaterialDeliveryDetails::class;
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
                    if($detailsId != '' && isset($request->code[$detailsKey]) && is_array($request->code[$detailsKey]) && $request->code[$detailsKey] > 0){

                        foreach($request->code[$detailsKey] as $itemKey => $itemCode){
                            if($type == 'board'){
                                $item = PreProductionBoardDeliveryDetailsItem::where('received', PreProductionBoardDeliveryDetailsItem::RECEIVED_YES)
                                    ->where('pre_production_id', $id)
                                    ->where('scanned', PreProductionBoardDeliveryDetailsItem::SCANNED_NO)
                                    ->where('pre_production_board_delivery_id', $delivery_id)
                                    ->where('pre_production_board_delivery_details_id', $detailsId)
                                    ->where('barcode', $itemCode)
                                    ->first();
                            }else{
                                $item = PreProductionMaterialDeliveryDetailsItems::where('received', PreProductionMaterialDeliveryDetailsItems::RECEIVED_YES)
                                    ->where('scanned', PreProductionMaterialDeliveryDetailsItems::SCANNED_NO)
                                    ->where('pre_production_id', $id)
                                    ->where('pre_production_material_delivery_id', $delivery_id)
                                    ->where('pre_production_material_delivery_details_id', $detailsId)
                                    ->where('barcode', $itemCode)
                                    ->first();
                                }
                            if($item){
                                $item->scanned = $item_model::SCANNED_YES;
                                $item->save();

                                if($type == 'board'){
                                    $material = $material_model::find($item->pre_production_board_id);
                                }else{
                                    $material = $material_model::find($item->pre_production_material_id);
                                }
                                $material->scanned_qty = $material->scanned_qty + 1;
                                $material->save();

                                if($type == 'board'){
                                    $item_details = $details_model::find($item->pre_production_board_delivery_details_id);
                                }else{
                                    $item_details = $details_model::find($item->pre_production_material_delivery_details_id);
                                }
                                $item_details->scanned_qty = $item_details->scanned_qty + 1;
                                $item_details->save();

                                if($material->scanned_qty == 0){
                                    $material->scan_status = $material_model::RECEIVED_STATUS_PENDING;
                                }else if($material->received_qty != $material->quantity){
                                    $material->scan_status = $material_model::RECEIVED_STATUS_PARTIAL;
                                }else{
                                    $material->scan_status = $material_model::SCAN_STATUS_SCANNED;
                                }
                                $material->save();

                                if($material->scanned_qty == 0){
                                    $material->scan_status = PreProductionMaterial::SCAN_STATUS_PENDING;
                                    $material->save();
                                }else if($material->scanned_qty != $material->quantity){
                                    $material->scan_status = PreProductionMaterial::SCAN_STATUS_PARTIAL;
                                    $material->save();
                                }else{
                                    $material->scan_status = PreProductionMaterial::SCAN_STATUS_SCANNED;
                                    $material->save();
                                }
                            }
                        }

                        if($type == 'board'){
                            $item_count = PreProductionBoardDeliveryDetailsItem::where('received', PreProductionBoardDeliveryDetailsItem::RECEIVED_YES)
                                ->where('pre_production_id', $id)
                                ->where('scanned', PreProductionBoardDeliveryDetailsItem::SCANNED_NO)
                                ->where('pre_production_board_delivery_id', $delivery_id)
                                ->where('pre_production_board_delivery_details_id', $detailsId)
                                ->where('barcode', $itemCode)
                                ->count();
                        }else{
                            $item_count = PreProductionMaterialDeliveryDetailsItems::where('received', PreProductionMaterialDeliveryDetailsItems::RECEIVED_YES)
                                ->where('pre_production_id', $id)
                                ->where('scanned', PreProductionMaterialDeliveryDetailsItems::SCANNED_NO)
                                ->where('pre_production_material_delivery_id', $delivery_id)
                                ->where('pre_production_material_delivery_details_id', $detailsId)
                                ->where('barcode', $itemCode)
                                ->count();
                        }

                        $details = $details_model::find($detailsId);

                        if($item_count > 0){
                            $details->scan_status = $details_model::SCAN_STATUS_PARTIAL;
                        }else{
                            $details->scan_status = $details_model::SCAN_STATUS_SCANNED;
                        }
                        $details->save();

                        // if ($item_count > 0 && ($details->total_quantity - $details->scanned_qty) > 0) {
                        //     $details->scan_status = PreProductionMaterialDeliveryDetails::SCAN_STATUS_PARTIAL;
                        // } elseif ($item_count == 0 && ($details->total_quantity - $details->scanned_qty) == 0) {
                        //     $details->scan_status = PreProductionMaterialDeliveryDetails::SCAN_STATUS_SCANNED;
                        // } else {
                        //     $details->scan_status = PreProductionMaterialDeliveryDetails::SCAN_STATUS_PENDING;
                        // }
                        // $details->save();
                    }
                }

                if($type == 'board'){
                    $details_count = $details_model::where('deleted', $details_model::DELETED_NO)
                        ->where('status', $details_model::STATUS_ACTIVE)
                        ->where('scan_status','!=',$details_model::SCAN_STATUS_SCANNED)
                        ->where('pre_production_id', $id)
                        ->where('pre_production_board_delivery_id', $delivery_id)
                        ->count();
                }else{
                    $details_count = $details_model::where('deleted', $details_model::DELETED_NO)
                        ->where('status', $details_model::STATUS_ACTIVE)
                        ->where('scan_status','!=',$details_model::SCAN_STATUS_SCANNED)
                        ->where('pre_production_id', $id)
                        ->where('pre_production_material_delivery_id', $delivery_id)
                        ->count();
                }
                $delivery = $delivery_model::find($delivery_id);

                if($details_count == 0){
                    $delivery->scan_status = $delivery_model::SCAN_STATUS_SCANNED;
                }else{
                    $delivery->scan_status = $delivery_model::SCAN_STATUS_PARTIAL;
                }

                $delivery->save();
            }

            $other_delivery_count= PreProductionMaterialDelivery::where('scan_status', '!=' , PreProductionMaterialDelivery::SCAN_STATUS_SCANNED)
                ->where('pre_production_id', $id)
                ->where('deleted', PreProductionMaterialDelivery::DELETED_NO)
                ->where('status', PreProductionMaterialDelivery::STATUS_ACTIVE)
                ->count();

            $board_delivery_count= PreProductionBoardDelivery::where('scan_status', '!=' , PreProductionBoardDelivery::SCAN_STATUS_SCANNED)
                ->where('pre_production_id', $id)
                ->where('deleted', PreProductionBoardDelivery::DELETED_NO)
                ->where('status', PreProductionBoardDelivery::STATUS_ACTIVE)
                ->count();

            if ($other_delivery_count == 0 && $board_delivery_count == 0) {
                $pre_production->scan_status = PreProduction::SCAN_STATUS_SCANNED;
            } else {
                $pre_production->scan_status = PreProduction::SCAN_STATUS_PARTIAL;
            }

            $pre_production->save();

        }catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
        DB::commit();
    }

    // public function scanStoreData($request, $id){
    //     DB::beginTransaction();
    //     try {
    //         $pre_production = PreProduction::where('deleted', PreProduction::DELETED_NO)
    //             ->where('status', PreProduction::STATUS_ACTIVE)
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
    //                         $item = PreProductionMaterialDeliveryDetailsItems::where('received', PreProductionMaterialDeliveryDetailsItems::RECEIVED_YES)
    //                             ->where('scanned', PreProductionMaterialDeliveryDetailsItems::SCANNED_NO)
    //                             ->where('pre_production_id', $id)
    //                             ->where('pre_production_material_delivery_id', $delivery_id)
    //                             ->where('pre_production_material_delivery_details_id', $detailsId)
    //                             ->where('barcode', $itemCode)
    //                             ->first();
    //                         if($item){
    //                             $item->scanned = PreProductionMaterialDeliveryDetailsItems::SCANNED_YES;
    //                             $item->save();

    //                             $material = PreProductionMaterial::find($item->pre_production_material_id);
    //                             $material->scanned_qty = $material->scanned_qty + 1;
    //                             $material->save();

    //                             $item_details = PreProductionMaterialDeliveryDetails::find($item->pre_production_material_delivery_details_id);
    //                             $item_details->scanned_qty = $item_details->scanned_qty + 1;
    //                             $item_details->save();

    //                             if($material->scanned_qty == 0){
    //                                 $material->scan_status = PreProductionMaterial::SCAN_STATUS_PENDING;
    //                                 $material->save();
    //                             }else if($material->scanned_qty != $material->quantity){
    //                                 $material->scan_status = PreProductionMaterial::SCAN_STATUS_PARTIAL;
    //                                 $material->save();
    //                             }else{
    //                                 $material->scan_status = PreProductionMaterial::SCAN_STATUS_SCANNED;
    //                                 $material->save();
    //                             }
    //                         }
    //                     }

    //                     $item_count= PreProductionMaterialDeliveryDetailsItems::where('received', PreProductionMaterialDeliveryDetailsItems::RECEIVED_YES)
    //                         ->where('scanned', PreProductionMaterialDeliveryDetailsItems::SCANNED_NO)
    //                         ->where('pre_production_id', $id)
    //                         ->where('pre_production_material_delivery_id', $delivery_id)
    //                         ->where('pre_production_material_delivery_details_id', $detailsId)
    //                         ->count();
    //                     $details = PreProductionMaterialDeliveryDetails::find($detailsId);

    //                     if($item_count > 0){
    //                         $details->scan_status = PreProductionMaterialDeliveryDetails::SCAN_STATUS_PARTIAL;
    //                         $details->save();
    //                     }else{
    //                         $details->scan_status = PreProductionMaterialDeliveryDetails::SCAN_STATUS_SCANNED;
    //                         $details->save();
    //                     }

    //                     // if ($item_count > 0 && ($details->total_quantity - $details->scanned_qty) > 0) {
    //                     //     $details->scan_status = PreProductionMaterialDeliveryDetails::SCAN_STATUS_PARTIAL;
    //                     // } elseif ($item_count == 0 && ($details->total_quantity - $details->scanned_qty) == 0) {
    //                     //     $details->scan_status = PreProductionMaterialDeliveryDetails::SCAN_STATUS_SCANNED;
    //                     // } else {
    //                     //     $details->scan_status = PreProductionMaterialDeliveryDetails::SCAN_STATUS_PENDING;
    //                     // }
    //                     // $details->save();
    //                 }
    //             }

    //             $details_count = PreProductionMaterialDeliveryDetails::where('deleted', PreProductionMaterialDeliveryDetails::DELETED_NO)
    //                 ->where('status', PreProductionMaterialDeliveryDetails::STATUS_ACTIVE)
    //                 ->where('scan_status','!=',PreProductionMaterialDeliveryDetails::SCAN_STATUS_SCANNED)
    //                 ->where('pre_production_material_delivery_id', $delivery_id)
    //                 ->count();
    //             $delivery = PreProductionMaterialDelivery::find($delivery_id);

    //             if($details_count > 0){
    //                 $delivery->scan_status = PreProductionMaterialDelivery::SCAN_STATUS_PARTIAL;
    //                 $delivery->save();
    //             }else{
    //                 $delivery->scan_status = PreProductionMaterialDelivery::SCAN_STATUS_SCANNED;
    //                 $delivery->save();
    //             }
    //         }

    //         $delivery_count= PreProductionMaterialDelivery::where('scan_status', '!=' , PreProductionMaterialDelivery::SCAN_STATUS_SCANNED)
    //             ->where('pre_production_id', $id)
    //             ->where('deleted', PreProductionMaterialDelivery::DELETED_NO)
    //             ->where('status', PreProductionMaterialDelivery::STATUS_ACTIVE)
    //             ->count();

    //         if($delivery_count > 0){
    //             $pre_production->scan_status = PreProduction::SCAN_STATUS_PARTIAL;
    //             $pre_production->save();
    //         }else{
    //             $pre_production->scan_status = PreProduction::SCAN_STATUS_SCANNED;
    //             $pre_production->save();
    //         }

    //     }catch (\Exception $e) {
    //         DB::rollBack();
    //         throw new \Exception($e->getMessage());
    //     }
    //     DB::commit();
    // }


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
            $pre_production = PreProduction::with('finishedGoods')
                ->where('deleted', PreProduction::DELETED_NO)
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
            $pre_production->updated_by = auth()->guard('production-staff')->user()->id;
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
            $dispatch->dispatched_by = auth()->guard('production-staff')->user()->id;
            $dispatch->dispatched_at = now();
            $dispatch->created_by = auth()->guard('production-staff')->user()->id;
            $dispatch->created_at = now();
            $dispatch->updated_by = auth()->guard('production-staff')->user()->id;
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

    public function verifyOutputData($id, $processId)
    {
        $data['estimated_outputs'] = PreProductionProcessEstimatedOutput::where('pre_production_id', $id)
            ->where('pre_production_process_id', $processId)
            ->where('deleted', PreProductionProcessEstimatedOutput::DELETED_NO)
            ->where('status', PreProductionProcessEstimatedOutput::STATUS_ACTIVE)
            ->get()
            ->map(function ($item) {
                $item->id = $item->id;
                $item->name = $item->name;
                $item->quantity = $item->quantity;
                $item->verified_qty = $item->verified_qty;
                $item->damage_qty = $item->damage_qty;
                $item->pending_qty = $item->quantity - $item->verified_qty;
                return $item;
            });

        if (!$data['estimated_outputs']) {
            throw new \Exception('Process not found');
        }
        return $data;
    }

    public function updateVerifyOutput($id, $type){
        DB::beginTransaction();
        $process_status = PreProductionProcess::PROCESS_STATUS_PROCESSING;
        try {
            $estimatedOutput = PreProductionProcessEstimatedOutput::where('deleted', PreProductionProcessEstimatedOutput::DELETED_NO)
                ->where('status', PreProductionProcessEstimatedOutput::STATUS_ACTIVE)
                ->where('id', $id)
                ->first();
            if(!$estimatedOutput){
                throw new \Exception('Estimated Output not found');
            }

            if($type == 1){
                $estimatedOutput->verified_qty = $estimatedOutput->verified_qty + 1;
            } else if($type == 2){
                $estimatedOutput->damage_qty = $estimatedOutput->damage_qty + 1;
            } else if($type == 3){
                $estimatedOutput->verified_qty = $estimatedOutput->quantity;
            }

            $estimatedOutput->updated_by = auth()->guard('production-staff')->user()->id;
            $estimatedOutput->updated_at = now();
            $estimatedOutput->save();

            $pre_production_id = $estimatedOutput->pre_production_id;
            $pre_production = PreProduction::where('deleted', PreProduction::DELETED_NO)
                ->where('id', $pre_production_id)
                ->first();

            $processId = $estimatedOutput->pre_production_process_id;
            $process = PreProductionProcess::where('id', $processId)
                ->where('deleted', PreProductionProcess::DELETED_NO)
                ->where('status', PreProductionProcess::STATUS_ACTIVE)
                ->first();

            $total_outputs = PreProductionProcessEstimatedOutput::where('pre_production_process_id', $processId)
                ->where('deleted', PreProductionProcessEstimatedOutput::DELETED_NO)
                ->where('status', PreProductionProcessEstimatedOutput::STATUS_ACTIVE)
                ->count();

            $verified_outputs = PreProductionProcessEstimatedOutput::where('pre_production_process_id', $processId)
                ->where('deleted', PreProductionProcessEstimatedOutput::DELETED_NO)
                ->where('status', PreProductionProcessEstimatedOutput::STATUS_ACTIVE)
                ->whereColumn('quantity', 'verified_qty')
                ->count();

            if ($total_outputs == $verified_outputs) {
                $process->process_status = PreProductionProcess::PROCESS_STATUS_COMPLETED;
                $process->updated_by = auth()->guard('production-staff')->user()->id;
                $process->updated_at = now();
                $process->save();
                $process_status = PreProductionProcess::PROCESS_STATUS_COMPLETED;
            }

            $count_completed = PreProductionProcess::where('pre_production_id', $pre_production_id)
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
                $pre_production->updated_by = auth()->guard('production-staff')->user()->id;
                $pre_production->updated_at = now();
                $pre_production->save();
            }

        }catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
        DB::commit();

        $data['process_status'] = $process_status;
        return $data;

    }

    public function getMaterialByCategory($request)
    {
        if($request->type == 'other'){
            $data['materials'] = ProductMaterial::where('deleted', ProductMaterial::DELETED_NO)
                ->where('status', ProductMaterial::STATUS_ACTIVE)
                ->where('product_material_category_id', $request->category_id)
                ->orderBy('name', 'asc')
                ->get();
        }else{
            $data['materials'] = FinishedGoods::where('deleted', FinishedGoods::DELETED_NO)
                ->where('status', FinishedGoods::STATUS_ACTIVE)
                ->where('type', FinishedGoods::TYPE_BOARD)
                ->where('finished_goods_category_id', $request->category_id)
                ->orderBy('id', 'desc')
                ->get();
        }

        $data['type'] = $request->type;
        return $data;

    }

    public function reRecuisitionStore($request){
        DB::beginTransaction();
        try {
            $process = PreProductionProcess::where('id', $request->process_id)
                ->where('pre_production_id', $request->pre_production_id)
                ->where('deleted', PreProductionProcess::DELETED_NO)
                ->where('status', PreProductionProcess::STATUS_ACTIVE)
                ->first();

            if (!$process) {
                throw new \Exception("Process not found");
            }
            $uniqueProductMaterials = [];
            $uniqueBoards = [];
            if (isset($request->product_material_category_id) && is_array($request->product_material_category_id) && (count($request->product_material_category_id) > 0)) {
                foreach ($request->product_material_category_id as $key=>$category_id) {
                    if(($request->product_material_category_id[$key] != '') &&
                        ($request->product_material_id[$key] != '') &&
                        ($request->quantity[$key] != '')
                    ){
                        if($request->material_type[$key] == 'other'){
                            $material = PreProductionProcessMaterial::where('pre_production_process_id', $request->process_id)
                                ->where('pre_production_id', $request->pre_production_id)
                                ->where('product_material_category_id', $request->product_material_category_id[$key])
                                ->where('product_material_id', $request->product_material_id[$key])
                                ->first();
                            if(!$material){
                                $material = new PreProductionProcessMaterial();
                                $material->pre_production_id = $request->pre_production_id;
                                $material->pre_production_process_id = $process->id;
                                $material->product_material_category_id = $request->product_material_category_id[$key];
                                $material->product_material_id = $request->product_material_id[$key];
                                $material->quantity = $request->quantity[$key];
                                $material->extra_quantity = $request->quantity[$key];
                                $material->save();

                                $material_id = $request->product_material_id[$key];
                                $quantity = $request->quantity[$key];
                                $category_id = $request->product_material_category_id[$key];
                                if(isset($uniqueProductMaterials[$material_id])) {
                                    $uniqueProductMaterials[$material_id]['quantity'] += $quantity;
                                } else {
                                    $uniqueProductMaterials[$material_id] = [
                                        'material_id' => $material_id,
                                        'category_id' => $category_id,
                                        'quantity' => $quantity,
                                    ];
                                }
                            }else{
                                $material->product_material_category_id = $request->product_material_category_id[$key];
                                $material->product_material_id = $request->product_material_id[$key];
                                $material->quantity += $request->quantity[$key];
                                $material->extra_quantity += $request->quantity[$key];
                                $material->save();

                                $material_id = $request->product_material_id[$key];
                                $quantity = $request->quantity[$key];
                                $category_id = $request->product_material_category_id[$key];
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
                        }else{
                            $board = PreProductionProcessBoard::where('pre_production_process_id', $request->process_id)
                                ->where('pre_production_id', $request->pre_production_id)
                                ->where('finished_board_category_id', $request->product_material_category_id[$key])
                                ->where('finished_board_id', $request->product_material_id[$key])
                                ->first();
                            if(!$board){
                                $board = new PreProductionProcessBoard();
                                $board->pre_production_id = $request->pre_production_id;
                                $board->pre_production_process_id = $process->id;
                                $board->finished_board_category_id = $request->product_material_category_id[$key];
                                $board->finished_board_id = $request->product_material_id[$key];
                                $board->quantity = $request->quantity[$key];
                                $board->extra_quantity = $request->quantity[$key];
                                $board->save();

                                $board_id = $request->product_material_id[$key];
                                $quantity = $request->quantity[$key];
                                $category_id = $request->product_material_category_id[$key];
                                if(isset($uniqueBoards[$board_id])) {
                                    $uniqueBoards[$board_id]['quantity'] += $quantity;
                                } else {
                                    $uniqueBoards[$board_id] = [
                                        'board_id' => $board_id,
                                        'category_id' => $category_id,
                                        'quantity' => $quantity,
                                    ];
                                }
                            }else{
                                $board->finished_board_category_id = $request->product_material_category_id[$key];
                                $board->finished_board_id = $request->product_material_id[$key];
                                $board->quantity += $request->quantity[$key];
                                $board->extra_quantity += $request->quantity[$key];
                                $board->save();

                                $board_id = $request->product_material_id[$key];
                                $quantity = $request->quantity[$key];
                                $category_id = $request->product_material_category_id[$key];
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
            }

            $pre_production = PreProduction::where('id', $request->pre_production_id)
                ->where('deleted', PreProduction::DELETED_NO)
                ->where('status', PreProduction::STATUS_ACTIVE)
                ->first();
            if (!$pre_production) {
                throw new \Exception("Pre Production not found");
            }
            $pre_production->delivery_status = PreProduction::DELIVERY_STATUS_PARTIAL;
            $pre_production->received_status = PreProduction::RECEIVED_STATUS_PARTIAL;
            $pre_production->scan_status = PreProduction::SCAN_STATUS_PARTIAL;
            $pre_production->updated_by = auth()->guard('production-staff')->user()->id;
            $pre_production->updated_at = now();
            $pre_production->save();

            foreach ($uniqueProductMaterials as $materialData) {
                if($materialData['category_id'] !="" && $materialData['material_id'] !="" && $materialData['quantity'] !=""){
                    $material = PreProductionMaterial::where('pre_production_id', $request->pre_production_id)
                        ->where('product_material_category_id', $materialData['category_id'])
                        ->where('product_material_id', $materialData['material_id'])
                        ->where('deleted', PreProductionMaterial::DELETED_NO)
                        ->where('status', PreProductionMaterial::STATUS_ACTIVE)
                        ->first();

                    if($material){
                        $material->quantity += $materialData['quantity'];
                        $material->extra_quantity += $materialData['quantity'];
                        $material->delivery_status = PreProductionMaterial::DELIVERY_STATUS_PARTIAL;
                        $material->received_status = PreProductionMaterial::RECEIVED_STATUS_PARTIAL;
                        $material->scan_status = PreProductionMaterial::SCAN_STATUS_PARTIAL;
                        $material->updated_by = auth()->guard('production-staff')->user()->id;
                        $material->updated_at = Carbon::now();
                        $material->save();
                    }else{
                        $material = new PreProductionMaterial();
                        $material->pre_production_id = $request->pre_production_id;
                        $material->product_material_category_id = $materialData['category_id'];
                        $material->product_material_id = $materialData['material_id'];
                        $material->quantity = $materialData['quantity'];
                        $material->extra_quantity = $materialData['quantity'];
                        $material->created_by = auth()->guard('production-staff')->user()->id;
                        $material->created_at = Carbon::now();
                        $material->updated_by = auth()->guard('production-staff')->user()->id;
                        $material->updated_at = Carbon::now();
                        $material->save();
                    }
                }
            }

            foreach ($uniqueBoards as $boardData) {
                if($boardData['category_id'] !="" && $boardData['board_id'] !="" && $boardData['quantity'] !=""){
                    $board = PreProductionBoard::where('pre_production_id', $request->pre_production_id)
                        ->where('finished_board_category_id', $boardData['category_id'])
                        ->where('finished_board_id', $boardData['board_id'])
                        ->where('deleted', PreProductionBoard::DELETED_NO)
                        ->where('status', PreProductionBoard::STATUS_ACTIVE)
                        ->first();

                    if($board){
                        $board->quantity += $boardData['quantity'];
                        $board->extra_quantity += $boardData['quantity'];
                        $board->delivery_status = PreProductionBoard::DELIVERY_STATUS_PARTIAL;
                        $board->received_status = PreProductionBoard::RECEIVED_STATUS_PARTIAL;
                        $board->scan_status = PreProductionBoard::SCAN_STATUS_PARTIAL;
                        $board->updated_by = auth()->guard('production-staff')->user()->id;
                        $board->updated_at = Carbon::now();
                        $board->save();
                    }else{
                        $board = new PreProductionBoard();
                        $board->pre_production_id = $request->pre_production_id;
                        $board->finished_board_category_id = $boardData['category_id'];
                        $board->finished_board_id = $boardData['board_id'];
                        $board->quantity = $boardData['quantity'];
                        $board->extra_quantity = $boardData['quantity'];
                        $board->created_by = auth()->guard('production-staff')->user()->id;
                        $board->created_at = Carbon::now();
                        $board->updated_by = auth()->guard('production-staff')->user()->id;
                        $board->updated_at = Carbon::now();
                        $board->save();
                    }
                }
            }

        }catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
        DB::commit();
    }
}
