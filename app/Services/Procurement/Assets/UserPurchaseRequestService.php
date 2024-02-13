<?php

namespace App\Services\Procurement\Assets;

use App\Models\Procurements\AssetProductPurchaseRequest;
use App\Models\Procurements\AssetProductPurchaseRequestDetails;
use App\Models\Products\AssetProduct;
use App\Models\Products\AssetProductCategory;
use App\Services\Common\FileUploadService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class UserPurchaseRequestService
{
    public function __construct()
    {
        $this->paginate_limit = config('commonData.paginate_limit');
    }

    public function getAssetProducts($request)
    {
        $category_id = $request->category_id;
        $data['products'] = AssetProduct::where('asset_product_category_id', $category_id)
            ->where('deleted', AssetProduct::DELETED_NO)
            ->where('status', AssetProduct::STATUS_ACTIVE)
            ->orderBy('name', 'asc')
            ->get();

        return $data;
    }
    public function getNextRequestId(){
        $maxId = AssetProductPurchaseRequest::max('purchase_request_id');
        $numericPart = (int)substr($maxId, 3);
        $newId = 'PR-' . ($numericPart + 1);
        return $newId;

    }
    public function indexFilteredData($request)
    {
        $purchase_status = $request->status_filtered;

        switch ($purchase_status){
            case 'all_requests':
                return $this->getAllPurchaseRequests($request);
                break;
            case 'new_requests':
                return $this->getNewPurchaseRequests($request);
                break;
            case 'pending_requests':
                return $this->getPendingPurchaseRequests($request);
                break;
            case 'approved_requests':
                return $this->getApprovedPurchaseRequests($request);
                break;
            case 'declined_requests':
                return $this->getDeclinedPurchaseRequests($request);
                break;
        }
    }

    public function getAllPurchaseRequests($request)
    {
        $keyword_filtered = $request->keyword_filtered??null;
        $start_date_filtered = $request->start_date_filtered??null;
        $end_date_filtered = $request->end_date_filtered??null;

        $data['all_requests'] = AssetProductPurchaseRequest::where('deleted', AssetProductPurchaseRequest::DELETED_NO)
            ->where('status', AssetProductPurchaseRequest::STATUS_ACTIVE)
            ->where('requested_by', auth()->user()->id)
            ->where(function ($q) use($keyword_filtered){
                if($keyword_filtered != null){
                    $q->where('purchase_request_id', 'LIKE', '%'.$keyword_filtered.'%');
                }
            })
            ->where(function ($q) use($start_date_filtered,$end_date_filtered){
                if($start_date_filtered != null){
                    $q->whereDate('created_at', '>=', $start_date_filtered);
                }
                if($end_date_filtered != null){
                    $q->whereDate('created_at', '<=', $end_date_filtered);
                }
            })
            ->orderBy('request_status', 'ASC')
            ->orderBy('purchase_request_id', 'DESC')
            ->paginate($this->paginate_limit);

        $data['view'] = view('procurement.asset-purchase-request.user._index_filtered', $data)->render();

        return $data;
    }

    public function getNewPurchaseRequests($request)
    {
        $keyword_filtered = $request->keyword_filtered??null;
        $start_date_filtered = $request->start_date_filtered??null;
        $end_date_filtered = $request->end_date_filtered??null;

        $data['new_requests'] = AssetProductPurchaseRequest::where('deleted', AssetProductPurchaseRequest::DELETED_NO)
            ->where('request_status', AssetProductPurchaseRequest::REQUEST_STATUS_NEW)
            ->where('requested_by', auth()->user()->id)
            ->where(function ($q) use($keyword_filtered){
                if($keyword_filtered != null){
                    $q->where('purchase_request_id', 'LIKE', '%'.$keyword_filtered.'%');
                }
            })
            ->where(function ($q) use($start_date_filtered,$end_date_filtered){
                if($start_date_filtered != null){
                    $q->whereDate('created_at', '>=', $start_date_filtered);
                }
                if($end_date_filtered != null){
                    $q->whereDate('created_at', '<=', $end_date_filtered);
                }
            })
            ->orderBy('id', 'DESC')
            ->paginate($this->paginate_limit);

        $data['view'] = view('procurement.asset-purchase-request.user._new_index_filtered', $data)->render();

        return $data;
    }

    public function getPendingPurchaseRequests($request)
    {
        $keyword_filtered = $request->keyword_filtered??null;
        $start_date_filtered = $request->start_date_filtered??null;
        $end_date_filtered = $request->end_date_filtered??null;

        $data['pending_requests'] = AssetProductPurchaseRequest::where('deleted', AssetProductPurchaseRequest::DELETED_NO)
            ->where('requested_by', auth()->user()->id)
            ->whereIn('request_status', [
                AssetProductPurchaseRequest::REQUEST_STATUS_ADDITIONAL_INFO,
                AssetProductPurchaseRequest::REQUEST_STATUS_INFO_SUBMITTED
            ])
            ->where(function ($q) use($keyword_filtered){
                if($keyword_filtered != null){
                    $q->where('purchase_request_id', 'LIKE', '%'.$keyword_filtered.'%');
                }
            })
            ->where(function ($q) use($start_date_filtered,$end_date_filtered){
                if($start_date_filtered != null){
                    $q->whereDate('created_at', '>=', $start_date_filtered);
                }
                if($end_date_filtered != null){
                    $q->whereDate('created_at', '<=', $end_date_filtered);
                }
            })
            ->orderBy('id', 'DESC')
            ->paginate($this->paginate_limit);

        $data['view'] = view('procurement.asset-purchase-request.user._pending_index_filtered', $data)->render();

        return $data;
    }

    public function getApprovedPurchaseRequests($request)
    {
        $keyword_filtered = $request->keyword_filtered??null;
        $start_date_filtered = $request->start_date_filtered??null;
        $end_date_filtered = $request->end_date_filtered??null;

        $data['approved_requests'] = AssetProductPurchaseRequest::where('deleted', AssetProductPurchaseRequest::DELETED_NO)
            ->where('request_status', AssetProductPurchaseRequest::REQUEST_STATUS_APPROVED)
            ->where('requested_by', auth()->user()->id)
            ->where(function ($q) use($keyword_filtered){
                if($keyword_filtered != null){
                    $q->where('purchase_request_id', 'LIKE', '%'.$keyword_filtered.'%');
                }
            })
            ->where(function ($q) use($start_date_filtered,$end_date_filtered){
                if($start_date_filtered != null){
                    $q->whereDate('created_at', '>=', $start_date_filtered);
                }
                if($end_date_filtered != null){
                    $q->whereDate('created_at', '<=', $end_date_filtered);
                }
            })
            ->orderBy('id', 'DESC')
            ->paginate($this->paginate_limit);

        $data['view'] = view('procurement.asset-purchase-request.user._approved_index_filtered', $data)->render();

        return $data;
    }

    public function getDeclinedPurchaseRequests($request)
    {
        $keyword_filtered = $request->keyword_filtered??null;
        $start_date_filtered = $request->start_date_filtered??null;
        $end_date_filtered = $request->end_date_filtered??null;
        
        $data['declined_requests'] = AssetProductPurchaseRequest::where('deleted', AssetProductPurchaseRequest::DELETED_NO)
            ->where('request_status', AssetProductPurchaseRequest::REQUEST_STATUS_DECLINED)
            ->where('requested_by', auth()->user()->id)
            ->where(function ($q) use($keyword_filtered){
                if($keyword_filtered != null){
                    $q->where('purchase_request_id', 'LIKE', '%'.$keyword_filtered.'%');
                }
            })
            ->where(function ($q) use($start_date_filtered,$end_date_filtered){
                if($start_date_filtered != null){
                    $q->whereDate('created_at', '>=', $start_date_filtered);
                }
                if($end_date_filtered != null){
                    $q->whereDate('created_at', '<=', $end_date_filtered);
                }
            })
            ->orderBy('id', 'DESC')
            ->paginate($this->paginate_limit);

        $data['view'] = view('procurement.asset-purchase-request.user._declined_index_filtered', $data)->render();

        return $data;
    }

    public function createData(){
        $data['request_id'] = $this->getNextRequestId();
        $data['asset_categories'] = AssetProductCategory::where('deleted', AssetProductCategory::DELETED_NO)
            ->where('status', AssetProductCategory::STATUS_ACTIVE)
            ->orderBy('name', 'asc')->get();
        return $data;
    }

    public function store($request)
    {
        DB::beginTransaction();
        try {
            $purchase_request = new AssetProductPurchaseRequest();
            $purchase_request->title = $request->title;
            $purchase_request->purchase_request_id = '';
            $purchase_request->description = $request->note;
            $purchase_request->requested_by = auth()->user()->id;
            $purchase_request->created_by = auth()->user()->id;
            $purchase_request->created_at = Carbon::now();
            $purchase_request->updated_by = auth()->user()->id;
            $purchase_request->updated_at = Carbon::now();
            $purchase_request->save();
            $purchase_request->purchase_request_id = "PR-".(1000 + $purchase_request->id);
            $purchase_request->save();
          
            if (isset($request->asset_product_id) && is_array($request->asset_product_id) && count($request->asset_product_id) > 0) {
                foreach ($request->asset_product_id as $key=>$product_id) {
                    $image_path = null;
                    if ($request->hasFile('image') && isset($request->image[$key])) {
                        $imageUploadService = new FileUploadService();
                        $image_path = $imageUploadService->store($request->image[$key], 'procurement/assets_purchase_request');
                        $image_path = $image_path['path'];
                    }
                    $request_details = new AssetProductPurchaseRequestDetails();
                    $request_details->asset_product_purchase_request_id = $purchase_request->id;
                    $request_details->asset_product_category_id = $request->asset_product_category_id[$key];
                    $request_details->asset_product_id = $product_id;
                    $request_details->qty = $request->qty[$key];
                    $request_details->description = $request->description[$key];
                    $request_details->file = $image_path??null;
                    $request_details->created_by = auth()->user()->id;
                    $request_details->created_at = Carbon::now();
                    $request_details->updated_by = auth()->user()->id;
                    $request_details->updated_at = Carbon::now();
                    $request_details->save();
                }
            }
            
        }catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
        DB::commit();

    }

    public function editData($id){
        $data['asset_categories'] = AssetProductCategory::where('deleted', AssetProductCategory::DELETED_NO)
            ->where('status', AssetProductCategory::STATUS_ACTIVE)
            ->orderBy('name', 'asc')->get();

        $data['purchase_request'] = AssetProductPurchaseRequest::where('id', $id)
            ->where('deleted', AssetProductPurchaseRequest::DELETED_NO)
            ->where('status', AssetProductPurchaseRequest::STATUS_ACTIVE)
            ->first();
        if (empty($data['purchase_request'])) {
            return redirect()->back()->with(['failed' => 'Invalid Purchase Request!']);
        }

        return $data;
    }

    public function update($request, $id)
    {
        DB::beginTransaction();
        try {
            $purchase_request = AssetProductPurchaseRequest::find($id);
            if (empty($purchase_request)) {
                return redirect()->back()->with(['failed' => 'Invalid Purchase Request!']);
            }
            $purchase_request->title = $request->title;
            $purchase_request->description = $request->note;
            $purchase_request->updated_by = auth()->user()->id;
            $purchase_request->updated_at = Carbon::now();
            $purchase_request->save();

            if (isset($request->asset_product_id) && is_array($request->asset_product_id) && count($request->asset_product_id) > 0) {
                
                $request_details_ids = $request->puchase_details_id??[];
                $delete_item = AssetProductPurchaseRequestDetails::where('asset_product_purchase_request_id', $purchase_request->id)
                        ->whereNotIn('id', $request_details_ids)
                        ->delete();
                
                foreach ($request->asset_product_id as $key=>$product_id) {
                    
                    $image_path = null;
                    if ($request->hasFile('image') && isset($request->image[$key])) {
                        $imageUploadService = new FileUploadService();
                        $image_path = $imageUploadService->store($request->image[$key], 'procurement/assets_purchase_request');
                        $image_path = $image_path['path'];
                    }
                    if (isset($request->puchase_details_id[$key]) &&  $request->puchase_details_id[$key] != null){
                        // update
                        $request_details = AssetProductPurchaseRequestDetails::where('id', $request->puchase_details_id[$key])
                            ->where('asset_product_purchase_request_id', $purchase_request->id)
                            ->first();
                        if ($request_details){
                            $request_details->asset_product_category_id = $request->asset_product_category_id[$key];
                            $request_details->asset_product_id = $product_id;
                            $request_details->qty = $request->qty[$key];
                            $request_details->description = $request->description[$key];
                            $request_details->file = $image_path?? $request_details->image;
                            $request_details->updated_by = auth()->user()->id;
                            $request_details->updated_at = Carbon::now();
                            $request_details->save();
                        }
                    }else{
                        // create
                        $request_details = new AssetProductPurchaseRequestDetails();
                        $request_details->asset_product_purchase_request_id = $purchase_request->id;
                        $request_details->asset_product_category_id = $request->asset_product_category_id[$key];
                        $request_details->asset_product_id = $product_id;
                        $request_details->qty = $request->qty[$key];
                        $request_details->description = $request->description[$key];
                        $request_details->file = $image_path??null;
                        $request_details->created_by = auth()->user()->id;
                        $request_details->created_at = Carbon::now();
                        $request_details->updated_by = auth()->user()->id;
                        $request_details->updated_at = Carbon::now();
                        $request_details->save();
                    }
                }
            }
        }catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
        DB::commit();
    }

    public function addMoreInfo($id){
        $data['asset_categories'] = AssetProductCategory::where('deleted', AssetProductCategory::DELETED_NO)
            ->where('status', AssetProductCategory::STATUS_ACTIVE)
            ->orderBy('name', 'asc')->get();

        $data['purchase_request'] = AssetProductPurchaseRequest::where('id', $id)
            ->where('deleted', AssetProductPurchaseRequest::DELETED_NO)
            ->where('status', AssetProductPurchaseRequest::STATUS_ACTIVE)
            ->first();
        if (empty($data['purchase_request'])) {
            return redirect()->back()->with(['failed' => 'Invalid Purchase Request!']);
        }

        return $data;
    }

    public function storAddMoreInfo($request, $id)
    {
        DB::beginTransaction();
        try {
            $purchase_request = AssetProductPurchaseRequest::find($id);
            if (empty($purchase_request)) {
                return redirect()->back()->with(['failed' => 'Invalid Purchase Request!']);
            }
            $purchase_request->title = $request->title;
            $purchase_request->description = $request->note;
            $purchase_request->request_status = 4;
            $purchase_request->updated_by = auth()->user()->id;
            $purchase_request->updated_at = Carbon::now();
            $purchase_request->save();

            if (isset($request->asset_product_id) && is_array($request->asset_product_id) && count($request->asset_product_id) > 0) {
                
                $request_details_ids = $request->puchase_details_id??[];
                $delete_item = AssetProductPurchaseRequestDetails::where('asset_product_purchase_request_id', $purchase_request->id)
                        ->whereNotIn('id', $request_details_ids)
                        ->delete();
                
                foreach ($request->asset_product_id as $key=>$product_id) {
                    
                    $image_path = null;
                    if ($request->hasFile('image') && isset($request->image[$key])) {
                        $imageUploadService = new FileUploadService();
                        $image_path = $imageUploadService->store($request->image[$key], 'procurement/assets_purchase_request');
                        $image_path = $image_path['path'];
                    }
                    if (isset($request->puchase_details_id[$key]) &&  $request->puchase_details_id[$key] != null){
                        // update
                        $request_details = AssetProductPurchaseRequestDetails::where('id', $request->puchase_details_id[$key])
                            ->where('asset_product_purchase_request_id', $purchase_request->id)
                            ->first();
                        if ($request_details){
                            $request_details->asset_product_category_id = $request->asset_product_category_id[$key];
                            $request_details->asset_product_id = $product_id;
                            $request_details->qty = $request->qty[$key];
                            $request_details->description = $request->description[$key];
                            $request_details->file = $image_path?? $request_details->image;
                            $request_details->updated_by = auth()->user()->id;
                            $request_details->updated_at = Carbon::now();
                            $request_details->save();
                        }
                    }else{
                        // create
                        $request_details = new AssetProductPurchaseRequestDetails();
                        $request_details->asset_product_purchase_request_id = $purchase_request->id;
                        $request_details->asset_product_category_id = $request->asset_product_category_id[$key];
                        $request_details->asset_product_id = $product_id;
                        $request_details->qty = $request->qty[$key];
                        $request_details->description = $request->description[$key];
                        $request_details->file = $image_path??null;
                        $request_details->created_by = auth()->user()->id;
                        $request_details->created_at = Carbon::now();
                        $request_details->updated_by = auth()->user()->id;
                        $request_details->updated_at = Carbon::now();
                        $request_details->save();
                    }
                }
            }
        }catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
        DB::commit();
    }

    public function delete($id)
    {
        $asset_purchase = AssetProductPurchaseRequest::where('id', $id)
            ->where('deleted', AssetProductPurchaseRequest::DELETED_NO)
            ->first();
        if (!$asset_purchase) {
            throw new \Exception('Asset Purchase request not found');
        }
        $asset_purchase->deleted = AssetProductPurchaseRequest::DELETED_YES;
        $asset_purchase->deleted_by = auth()->user()->id;
        $asset_purchase->deleted_at = now();
        $asset_purchase->save();
    }
}
