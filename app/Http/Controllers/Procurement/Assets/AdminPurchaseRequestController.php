<?php

namespace App\Http\Controllers\Procurement\Assets;

use App\Http\Controllers\BaseControllers\BackendController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Procurement\Assets\AdminPurchaseRequest\StoreAdminPurchaseRequest;
use App\Http\Requests\Procurement\Assets\AdminPurchaseRequest\UpdateAdminPurchaseRequest;
use App\Services\Procurement\Assets\AdminPurchaseRequestService;
use Illuminate\Http\Request;

class AdminPurchaseRequestController extends BackendController
{
    private AdminPurchaseRequestService $service;

    public function __construct()
    {
        $this->addBreadcrumbs('Procurement', route('dashboard'), 'fa fa-home');
        $this->addBreadcrumbs('Asset Purchase Request');
        
        $this->service = new AdminPurchaseRequestService();
    }

    public function index()
    {
        $this->setPageTitle("Asset Purchase Request");
        $this->setActiveMenu('procurement.admin.asset-purchase-request.index');
        return $this->view('procurement.asset-purchase-request.admin.index');
    }

    public function indexFiltered(Request $request)
    {
        $data = $this->service->indexFilteredData($request);

        return $this->returnAjaxSuccess(['view' => $data['view']], 'Data Fetch Successfully');
    }

    public function details($id)
    {
        try {
            $data = $this->service->detailsData($id);
            $view = $this->view('procurement.asset-purchase-request.admin.__purchase_request_details_data')
                ->with($data)
                ->render();
            return $this->returnAjaxSuccess(['view' => $view]);
        }catch (\Exception $e) {
            return $this->returnAjaxError([],$e->getMessage());
        }
    }

    public function storeRequestedInfo(UpdateAdminPurchaseRequest $request, $id)
    {
        try {
            $this->service->storeRequestedInfo($request, $id);
        }catch (\Exception $e) {
            return $this->returnAjaxError([],$e->getMessage());
        }
        return $this->returnAjaxSuccess([], 'Requested for additional purchase info');
    }

    public function approvedDetails($id)
    {
        try {
            $data = $this->service->detailsData($id);
            $view = $this->view('procurement.asset-purchase-request.admin.__make_purchase_order_data')
                ->with($data)
                ->render();
            return $this->returnAjaxSuccess(['view' => $view]);
        }catch (\Exception $e) {
            return $this->returnAjaxError([],$e->getMessage());
        }
    }

    public function approve($id)
    {
        try {
            $this->service->approve($id);
        }catch (\Exception $e) {
            return $this->returnAjaxError([],$e->getMessage());
        }
        return $this->returnAjaxSuccess([], 'Asset Purchase Request approved successfully');
    }

    public function decline($id)
    {
        try {
            $this->service->decline($id);
        }catch (\Exception $e) {
            return $this->returnAjaxError([],$e->getMessage());
        }
        return $this->returnAjaxSuccess([], 'Asset Purchase Request declined successfully');
    }

    public function delete($id)
    {
        try {
            $this->service->delete($id);
        }catch (\Exception $e) {
            return $this->returnAjaxError([],$e->getMessage());
        }
        return $this->returnAjaxSuccess([], 'Asset Purchase Request deleted successfully');
    }
}
