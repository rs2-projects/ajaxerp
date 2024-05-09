<?php

namespace App\Services\Inventory;

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
use App\Models\Products\ProductMaterial;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PreProductionMaterialRequestService
{
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
                    if($request->barcode_count[$key] > 0 ){
                        if($request->type[$key] == 'other'){
                            $has_other = 1;
                        }else if($request->type[$key] == 'board'){
                            $has_board = 1;
                        }
                    
                    }
                }
            }

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

            if (isset($request->pre_production_material_id) && is_array($request->pre_production_material_id) && count($request->pre_production_material_id) > 0) {
            
                foreach ($request->pre_production_material_id as $key => $pre_production_material_id) {
                    if($pre_production_material_id != '' && $request->product_material_id !='' && $request->total_quantity != '' && $request->barcode_count[$key] > 0){
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
                        $delivery_details->quantity = $request->barcode_count[$key];
                        $delivery_details->created_by = auth()->user()->id;
                        $delivery_details->created_at = Carbon::now();
                        $delivery_details->updated_by = auth()->user()->id;
                        $delivery_details->updated_at = Carbon::now();
                        $delivery_details->save();

                        // $production_materials = ($request->type[$key] === 'other') ? new PreProductionMaterial() : new PreProductionBoard();
                        $production_materials_model = ($request->type[$key] === 'other') ? PreProductionMaterial::class : PreProductionBoard::class;
                        $production_materials = $production_materials_model::find($pre_production_material_id);
                        $production_materials->delivered_qty = $production_materials->delivered_qty + $request->barcode_count[$key];
                        $production_materials->save();

                        $remaining_qtn = $request->total_quantity[$key] - $production_materials->delivered_qty;

                        if($production_materials->delivered_qty == 0){
                            $production_materials->delivery_status = $production_materials_model::DELIVERY_STATUS_PENDING;
                        }else if($remaining_qtn != 0){
                            $production_materials->delivery_status = $production_materials_model::DELIVERY_STATUS_PARTIAL;
                            }else{
                            $production_materials->delivery_status = $production_materials_model::DELIVERY_STATUS_DELIVERED;
                        }
                        $production_materials->save();
                    }

                    if (isset($request->product_material_purchase_details_id[$key]) && is_array($request->product_material_purchase_details_id[$key]) && count($request->product_material_purchase_details_id[$key]) > 0) {
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

                if ($processing_material_count || $processing_board_count) {
                    $pre_production->delivery_status = PreProduction::DELIVERY_STATUS_PARTIAL;
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
            ->with('category', 'product')
            ->get();

        $board_materials = PreProductionBoard::where('deleted', PreProductionBoard::DELETED_NO)
            ->where('pre_production_id', $id)
            ->with('category', 'product')
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
        // $data = ProductMaterialPurchaseDetails::where('deleted', ProductMaterialPurchaseDetails::DELETED_NO)
        //     ->where('product_material_id', $material_id)
        //     ->where('barcode', $barcode)
        //     ->where('available_qty', '>', $count)
        //     ->where('status', ProductMaterialPurchaseDetails::STATUS_ACTIVE)
        //     ->first();


        if($type == 'other'){
            $is_valid_code = ProductMaterialPurchaseDetails::where('deleted', ProductMaterialPurchaseDetails::DELETED_NO)
                ->where('product_material_id', $material_id)
                ->where('barcode', $barcode)
                ->where('status', ProductMaterialPurchaseDetails::STATUS_ACTIVE)
                ->first();
            if(!$is_valid_code){
                throw new \Exception('Invalid Barcode');
            }else{
                $data = ProductMaterialPurchaseDetails::where('deleted', ProductMaterialPurchaseDetails::DELETED_NO)
                    ->where('product_material_id', $material_id)
                    ->where('barcode', $barcode)
                    ->where('available_qty', '>', $count)
                    ->where('status', ProductMaterialPurchaseDetails::STATUS_ACTIVE)
                    ->first();
                if(!$data){
                    throw new \Exception('Barcode already used!');
                }
                return $data;
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
                return $data;
            }
        }
    }
}
