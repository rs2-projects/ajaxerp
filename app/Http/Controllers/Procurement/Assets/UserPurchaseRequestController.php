<?php

namespace App\Http\Controllers\Procurement\Assets;

use App\Http\Controllers\BaseControllers\BackendController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Procurement\Assets\UserPurchaseRequest\StoreUserPurchaseRequest;
use App\Services\Procurement\Assets\UserPurchaseRequestService;
use Illuminate\Http\Request;

class UserPurchaseRequestController extends BackendController
{
    private UserPurchaseRequestService $service;

    public function __construct()
    {
        $this->addBreadcrumbs('Procurement', route('dashboard'), 'fa fa-home');
        $this->addBreadcrumbs('Asset Purchase Request');
        
        $this->service = new UserPurchaseRequestService();
    }

    public function index()
    {
        $this->setPageTitle("Asset Purchase Request");
        $this->setActiveMenu('procurement.user.asset-purchase-request.index');
        // $data = $this->service->indexData();
        // return  $this->view('procurement.supplier.index')->with($data);
        return $this->view('procurement.asset-purchase-request.user.index');
    }

    public function getAssetProducts(Request $request)
    {
        $data = $this->service->getAssetProducts($request);
        $view = $this->view('procurement.asset-purchase-request.user.__product_options')
            ->with($data)
            ->render();

        return $this->returnAjaxSuccess(['view' => $view], 'Data Fetch Successfully');
    }

    public function indexFiltered(Request $request)
    {
        $data = $this->service->indexFilteredData($request);

        return $this->returnAjaxSuccess(['view' => $data['view']], 'Data Fetch Successfully');
    }

    public function create()
    {
        $this->setPageTitle("Asset Purchase Request");
        $this->setActiveMenu('procurement.user.asset-purchase-request.index');
        $data = $this->service->createData();
        return $this->view('procurement.asset-purchase-request.user._create_purchase_request')->with($data);
    }

    public function store(StoreUserPurchaseRequest $request)
    {
        try {
            $this->service->store($request);
        }catch (\Exception $e) {
            return $this->returnAjaxError([],$e->getMessage());
        }
        return $this->returnAjaxSuccess([], 'Asset Purchase Request created successfully');
    }
}
