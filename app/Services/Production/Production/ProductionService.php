<?php

namespace App\Services\Production\Production;

use App\Models\Production\PreProduction;
use App\Models\Production\PreProductionMaterialDelivery;
use App\Models\Production\PreProductionMaterialDeliveryDetails;
use App\Models\Production\PreProductionMaterialDeliveryDetailsItems;

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
            case 'pre_production':
                return $this->getAllPreProductions($request);
                break;
            case 'pending_for_receive':
                return $this->getPendingForReceivePreProductions($request);
                break;
            // case 'on_process':
            //     return $this->getPartialPreProductions($request);
            //     break;
            // case 'completed':
            //     return $this->getDeliveredPreProductions($request);
            //     break;
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
                'delivery_details.items',
            )
            ->get();
        //$data['pre_production'] = $pre_production;
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

    }
}
