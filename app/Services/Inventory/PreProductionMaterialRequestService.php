<?php

namespace App\Services\Inventory;

use App\Models\Procurements\ProductMaterialPurchaseDetails;
use App\Models\Production\PreProduction;
use App\Models\Production\PreProductionMaterial;
use App\Models\Production\PreProductionMaterialDelivery;
use App\Models\Production\PreProductionMaterialDeliveryDetails;
use App\Models\Production\PreProductionMaterialDeliveryDetailsItems;
use Carbon\Carbon;

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
        $pre_production = PreProduction::where('deleted', PreProduction::DELETED_NO)
            ->where('status', PreProduction::STATUS_ACTIVE)
            ->where('id', $id)
            ->first();
        if(!$pre_production){
            throw new \Exception('Pre Production not found');
        }

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


        if (isset($request->pre_production_material_id) && is_array($request->pre_production_material_id) && count($request->pre_production_material_id) > 0) {
            
            $is_delivered = true;

            foreach ($request->pre_production_material_id as $key => $pre_production_material_id) {
                if($pre_production_material_id != '' && $request->product_material_id !='' && $request->total_quantity != '' && $request->barcode_count[$key] > 0){
                    
                    $delivery_details = new PreProductionMaterialDeliveryDetails();
                    $delivery_details->pre_production_id = $pre_production->id;
                    $delivery_details->pre_production_material_delivery_id = $delivery->id;
                    $delivery_details->pre_production_material_id = $pre_production_material_id;
                    $delivery_details->product_material_id = $request->product_material_id[$key];
                    $delivery_details->total_quantity = $request->total_quantity[$key];
                    $delivery_details->quantity = $request->barcode_count[$key];
                    $delivery_details->created_by = auth()->user()->id;
                    $delivery_details->created_at = Carbon::now();
                    $delivery_details->updated_by = auth()->user()->id;
                    $delivery_details->updated_at = Carbon::now();
                    $delivery_details->save();

                    $production_materials = PreProductionMaterial::find($pre_production_material_id);
                    $production_materials->delivered_qty = $production_materials->delivered_qty + $request->barcode_count[$key];
                    $production_materials->save();
                }

                $material = PreProductionMaterial::find($pre_production_material_id);

                $remaining_qtn = $request->total_quantity[$key] - $material->delivered_qty;
                if ($remaining_qtn !== 0) {
                    $is_delivered = false;
                }else{
                    $is_delivered = true;
                }

                if (isset($request->product_material_purchase_details_id[$key]) && is_array($request->product_material_purchase_details_id[$key]) && count($request->product_material_purchase_details_id[$key]) > 0) {
                    foreach ($request->product_material_purchase_details_id[$key] as $purchaseKey => $purchase_details_id) {
                        if($purchase_details_id != ""){
                            $items = new PreProductionMaterialDeliveryDetailsItems();
                            $items->pre_production_id = $pre_production->id;
                            $items->pre_production_material_delivery_id = $delivery->id;
                            $items->pre_production_material_delivery_details_id = $delivery_details->id;
                            $items->pre_production_material_id = $pre_production_material_id;
                            $items->product_material_id = $request->product_material_id[$key];
                            $items->product_material_purchase_details_id = $purchase_details_id;
                            $items->barcode = $request->barcode[$key][$purchaseKey];
                            $items->save();

                            $purchase_details = ProductMaterialPurchaseDetails::find($purchase_details_id);
                            if($purchase_details){
                                $purchase_details->used_qty = $purchase_details->used_qty + 1;
                                $purchase_details->available_qty = $purchase_details->available_qty - 1;
                                $purchase_details->save();
                            }
                        }
                    }
                }
            }

            if ($is_delivered) {
                $pre_production->delivery_status = 1;
                $pre_production->save();
            }else{
                $pre_production->delivery_status = 2;
                $pre_production->save();
            }
        }
    }

    public function getMaterialData($id){
        $data['materials'] = PreProductionMaterial::where('deleted', PreProductionMaterial::DELETED_NO)
            ->where('pre_production_id', $id)
            ->with('category', 'product')
            ->get();
        
        return $data;
    }

    public function checkBarCode($material_id, $barcode, $count){
        $data = ProductMaterialPurchaseDetails::where('deleted', ProductMaterialPurchaseDetails::DELETED_NO)
            ->where('product_material_id', $material_id)
            ->where('barcode', $barcode)
            ->where('available_qty', '>', $count)
            ->where('status', ProductMaterialPurchaseDetails::STATUS_ACTIVE)
            ->first();  
        return $data;
    }
}
