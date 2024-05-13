<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\BaseControllers\BackendController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Inventory\FinishedGood\StoreProductReceiveRequest;
use App\Services\Inventory\ReceiveProductService;
use Illuminate\Http\Request;

class ReceiveProductController extends BackendController
{
    private ReceiveProductService $service;

    public function __construct()
    {
        $this->addBreadcrumbs('Inventory', route('dashboard'), 'fa fa-home');
        $this->addBreadcrumbs('Receive Products');
        $this->service = new ReceiveProductService();
    }

    public function index()
    {
        $this->setPageTitle("Receive Products");
        $this->setActiveMenu('inventory.receive-product.index');
        return  $this->view('inventory.receive-products.index');
    }

    public function indexFiltered(Request $request)
    {   
        try {
            $data = $this->service->indexFilteredData($request);
            return $this->returnAjaxSuccess(['view' => $data['view']], 'Data Fetch Successfully');
        }catch (\Exception $e) {
            return $this->returnAjaxError([],$e->getMessage());
        }
    }

    public function receive($id){
        $this->setPageTitle("Receive Products");
        $this->setActiveMenu('inventory.receive-product.index');
        $data = $this->service->receiveData($id);
        return $this->view('inventory.receive-products._receive')->with($data);
    }

    public function receiveStore(StoreProductReceiveRequest $request, $id){
        try {
            $this->service->receiveStoreData($request, $id);
        }catch (\Exception $e) {
            return $this->returnAjaxError([],$e->getMessage());
        }
        return $this->returnAjaxSuccess([], 'Dispatched successfully');
    }
}
