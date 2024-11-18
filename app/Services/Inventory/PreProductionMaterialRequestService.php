<?php

namespace App\Services\Inventory;

use App\Models\Inventory\ProductRequisition;
use App\Models\Inventory\ProductRequisitionDelivery;
use App\Models\Inventory\ProductRequisitionDeliveryDetails;
use App\Models\Inventory\ProductRequisitionDeliveryDetailsItem;
use App\Models\Inventory\ProductRequisitionDetails;
use App\Models\Procurements\ProductMaterialPurchaseDetails;
use App\Models\Production\NewerPickedProductHistory;
use App\Models\Production\PreProduction;
use App\Models\Production\PreProductionBoard;
use App\Models\Production\PreProductionBoardDelivery;
use App\Models\Production\PreProductionBoardDeliveryDetails;
use App\Models\Production\PreProductionBoardDeliveryDetailsItem;
use App\Models\Production\PreProductionMaterial;
use App\Models\Production\PreProductionMaterialDelivery;
use App\Models\Production\PreProductionMaterialDeliveryDetails;
use App\Models\Production\PreProductionMaterialDeliveryDetailsItems;
use App\Models\Products\FinishedGoods;
use App\Models\Products\ProductMaterial;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PreProductionMaterialRequestService
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
            case 'all':
                return $this->getAllPreProductions($request);
                break;
            case 'pending':
                return $this->getPendingPreProductions($request);
                break;
            case 'partial':
                return $this->getPartialPreProductions($request);
                break;
            case 'delivered':
                return $this->getDeliveredPreProductions($request);
                break;
        }
    }

    public function productRequisitionFilteredData($request)
    {
        $delivery_status = $request->status_filtered;
        $data['requisitions'] = ProductRequisition::where('deleted', ProductRequisition::DELETED_NO)
            ->where(function ($q) use($delivery_status){
                if($delivery_status == 'pending'){
                    $q->where('status', ProductRequisition::DELIVERY_STATUS_PENDING);
                }else if($delivery_status == 'partial'){
                    $q->where('status', ProductRequisition::RECEIVED_STATUS_PARTIALLY_RECEIVED);
                }else if($delivery_status == 'delivered'){
                    $q->where('status', ProductRequisition::DELIVERY_STATUS_DELIVERED);
                }
            })
            ->orderBy('id', 'desc')
            ->paginate($this->paginate_limit);
        
        return $data;
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

        return $data;
    }

    public function getPendingPreProductions($request){
        $keyword_filtered = $request->keyword_filtered??null;
        $data['pre_productions'] = PreProduction::where('deleted', PreProduction::DELETED_NO)
            ->where('is_verified', PreProduction::VERIFIED_YES)
            ->where('delivery_status', PreProduction::DELIVERY_STATUS_PENDING)
            ->where(function ($q) use ($keyword_filtered){
                if ($keyword_filtered !=''){
                    $q->where('pre_production_no', 'like', '%'.$keyword_filtered.'%');
                }
            })
            ->orderBy('id', 'desc')->paginate($this->paginate_limit);

        return $data;
    }

    public function getDeliveredPreProductions($request){
        $keyword_filtered = $request->keyword_filtered??null;
        $data['pre_productions'] = PreProduction::where('deleted', PreProduction::DELETED_NO)
            ->where('is_verified', PreProduction::VERIFIED_YES)
            ->where('delivery_status', PreProduction::DELIVERY_STATUS_DELIVERED)
            ->where(function ($q) use ($keyword_filtered){
                if ($keyword_filtered !=''){
                    $q->where('pre_production_no', 'like', '%'.$keyword_filtered.'%');
                }
            })
            ->orderBy('id', 'desc')->paginate($this->paginate_limit);

        return $data;
    }

    public function getPartialPreProductions($request){
        $keyword_filtered = $request->keyword_filtered??null;
        $data['pre_productions'] = PreProduction::where('deleted', PreProduction::DELETED_NO)
            ->where('is_verified', PreProduction::VERIFIED_YES)
            ->where('delivery_status', PreProduction::DELIVERY_STATUS_PARTIAL)
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

    public function detailsData($id){
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
        
        $data['board_deliveries'] = PreProductionBoardDelivery::where('deleted', PreProductionBoardDelivery::DELETED_NO)
            ->where('status', PreProductionBoardDelivery::STATUS_ACTIVE)
            ->where('pre_production_id', $id)
            ->get();

        $data['pre_production'] = $pre_production;
        return $data;
    }

    public function deliverData($id){
        $data['pre_production'] = PreProduction::where('deleted', PreProduction::DELETED_NO)
            ->where('status', PreProduction::STATUS_ACTIVE)
            ->where('id', $id)
            ->first();

        $data['materials'] = PreProductionMaterial::where('deleted', PreProductionMaterial::DELETED_NO)
            ->where('pre_production_id', $id)
            ->get();
        
        return $data;
    }
    
    public function deliverStoreData($request, $id){
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

            $has_other = 0;
            $has_board = 0;

            if (isset($request->pre_production_material_id) && is_array($request->pre_production_material_id) && count($request->pre_production_material_id) > 0) {
                foreach ($request->pre_production_material_id as $key => $pre_production_material_id) {
                    // if($request->barcode_count[$key] > 0 ){
                    //     if($request->type[$key] == 'other'){
                    //         $has_other = 1;
                    //     }else if($request->type[$key] == 'board'){
                    //         $has_board = 1;
                    //     }
                    
                    // }
                    if(isset($request->selected_qty[$key]) && is_array($request->selected_qty[$key])) {
                        foreach ($request->selected_qty[$key] as $selected_qty) {
                            if($selected_qty > 0){
                                if($request->type[$key] == 'other'){
                                    $has_other = 1;
                                }else if($request->type[$key] == 'board'){
                                    $has_board = 1;
                                }
                            }
                        }
                    }
                }
            }

            // dd("has_other: ".$has_other, "has_board: ".$has_board);
            // material delivery
            if($has_other == 1){
                $delivery = new PreProductionMaterialDelivery();
                $delivery->delivery_no = '';
                $delivery->delivery_date = Carbon::now();
                $delivery->pre_production_id = $pre_production->id;
                $delivery->created_by = auth()->user()->id;
                $delivery->created_at = Carbon::now();
                $delivery->updated_by = auth()->user()->id;
                $delivery->updated_at = Carbon::now();
                $delivery->save();
                $delivery->delivery_no = 1000 + $delivery->id;
                $delivery->save();
            }
            
            if($has_board == 1){
                $board_delivery = new PreProductionBoardDelivery();
                $board_delivery->delivery_no = '';
                $board_delivery->delivery_date = Carbon::now();
                $board_delivery->pre_production_id = $pre_production->id;
                $board_delivery->created_by = auth()->user()->id;
                $board_delivery->created_at = Carbon::now();
                $board_delivery->updated_by = auth()->user()->id;
                $board_delivery->updated_at = Carbon::now();
                $board_delivery->save();
                $board_delivery->delivery_no = 1000 + $board_delivery->id;
                $board_delivery->save();
            }

            $usedBarcodes = [];
            if (isset($request->pre_production_material_id) && is_array($request->pre_production_material_id) && count($request->pre_production_material_id) > 0) {
            
                foreach ($request->pre_production_material_id as $key => $pre_production_material_id) {
                    if($pre_production_material_id != '' && $request->product_material_id !='' && $request->total_quantity != ''){
                        //  && $request->barcode_count[$key] > 0
                        $selected_total_quantity = 0;
                        if(isset($request->selected_qty[$key]) && is_array($request->selected_qty[$key])) {
                            foreach ($request->selected_qty[$key] as $selected_qty) {
                                if($selected_qty > 0){
                                    $selected_total_quantity += $selected_qty;
                                }
                            }
                        }
                        if($selected_total_quantity <= 0){
                            continue;
                        }

                        $delivery_details = ($request->type[$key] === 'other') ? new PreProductionMaterialDeliveryDetails() : new PreProductionBoardDeliveryDetails();
                        $delivery_details->pre_production_id = $pre_production->id;

                        if($request->type[$key] == 'other'){
                            $delivery_details->pre_production_material_delivery_id = $delivery->id;
                            $delivery_details->pre_production_material_id = $pre_production_material_id;
                            $delivery_details->product_material_id = $request->product_material_id[$key];

                        }else{
                            $delivery_details->pre_production_board_delivery_id = $board_delivery->id;
                            $delivery_details->pre_production_board_id = $pre_production_material_id;
                            $delivery_details->finished_board_id = $request->product_material_id[$key];
                        }

                        $delivery_details->total_quantity = $request->total_quantity[$key];
                        $delivery_details->quantity = $selected_total_quantity;
                        $delivery_details->created_by = auth()->user()->id;
                        $delivery_details->created_at = Carbon::now();
                        $delivery_details->updated_by = auth()->user()->id;
                        $delivery_details->updated_at = Carbon::now();
                        $delivery_details->save();

                        // $production_materials = ($request->type[$key] === 'other') ? new PreProductionMaterial() : new PreProductionBoard();
                        $production_materials_model = ($request->type[$key] === 'other') ? PreProductionMaterial::class : PreProductionBoard::class;
                        $production_materials = $production_materials_model::find($pre_production_material_id);
                        $production_materials->delivered_qty = $production_materials->delivered_qty + $selected_total_quantity;
                        $production_materials->save();

                        $remaining_qtn = $request->total_quantity[$key] - $production_materials->delivered_qty;

                        if($production_materials->delivered_qty == 0){
                            $production_materials->delivery_status = $production_materials_model::DELIVERY_STATUS_PENDING;
                        } elseif($remaining_qtn != 0){
                            $production_materials->delivery_status = $production_materials_model::DELIVERY_STATUS_PARTIAL;
                        } else{
                            $production_materials->delivery_status = $production_materials_model::DELIVERY_STATUS_DELIVERED;
                        }
                        $production_materials->save();
                    }

                    if (isset($request->selected_qty[$key]) && is_array($request->selected_qty[$key]) && count($request->selected_qty[$key]) > 0) {
                        foreach ($request->selected_qty[$key] as $purchaseKey => $qty) {
                            if($qty > 0) {
                                $items = ($request->type[$key] === 'other') ? new PreProductionMaterialDeliveryDetailsItems() : new PreProductionBoardDeliveryDetailsItem();
                                $items->pre_production_id = $pre_production->id;

                                if($request->type[$key] == 'other'){
                                    $items->pre_production_material_delivery_id = $delivery->id;
                                    $items->pre_production_material_delivery_details_id = $delivery_details->id;
                                    $items->pre_production_material_id = $pre_production_material_id;
                                    $items->product_material_id = $request->product_material_id[$key];
                                    $items->product_material_purchase_details_id = $request->purchase_details_id[$key][$purchaseKey];
                                }else{
                                    $items->pre_production_board_delivery_id = $board_delivery->id;
                                    $items->pre_production_board_delivery_details_id = $delivery_details->id;
                                    $items->pre_production_board_id = $pre_production_material_id;
                                    $items->finished_board_id = $request->product_material_id[$key];
                                    $items->lot_production_id = $request->production_id[$key][$purchaseKey];
                                }

                                $items->quantity = $qty;
                                $items->save();

                                if($request->type[$key] == 'other'){
                                    $purchase_details = ProductMaterialPurchaseDetails::find($request->purchase_details_id[$key][$purchaseKey]);
                                    if($purchase_details){
                                        $purchase_details->used_qty = $purchase_details->used_qty + $qty;
                                        $purchase_details->available_qty = $purchase_details->available_qty - $qty;
                                        $purchase_details->save();
                                    }

                                    $material = ProductMaterial::find($items->product_material_id);
                                    if($material){
                                        $material->total_used_qty = $material->total_used_qty + $qty;
                                        $material->available_qty = $material->available_qty - $qty;
                                        $material->save();
                                    }

                                    $usedBarcodes[$items->product_material_purchase_details_id] = [
                                        'product_material_id' => $items->product_material_id,
                                        'product_material_purchase_details_id' => $items->product_material_purchase_details_id
                                    ];
                                }else{
                                    $purchase_details = PreProduction::find($request->production_id[$key][$purchaseKey]);
                                    if($purchase_details){
                                        $purchase_details->used_qty = $purchase_details->used_qty + 1;
                                        $purchase_details->available_qty = $purchase_details->available_qty - 1;
                                        $purchase_details->save();
                                    }
                                }
                            }
                        }
                    }
                    /*if (isset($request->product_material_purchase_details_id[$key]) && is_array($request->product_material_purchase_details_id[$key]) && count($request->product_material_purchase_details_id[$key]) > 0) {
                        foreach ($request->product_material_purchase_details_id[$key] as $purchaseKey => $purchase_details_id) {
                            if($purchase_details_id != ""){
                                $items = ($request->type[$key] === 'other') ? new PreProductionMaterialDeliveryDetailsItems() : new PreProductionBoardDeliveryDetailsItem();
                                $items->pre_production_id = $pre_production->id;
                                
                                if($request->type[$key] == 'other'){
                                    $items->pre_production_material_delivery_id = $delivery->id;
                                    $items->pre_production_material_delivery_details_id = $delivery_details->id;
                                    $items->pre_production_material_id = $pre_production_material_id;
                                    $items->product_material_id = $request->product_material_id[$key];
                                    $items->product_material_purchase_details_id = $purchase_details_id;
                                }else{
                                    $items->pre_production_board_delivery_id = $board_delivery->id;
                                    $items->pre_production_board_delivery_details_id = $delivery_details->id;
                                    $items->pre_production_board_id = $pre_production_material_id;
                                    $items->finished_board_id = $request->product_material_id[$key];
                                }
                                $items->barcode = $request->barcode[$key][$purchaseKey];
                                $items->save();

                                if($request->type[$key] == 'other'){
                                    $purchase_details = ProductMaterialPurchaseDetails::find($purchase_details_id);
                                    if($purchase_details){
                                        $purchase_details->used_qty = $purchase_details->used_qty + 1;
                                        $purchase_details->available_qty = $purchase_details->available_qty - 1;
                                        $purchase_details->save();
                                    }

                                    $material = ProductMaterial::find($items->product_material_id);
                                    if($material){
                                        $material->total_used_qty = $material->total_used_qty + 1;
                                        $material->available_qty = $material->available_qty - 1;
                                        $material->save();
                                    }

                                    $usedBarcodes[$items->product_material_purchase_details_id] = [
                                        'barcode' => $items->barcode,
                                        'product_material_id' => $items->product_material_id,
                                        'product_material_purchase_details_id' => $items->product_material_purchase_details_id
                                    ];
                                }else{
                                    $purchase_details = PreProduction::find($purchase_details_id);
                                    if($purchase_details){
                                        $purchase_details->used_qty = $purchase_details->used_qty + 1;
                                        $purchase_details->available_qty = $purchase_details->available_qty - 1;
                                        $purchase_details->save();
                                    }
                                }
                            }
                        }
                    }*/
                }

                foreach($usedBarcodes as $key => $usedBarcode){
                    //check is there any previous purchase has available qty
                    $has_previous_purchase = ProductMaterialPurchaseDetails::where('deleted', ProductMaterialPurchaseDetails::DELETED_NO)
                        ->where('product_material_id', $usedBarcode['product_material_id'])
                        ->where('available_qty', '>', 0)
                        ->where('id', '<', $usedBarcode['product_material_purchase_details_id'])
                        ->where('status', ProductMaterialPurchaseDetails::STATUS_ACTIVE)
                        ->first();
                    if($has_previous_purchase){
                        $newerPickedProductHistory = new NewerPickedProductHistory();
                        $newerPickedProductHistory->user_id = auth()->user()->id;
                        $newerPickedProductHistory->product_material_id = $usedBarcode['product_material_id'];
                        $newerPickedProductHistory->product_material_purchase_details_id = $usedBarcode['product_material_purchase_details_id'];
                        $newerPickedProductHistory->pre_production_material_delivery_details_id = $delivery_details->id;
                        $newerPickedProductHistory->picked_at = Carbon::now();
                        $newerPickedProductHistory->action_status = NewerPickedProductHistory::ACTION_STATUS_NOT_VIEWED;
                        $newerPickedProductHistory->status = NewerPickedProductHistory::STATUS_ACTIVE;
                        $newerPickedProductHistory->created_at = Carbon::now();
                        $newerPickedProductHistory->created_by = auth()->user()->id;
                        $newerPickedProductHistory->updated_at = Carbon::now();
                        $newerPickedProductHistory->updated_by = auth()->user()->id;
                        $newerPickedProductHistory->save();
                    }
                }
                

                $material_count = PreProductionMaterial::where('pre_production_id', $id)->count();
                $board_count = PreProductionBoard::where('pre_production_id', $id)->count();

                $delivered_material_count = PreProductionMaterial::where('pre_production_id', $id)
                    ->where('delivery_status', PreProductionMaterial::DELIVERY_STATUS_DELIVERED)
                    ->count();

                $delivered_board_count = PreProductionBoard::where('pre_production_id', $id)
                    ->where('delivery_status', PreProductionBoard::DELIVERY_STATUS_DELIVERED)
                    ->count();

                if ($material_count == $delivered_material_count && $board_count == $delivered_board_count) {
                    $pre_production->delivery_status = PreProduction::DELIVERY_STATUS_DELIVERED;
                }

                $processing_material_count = PreProductionMaterial::where('pre_production_id', $id)
                    ->where('delivery_status', PreProductionMaterial::DELIVERY_STATUS_PARTIAL)
                    ->exists();

                $processing_board_count = PreProductionBoard::where('pre_production_id', $id)
                    ->where('delivery_status', PreProductionBoard::DELIVERY_STATUS_PARTIAL)
                    ->exists();

                if ($processing_material_count || $processing_board_count || $material_count != $delivered_material_count || $board_count != $delivered_board_count) {
                    $pre_production->delivery_status = PreProduction::DELIVERY_STATUS_PARTIAL;
                }

                if($pre_production->scan_status == PreProduction::SCAN_STATUS_SCANNED){
                    $pre_production->scan_status = PreProduction::SCAN_STATUS_PARTIAL;
                }

                $pre_production->save();
            }
        }catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
        DB::commit();

    }


    public function getMaterialData($id){
        // $data['materials'] = PreProductionMaterial::where('deleted', PreProductionMaterial::DELETED_NO)
        //     ->where('pre_production_id', $id)
        //     ->with('category', 'product')
        //     ->get();

        $materials = PreProductionMaterial::where('deleted', PreProductionMaterial::DELETED_NO)
            ->where('pre_production_id', $id)
            ->with('category', 'product', 'product.availablePurchaseDetails', 'product.availablePurchaseDetails.materialPurchase')
            ->get();

        $board_materials = PreProductionBoard::where('deleted', PreProductionBoard::DELETED_NO)
            ->where('pre_production_id', $id)
            ->with('category', 'product', 'product.availableProductions')
            ->get();

        $processedMaterials = $materials->map(function ($material) {
            return [
                'type' => 'other',
                'material' => $material
            ];
        });

        $data['board_materials'] =$board_materials;

        $processedBoardMaterials = $board_materials->map(function ($boardMaterial) {
            return [
                'type' => 'board',
                'material' => $boardMaterial
            ];
        });

        $data['materials'] = $processedMaterials->concat($processedBoardMaterials)->toArray();        
        return $data;
    }

    public function checkBarCode($material_id, $barcode, $count, $type){

        if($type == 'other'){
            $is_valid_code = ProductMaterialPurchaseDetails::where('deleted', ProductMaterialPurchaseDetails::DELETED_NO)
                ->where('product_material_id', $material_id)
                ->where('barcode', $barcode)
                ->where('status', ProductMaterialPurchaseDetails::STATUS_ACTIVE)
                ->first();
            if(!$is_valid_code){
                throw new \Exception('Invalid Barcode');
            }else{
                if($is_valid_code->available_qty > $count){
                    $has_previous_purchase = ProductMaterialPurchaseDetails::where('deleted', ProductMaterialPurchaseDetails::DELETED_NO)
                        ->where('product_material_id', $material_id)
                        ->where('available_qty', '>', 0)
                        ->where('id', '<', $is_valid_code->id)
                        ->where('status', ProductMaterialPurchaseDetails::STATUS_ACTIVE)
                        ->first();
                    return [
                        'data' => $is_valid_code,
                        'has_previous_purchase' => $has_previous_purchase,
                        'status' => !empty($has_previous_purchase) ? 201 : 200
                    ];
                } else {
                    throw new \Exception('Barcode already used!');
                }
                // $data = ProductMaterialPurchaseDetails::where('deleted', ProductMaterialPurchaseDetails::DELETED_NO)
                //     ->where('product_material_id', $material_id)
                //     ->where('barcode', $barcode)
                //     ->where('available_qty', '>', $count)
                //     ->where('status', ProductMaterialPurchaseDetails::STATUS_ACTIVE)
                //     ->first();
                // if(!$data){
                //     throw new \Exception('Barcode already used!');
                // }
                // return $data;
            }
        }else if($type == 'board'){

            $is_valid_code = PreProduction::where('deleted', PreProduction::DELETED_NO)
                ->where('is_verified', PreProduction::VERIFIED_YES)
                ->where('type', PreProduction::TYPE_BOARD)
                ->where('pre_production_no', $barcode)
                ->where('status', PreProduction::STATUS_ACTIVE)
                ->first();

            if(!$is_valid_code){
                throw new \Exception('Invalid Barcode');
            }else{
                $data = PreProduction::where('deleted', PreProduction::DELETED_NO)
                    ->where('is_verified', PreProduction::VERIFIED_YES)
                    ->where('type', PreProduction::TYPE_BOARD)
                    ->where('pre_production_no', $barcode)
                    ->where('available_qty', '>', $count)
                    ->where('status', PreProduction::STATUS_ACTIVE)
                    ->first();
                if(!$data){
                    throw new \Exception('Barcode already used!');
                }
                return [
                    'data' => $data,
                    'status' => 200
                ];
            }
        }
    }

    public function barcodeDetails($id) {
        //find pre production
        $pre_production = PreProduction::where('deleted', PreProduction::DELETED_NO)
            ->where('id', $id)
            ->first();
        
        if(empty($pre_production)){
            throw new \Exception('Invalid Pre Production!');
        }

        $pre_production_product_materials = PreProductionMaterial::where('deleted', PreProductionMaterial::DELETED_NO)
            ->where('pre_production_id', $id)
            ->get();
        $product_material_ids = $pre_production_product_materials
            ->pluck('product_material_id')
            ->toArray();
        
        $data['product_materials'] = ProductMaterial::with('category')
            ->where('deleted', ProductMaterial::DELETED_NO)
            ->whereIn('id', $product_material_ids)
            ->get()
            ->map(function ($product_material) use ($pre_production_product_materials) {
                //get purchase details
                $purchase_details = ProductMaterialPurchaseDetails::with('materialPurchase')
                    ->where('deleted', ProductMaterialPurchaseDetails::DELETED_NO)
                    ->where('product_material_id', $product_material->id)
                    ->where('available_qty', '>', 0)
                    ->get();
                $product_material->purchase_details = $purchase_details;
                $product_material->pre_production_material = $pre_production_product_materials->where('product_material_id', $product_material->id)->first();
                return $product_material;
            });
        
        
        $pre_production_boards = PreProductionBoard::where('deleted', PreProductionBoard::DELETED_NO)
            ->where('pre_production_id', $id)
            ->get();
            
        $finished_borad_ids = $pre_production_boards
            ->pluck('finished_board_id')
            ->toArray();
        
        $data['finished_boards'] = FinishedGoods::with('finishedGoodsCategory')
            ->where('deleted', FinishedGoods::DELETED_NO)
            ->whereIn('id', $finished_borad_ids)
            ->get()
            ->map(function ($finished_board) use ($pre_production_boards) {
                //get purchase details
                $availableProductions = PreProduction::where('deleted', PreProduction::DELETED_NO)
                    ->where('finished_goods_id', $finished_board->id)
                    ->where('is_verified', PreProduction::VERIFIED_YES)
                    ->where('type', PreProduction::TYPE_BOARD)
                    ->where('available_qty', '>', 0)
                    ->where('status', PreProduction::STATUS_ACTIVE)
                    ->get();
                $finished_board->purchase_details = $availableProductions;
                $finished_board->pre_production_board = $pre_production_boards->where('finished_board_id', $finished_board->id)->first();
                return $finished_board;
            });
        
        return $data;
    }

    public function newerPickedMaterials() {
        $data['items'] = NewerPickedProductHistory::with(['productMaterial', 'productMaterialPurchaseDetails', 'user'])
            ->where('deleted', NewerPickedProductHistory::DELETED_NO)
            ->where('status', NewerPickedProductHistory::STATUS_ACTIVE)
            ->orderBy('id', 'DESC')
            ->get();

        return $data;
    }

    public function productMaterialDeliveryData($id) {
        $data['requisition'] = ProductRequisition::with('details')
            ->where('deleted', ProductRequisition::DELETED_NO)
            ->where('id', $id)
            ->first();

        return $data;
    }

    public function storeDeliverProductRequisition($request, $id) {
        // dd($request->all());
        DB::beginTransaction();
        try {
            $requisition = ProductRequisition::where('deleted', ProductRequisition::DELETED_NO)
                ->where('id', $id)
                ->first();

            if(!$requisition){
                throw new \Exception('Invalid Product Requisition!');
            }

            if(isset($request->purchase_details_id) && (is_array($request->purchase_details_id)) && (count($request->purchase_details_id) > 0)) {

                $delivery = new ProductRequisitionDelivery();
                $delivery->product_requisition_id = $requisition->id;
                $delivery->delivery_date = Carbon::now();
                $delivery->delivered_by = auth()->user()->id;
                $delivery->delivered_at = Carbon::now();
                $delivery->received_status = ProductRequisitionDelivery::RECEIVED_STATUS_PENDING;
                $delivery->status = ProductRequisitionDelivery::STATUS_ACTIVE;
                $delivery->created_at = Carbon::now();
                $delivery->created_by = auth()->user()->id;
                $delivery->updated_at = Carbon::now();
                $delivery->updated_by = auth()->user()->id;
                $delivery->save();
                $delivery->delivery_no = 1000 + $delivery->id;
                $delivery->save();

                foreach($request->purchase_details_id as $index => $purchase_details_ids) {
                    $itemDeliveredQty = 0;

                    $delivery_details = new ProductRequisitionDeliveryDetails();
                    $delivery_details->product_requisition_delivery_id = $delivery->id;
                    $delivery_details->product_requisition_id = $requisition->id;
                    $delivery_details->product_requisition_detail_id = $request->requisition_details_id[$index];
                    $delivery_details->product_id = $request->product_material_id[$index];
                    $delivery_details->delivered_qty = $itemDeliveredQty;
                    $delivery_details->received_qty = 0;
                    $delivery_details->received_status = ProductRequisitionDeliveryDetails::RECEIVED_STATUS_PENDING;
                    $delivery_details->status = ProductRequisitionDeliveryDetails::STATUS_ACTIVE;
                    $delivery_details->created_at = Carbon::now();
                    $delivery_details->created_by = auth()->user()->id;
                    $delivery_details->updated_at = Carbon::now();
                    $delivery_details->updated_by = auth()->user()->id;
                    $delivery_details->save();

                    foreach($purchase_details_ids as $innerIndex => $purchase_details_id) {
                        $qty = $request->selected_qty[$index][$innerIndex];

                        $purchase_details = ProductMaterialPurchaseDetails::where('deleted', ProductMaterialPurchaseDetails::DELETED_NO)
                            ->where('id', $purchase_details_id)
                            ->first();
                        if($purchase_details){
                            $purchase_details->used_qty = $purchase_details->used_qty + $qty;
                            $purchase_details->available_qty = $purchase_details->available_qty - $qty;
                            $purchase_details->save();

                            $delivery_details_item = new ProductRequisitionDeliveryDetailsItem();
                            $delivery_details_item->product_requisition_delivery_id = $delivery->id;
                            $delivery_details_item->product_requisition_delivery_details_id = $delivery_details->id;
                            $delivery_details_item->product_requisition_id = $requisition->id;
                            $delivery_details_item->product_requisition_detail_id = $request->requisition_details_id[$index];
                            $delivery_details_item->product_material_purchase_detail_id = $purchase_details_id;
                            $delivery_details_item->product_id = $request->product_material_id[$index];
                            $delivery_details_item->delivered_qty = $qty;
                            $delivery_details_item->received_qty = 0;
                            $delivery_details_item->received_status = ProductRequisitionDeliveryDetails::RECEIVED_STATUS_PENDING;
                            $delivery_details_item->status = ProductRequisitionDeliveryDetails::STATUS_ACTIVE;
                            $delivery_details_item->created_at = Carbon::now();
                            $delivery_details_item->created_by = auth()->user()->id;
                            $delivery_details_item->updated_at = Carbon::now();
                            $delivery_details_item->updated_by = auth()->user()->id;
                            $delivery_details_item->save();

                            $itemDeliveredQty += $qty;
                        }

                    }

                    $delivery_details->delivered_qty = $itemDeliveredQty;
                    $delivery_details->save();

                    $requisition_details = ProductRequisitionDetails::where('deleted', ProductRequisitionDetails::DELETED_NO)
                        ->where('id', $request->requisition_details_id[$index])
                        ->first();

                    $totalDeliveredQty = $requisition_details->delivered_qty + $itemDeliveredQty;
                    
                    $requisition_details->delivered_qty = $totalDeliveredQty;
                    if($totalDeliveredQty == $requisition_details->qty){
                        $requisition_details->delivery_status = ProductRequisitionDetails::DELIVERY_STATUS_DELIVERED;
                    } else {
                        $requisition_details->delivery_status = ProductRequisitionDetails::DELIVERY_STATUS_PARTIALLY_DELIVERED;
                    }
                    $requisition_details->save();
                }
            }

            //check if all requisition details are delivered
            $requisition_details = ProductRequisitionDetails::where('deleted', ProductRequisitionDetails::DELETED_NO)
                ->where('product_requisition_id', $requisition->id)
                ->where('delivery_status', '!=', ProductRequisitionDetails::DELIVERY_STATUS_DELIVERED)
                ->exists();

            if(!$requisition_details){
                $requisition->delivery_status = ProductRequisition::DELIVERY_STATUS_DELIVERED;
            } else {
                $requisition->delivery_status = ProductRequisition::DELIVERY_STATUS_PARTIALLY_DELIVERED;
            }
            $requisition->save();
            
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
        DB::commit();
    }

    public function getProductRequisitionMaterials($id) {
        $data['materials'] = ProductRequisitionDetails::with([
                'product', 
                'product.category', 
                'product.availablePurchaseDetails', 
                'product.availablePurchaseDetails.materialPurchase'
            ])
            ->where('product_requisition_id', $id)
            ->where('deleted', ProductRequisitionDetails::DELETED_NO)
            ->get();

        return $data;
    }
}
