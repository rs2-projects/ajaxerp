<?php

namespace App\Services\ProductionStaff;

use App\Models\Inventory\ProductRequisition;
use App\Models\Inventory\ProductRequisitionDelivery;
use App\Models\Inventory\ProductRequisitionDeliveryDetails;
use App\Models\Inventory\ProductRequisitionDeliveryDetailsItem;
use App\Models\Inventory\ProductRequisitionDetails;
use App\Models\Products\FinishedGoodsCategory;
use App\Models\Products\ProductMaterialCategory;
use Illuminate\Support\Facades\DB;

class RequisitionService
{
    private $paginate_limit;
    public function __construct()
    {
        $this->paginate_limit = config('commonData.paginate_limit');
    }

    public function indexFiltered($request)
    {
        $authUser = auth()->guard('production-staff')->user();
        $data = [];
        $data['requisitions'] = ProductRequisition::where('production_staff_id', $authUser->id)
            ->where('status', ProductRequisition::STATUS_ACTIVE)
            ->paginate($this->paginate_limit);

        $data['view'] = view('production-staff.requisition._index_filtered', $data)->render();
        return $data;
    }

    public function createData()
    {
        $data['categories'] = ProductMaterialCategory::where('deleted', ProductMaterialCategory::DELETED_NO)
            ->where('status', ProductMaterialCategory::STATUS_ACTIVE)
            ->orderBy('id', 'desc')
            ->get();

        $data['finished_categoris'] = FinishedGoodsCategory::where('deleted', FinishedGoodsCategory::DELETED_NO)
            ->where('status', FinishedGoodsCategory::STATUS_ACTIVE)
            ->orderBy('id', 'desc')
            ->get();
        return $data;
    }

    public function store($request)
    {
        DB::beginTransaction();
        try {
            $authUser = auth()->guard('production-staff')->user();
    
            $requisition = new ProductRequisition();
            $requisition->production_staff_id = $authUser->id;
            $requisition->description = $request->description;
            $requisition->delivery_status = ProductRequisition::DELIVERY_STATUS_PENDING;
            $requisition->received_status = ProductRequisition::RECEIVED_STATUS_PENDING;
            $requisition->status = ProductRequisition::STATUS_ACTIVE;
            $requisition->created_at = now();
            $requisition->created_by = $authUser->id;
            $requisition->updated_at = now();
            $requisition->updated_by = $authUser->id;
            $requisition->save();
            $requisition->requisition_no = 'REQ-' . (10000 + $requisition->id);
            $requisition->save();

            if(isset($request->material_type) && (is_array($request->material_type) && (count($request->material_type) > 0))) {
                foreach($request->material_type as $key => $material_type) {
                    $details = new ProductRequisitionDetails();
                    $details->product_requisition_id = $requisition->id;
                    if($material_type == 'board') {
                        $material_type = ProductRequisitionDetails::PRODUCT_TYPE_BOARD;
                    } else {
                        $material_type = ProductRequisitionDetails::PRODUCT_TYPE_OTHERS;
                    }
                    $details->product_id = $request->product_material_id[$key];
                    $details->qty = $request->quantity[$key];
                    $details->delivered_qty = 0;
                    $details->delivery_status = ProductRequisitionDetails::DELIVERY_STATUS_PENDING;
                    $details->received_qty = 0;
                    $details->received_status = ProductRequisitionDetails::RECEIVED_STATUS_PENDING;
                    $details->status = ProductRequisitionDetails::STATUS_ACTIVE;
                    $details->created_at = now();
                    $details->created_by = $authUser->id;
                    $details->updated_at = now();
                    $details->updated_by = $authUser->id;
                    $details->save();
                }
            }
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
        DB::commit();
        return ['redirectUri' => route('production-staff.requisition.index')];
        
    }

    public function details($id)
    {
        $data['requisition'] = ProductRequisition::with(['details','details.product'])
            ->where('id', $id)
            ->where('status', ProductRequisition::STATUS_ACTIVE)
            ->first();
        return $data;
    }

    public function showReceive($id)
    {
        $data['requisition'] = ProductRequisition::where('id', $id)
            ->where('status', ProductRequisition::STATUS_ACTIVE)
            ->first();

        return $data;
    }

    public function storeReceive($request, $id) {
        // dd($request->all());
        DB::beginTransaction();
        try {
            $authUser = auth()->guard('production-staff')->user();

            $requisition = ProductRequisition::where('id', $id)
                ->where('status', ProductRequisition::STATUS_ACTIVE)
                ->first();

            if(!$requisition) {
                throw new \Exception("Requisition not found");
            }

            $delivery = ProductRequisitionDelivery::where('product_requisition_id', $id)
                ->where('id', $request->delivery_id)
                ->where('status', ProductRequisitionDelivery::STATUS_ACTIVE)
                ->first();
            
            if(!$delivery) {
                throw new \Exception("Delivery not found");
            }

            if(isset($request->selected_qty) && (is_array($request->selected_qty) && (count($request->selected_qty) > 0))) {
                foreach($request->selected_qty as $detailIndex => $selected_qty_arr) {
                    $deliveryDetails = ProductRequisitionDeliveryDetails::where('product_requisition_delivery_id', $delivery->id)
                        ->where('id', $request->delivery_details_id[$detailIndex])
                        ->where('status', ProductRequisitionDeliveryDetails::STATUS_ACTIVE)
                        ->first();
                    if(empty($deliveryDetails)) {
                        continue;
                    }

                    $requisitionDetails = ProductRequisitionDetails::where('product_requisition_id', $requisition->id)
                        ->where('id', $deliveryDetails->product_requisition_detail_id)
                        // ->where('product_id', $deliveryDetails->product_id)
                        ->where('status', ProductRequisitionDetails::STATUS_ACTIVE)
                        ->first();

                    $productReceivedQty = 0;
                    if(isset($selected_qty_arr) && (is_array($selected_qty_arr) && (count($selected_qty_arr) > 0))) {
                        foreach($selected_qty_arr as $itemIndex => $selected_qty) {
                            if($selected_qty <= 0) {
                                continue;
                            }
                            $deliveryDetailsItem = ProductRequisitionDeliveryDetailsItem::where('product_requisition_delivery_id', $delivery->id)
                                ->where('id', $request->delivery_item_id[$detailIndex][$itemIndex])
                                ->where('status', ProductRequisitionDeliveryDetailsItem::STATUS_ACTIVE)
                                ->first();

                            if(empty($deliveryDetailsItem)) {
                                continue;
                            }

                            $received_qty = $deliveryDetailsItem->received_qty + $selected_qty;
                            $deliveryDetailsItem->received_qty = $received_qty;
                            if($received_qty >= $deliveryDetailsItem->delivered_qty) {
                                $deliveryDetailsItem->received_status = ProductRequisitionDeliveryDetailsItem::RECEIVED_STATUS_RECEIVED;
                            } else {
                                $deliveryDetailsItem->received_status = ProductRequisitionDeliveryDetailsItem::RECEIVED_STATUS_PARTIALLY_RECEIVED;
                            }
                            $deliveryDetailsItem->updated_at = now();
                            $deliveryDetailsItem->updated_by = $authUser->id;
                            $deliveryDetailsItem->save();

                            $productReceivedQty += $selected_qty;
                        }
                    }

                    $totalReceivedQty = $deliveryDetails->received_qty + $productReceivedQty;
                    $deliveryDetails->received_qty = $totalReceivedQty;
                    if($totalReceivedQty >= $deliveryDetails->delivered_qty) {
                        $deliveryDetails->received_status = ProductRequisitionDeliveryDetails::RECEIVED_STATUS_RECEIVED;
                    } else {
                        $deliveryDetails->received_status = ProductRequisitionDeliveryDetails::RECEIVED_STATUS_PARTIALLY_RECEIVED;
                    }
                    $deliveryDetails->updated_at = now();
                    $deliveryDetails->updated_by = $authUser->id;
                    $deliveryDetails->save();


                    $requisitionDetails->received_qty += $productReceivedQty;
                    if($requisitionDetails->received_qty >= $requisitionDetails->qty) {
                        $requisitionDetails->received_status = ProductRequisitionDetails::RECEIVED_STATUS_RECEIVED;
                    } else {
                        $requisitionDetails->received_status = ProductRequisitionDetails::RECEIVED_STATUS_PARTIALLY_RECEIVED;
                    }
                    $requisitionDetails->updated_at = now();
                    $requisitionDetails->updated_by = $authUser->id;
                    $requisitionDetails->save();
                }
            }

            $hasPendingReceiveForDelivery = ProductRequisitionDeliveryDetails::where('product_requisition_delivery_id', $delivery->id)
                ->where('received_status', '!=', ProductRequisitionDeliveryDetails::RECEIVED_STATUS_RECEIVED)
                ->where('status', ProductRequisitionDeliveryDetails::STATUS_ACTIVE)
                ->count();
            if($hasPendingReceiveForDelivery == 0) {
                $delivery->received_status = ProductRequisitionDelivery::RECEIVED_STATUS_RECEIVED;
            } else {
                $delivery->received_status = ProductRequisitionDelivery::RECEIVED_STATUS_PARTIALLY_RECEIVED;
            }
            $delivery->updated_at = now();
            $delivery->updated_by = $authUser->id;
            $delivery->save();

            $hasPendingReceiveForRequisition = ProductRequisitionDetails::where('product_requisition_id', $requisition->id)
                ->where('received_status', '!=', ProductRequisitionDetails::RECEIVED_STATUS_RECEIVED)
                ->where('status', ProductRequisitionDetails::STATUS_ACTIVE)
                ->count();
            if($hasPendingReceiveForRequisition == 0) {
                $requisition->received_status = ProductRequisition::RECEIVED_STATUS_RECEIVED;
            } else {
                $requisition->received_status = ProductRequisition::RECEIVED_STATUS_PARTIALLY_RECEIVED;
            }
            $requisition->updated_at = now();
            $requisition->updated_by = $authUser->id;
            $requisition->save();

        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
        DB::commit();
        return ['redirectUri' => route('production-staff.requisition.details', $requisition->id)];
    }

    public function getDeliveryData($id)
    {
        $data['requisition'] = ProductRequisition::where('id', $id)
            ->where('status', ProductRequisition::STATUS_ACTIVE)
            ->first();

        $data['details'] = ProductRequisitionDetails::with('product')
            ->where('product_requisition_id', $id)
            ->where('status', ProductRequisitionDetails::STATUS_ACTIVE)
            ->get();

        $data['deliveries'] = ProductRequisitionDelivery::with([
                'details',
                'details.pendingItems',
                'details.pendingItems.purchaseDetail',
                'details.pendingItems.purchaseDetail.materialPurchase',
                'details.product',
                'details.product.category',
            ])
            ->where('product_requisition_id', $id)
            ->where('status', ProductRequisitionDelivery::STATUS_ACTIVE)
            ->get();

        return $data;
    }

}
