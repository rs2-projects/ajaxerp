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
