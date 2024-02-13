<?php

namespace App\Services\Procurement\Assets;

use App\Models\Procurements\AssetProductPurchaseRequest;
use App\Models\Procurements\AssetProductPurchaseRequestDetails;
use App\Models\Products\AssetProduct;
use App\Models\Products\AssetProductCategory;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AdminPurchaseRequestService
{
    public function __construct()
    {
        $this->paginate_limit = config('commonData.paginate_limit');
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
            case 'requested_info':
                return $this->getRequestedInfoPurchaseRequests($request);
                break;
            case 'info_submitted':
                return $this->getInfoSubmittedPurchaseRequests($request);
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

        $data['view'] = view('procurement.asset-purchase-request.admin._index_filtered', $data)->render();

        return $data;
    }

    public function getNewPurchaseRequests($request)
    {
        $keyword_filtered = $request->keyword_filtered??null;
        $start_date_filtered = $request->start_date_filtered??null;
        $end_date_filtered = $request->end_date_filtered??null;

        $data['new_requests'] = AssetProductPurchaseRequest::where('deleted', AssetProductPurchaseRequest::DELETED_NO)
            ->where('request_status', AssetProductPurchaseRequest::REQUEST_STATUS_NEW)
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

        $data['view'] = view('procurement.asset-purchase-request.admin._new_index_filtered', $data)->render();

        return $data;
    }

    public function getRequestedInfoPurchaseRequests($request)
    {
        $keyword_filtered = $request->keyword_filtered??null;
        $start_date_filtered = $request->start_date_filtered??null;
        $end_date_filtered = $request->end_date_filtered??null;

        $data['requested_info'] = AssetProductPurchaseRequest::where('deleted', AssetProductPurchaseRequest::DELETED_NO)
            ->where('request_status', AssetProductPurchaseRequest::REQUEST_STATUS_ADDITIONAL_INFO)
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

        $data['view'] = view('procurement.asset-purchase-request.admin._requested_info_index_filtered', $data)->render();

        return $data;
    }

    public function getInfoSubmittedPurchaseRequests($request)
    {
        $keyword_filtered = $request->keyword_filtered??null;
        $start_date_filtered = $request->start_date_filtered??null;
        $end_date_filtered = $request->end_date_filtered??null;

        $data['requested_info'] = AssetProductPurchaseRequest::where('deleted', AssetProductPurchaseRequest::DELETED_NO)
            ->where('request_status', AssetProductPurchaseRequest::REQUEST_STATUS_INFO_SUBMITTED)
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

        $data['view'] = view('procurement.asset-purchase-request.admin._info_submitted_index_filtered', $data)->render();

        return $data;
    }

    public function getApprovedPurchaseRequests($request)
    {
        $keyword_filtered = $request->keyword_filtered??null;
        $start_date_filtered = $request->start_date_filtered??null;
        $end_date_filtered = $request->end_date_filtered??null;

        $data['approved_requests'] = AssetProductPurchaseRequest::where('deleted', AssetProductPurchaseRequest::DELETED_NO)
            ->where('request_status', AssetProductPurchaseRequest::REQUEST_STATUS_APPROVED)
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

        $data['view'] = view('procurement.asset-purchase-request.admin._approved_index_filtered', $data)->render();

        return $data;
    }

    public function getDeclinedPurchaseRequests($request)
    {
        $keyword_filtered = $request->keyword_filtered??null;
        $start_date_filtered = $request->start_date_filtered??null;
        $end_date_filtered = $request->end_date_filtered??null;
        
        $data['declined_requests'] = AssetProductPurchaseRequest::where('deleted', AssetProductPurchaseRequest::DELETED_NO)
            ->where('request_status', AssetProductPurchaseRequest::REQUEST_STATUS_DECLINED)
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

        $data['view'] = view('procurement.asset-purchase-request.admin._declined_index_filtered', $data)->render();

        return $data;
    }

    public function detailsData($id)
    {
        $data['request_details'] = AssetProductPurchaseRequest::where('id', $id)
            ->where('deleted', AssetProductPurchaseRequest::DELETED_NO)
            ->first();
        if (!$data['request_details']) {
            throw new \Exception('Asset Purchase Request not found');
        }
        return $data;
    }

    public function storeRequestedInfo($request)
    {
        $purchase_request = AssetProductPurchaseRequest::where('id', $request->request_id)
            ->where('deleted', AssetProductPurchaseRequest::DELETED_NO)
            ->first();
        if (!$purchase_request) {
            throw new \Exception('Asset Purchase Request not found');
        }
        $purchase_request->additional_info = $request->additional_info;
        $purchase_request->request_status = 3;
        $purchase_request->updated_by = auth()->user()->id;
        $purchase_request->updated_at = now();
        $purchase_request->save();
    }

    // public function approvedDetails($id)
    // {
    //     $data['request_details'] = AssetProductPurchaseRequest::where('id', $id)
    //         ->where('deleted', AssetProductPurchaseRequest::DELETED_NO)
    //         ->first();
    //     if (!$data['request_details']) {
    //         throw new \Exception('Asset Purchase Request not found');
    //     }
    //     return $data;
    // }

    public function decline($id)
    {
        $purchase_request = AssetProductPurchaseRequest::where('id', $id)
            ->where('deleted', AssetProductPurchaseRequest::DELETED_NO)
            ->first();
        if (!$purchase_request) {
            throw new \Exception('Asset Purchase Request not found');
        }
        $purchase_request->request_status = 2;
        $purchase_request->updated_by = auth()->user()->id;
        $purchase_request->updated_at = now();
        $purchase_request->save();
    }

    public function approve($id)
    {
        $purchase_request = AssetProductPurchaseRequest::where('id', $id)
            ->where('deleted', AssetProductPurchaseRequest::DELETED_NO)
            ->first();
        if (!$purchase_request) {
            throw new \Exception('Asset Purchase Request not found');
        }
        $purchase_request->request_status = 1;
        $purchase_request->updated_by = auth()->user()->id;
        $purchase_request->updated_at = now();
        $purchase_request->save();
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
