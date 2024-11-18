<?php

namespace App\Services\ProductionStaff;

use App\Models\Inventory\ProductRequisition;
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


}
