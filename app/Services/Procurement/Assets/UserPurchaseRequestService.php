<?php

namespace App\Services\Procurement\Assets;

use App\Models\Procurements\AssetProductPurchaseRequest;
use App\Models\Procurements\AssetProductPurchaseRequestDetails;
use App\Models\Products\AssetProduct;
use App\Models\Products\AssetProductCategory;
use App\Services\Common\ImageUploadService;
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
        $data['all_requests'] = AssetProductPurchaseRequest::where('deleted', AssetProductPurchaseRequest::DELETED_NO)
            ->orderBy('request_status', 'ASC')
            ->paginate($this->paginate_limit);

        $data['view'] = view('procurement.asset-purchase-request.user._index_filtered', $data)->render();

        return $data;
    }

    public function getNewPurchaseRequests($request)
    {
        $data['new_requests'] = AssetProductPurchaseRequest::where('deleted', AssetProductPurchaseRequest::DELETED_NO)
            ->where('request_status', AssetProductPurchaseRequest::REQUEST_STATUS_NEW)
            ->orderBy('id', 'DESC')
            ->paginate($this->paginate_limit);

        $data['view'] = view('procurement.asset-purchase-request.user._new_index_filtered', $data)->render();

        return $data;
    }

    public function getPendingPurchaseRequests($request)
    {
        $data['pending_requests'] = AssetProductPurchaseRequest::where('deleted', AssetProductPurchaseRequest::DELETED_NO)
            ->whereIn('request_status', [
                AssetProductPurchaseRequest::REQUEST_STATUS_ADDITIONAL_INFO,
                AssetProductPurchaseRequest::REQUEST_STATUS_INFO_SUBMITTED
            ])
            ->orderBy('id', 'DESC')
            ->paginate($this->paginate_limit);

        $data['view'] = view('procurement.asset-purchase-request.user._pending_index_filtered', $data)->render();

        return $data;
    }

    public function getApprovedPurchaseRequests($request)
    {
        $data['approved_requests'] = AssetProductPurchaseRequest::where('deleted', AssetProductPurchaseRequest::DELETED_NO)
            ->where('request_status', AssetProductPurchaseRequest::REQUEST_STATUS_APPROVED)
            ->orderBy('id', 'DESC')
            ->paginate($this->paginate_limit);

        $data['view'] = view('procurement.asset-purchase-request.user._approved_index_filtered', $data)->render();

        return $data;
    }

    public function getDeclinedPurchaseRequests($request)
    {
        $data['declined_requests'] = AssetProductPurchaseRequest::where('deleted', AssetProductPurchaseRequest::DELETED_NO)
            ->where('request_status', AssetProductPurchaseRequest::REQUEST_STATUS_DECLINED)
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
            $purchase_request->description = $request->note;
            $purchase_request->requested_by = auth()->user()->id;
            $purchase_request->created_by = auth()->user()->id;
            $purchase_request->created_at = Carbon::now();
            $purchase_request->updated_by = auth()->user()->id;
            $purchase_request->updated_at = Carbon::now();
            $purchase_request->save();
            $purchase_request->purchase_request_id = "PR - ".(1000 + $purchase_request->id);
            $purchase_request->save();
          
            if (isset($request->asset_product_id) && is_array($request->asset_product_id) && count($request->asset_product_id) > 0) {
                foreach ($request->asset_product_id as $key=>$product_id) {
                    $image_path = null;
                    if ($request->hasFile('image') && isset($request->image[$key])) {
                        $imageUploadService = new ImageUploadService();
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
}
