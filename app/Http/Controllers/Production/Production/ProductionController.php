<?php

namespace App\Http\Controllers\Production\Production;

use App\Http\Controllers\BaseControllers\BackendController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Production\Production\StoreProductionReceiveRequest;
use App\Services\Production\Production\ProductionService;
use Illuminate\Http\Request;

class ProductionController extends BackendController
{
    private ProductionService $service;

    public function __construct()
    {
        $this->addBreadcrumbs('Dashboard', route('dashboard'), 'fa fa-home');
        $this->addBreadcrumbs('Production');

        $this->service = new ProductionService();
    }

    public function index()
    {
        $this->setPageTitle("Production");
        $this->setActiveMenu('production.production.index');
        return $this->view('production.production.index');
    }

    public function indexFiltered(Request $request)
    {
        $data = $this->service->indexFilteredData($request);
        return $this->returnAjaxSuccess(['view' => $data['view']], 'Data Fetch Successfully');
        // $view = $this->view('production.production._index_filtered')
        //     ->with($data)
        //     ->render();
        // return $this->returnAjaxSuccess(['view' => $view]);
    }

    public function getDocument($id)
    {
        try {
            $data = $this->service->getDocument($id);
            $view = $this->view('production.production.__document_modal_data')
                ->with($data)
                ->render();
            return $this->returnAjaxSuccess(['view' => $view]);
        }catch (\Exception $e) {
            return $this->returnAjaxError([],$e->getMessage());
        }
    }

    public function details($id){
        $this->setPageTitle("Production Details");
        $this->setActiveMenu('production.production.index');
        $data = $this->service->detailsData($id);
        return $this->view('production.production._details')->with($data);
    }

    public function receive($id){
        $this->setPageTitle("Receive Product");
        $this->setActiveMenu('production.production.index');
        $data = $this->service->receiveData($id);
        return $this->view('production.production._receive')->with($data);
    }

    public function receiveStore(StoreProductionReceiveRequest $request, $id){
        try {
            $this->service->receiveStoreData($request, $id);
        }catch (\Exception $e) {
            return $this->returnAjaxError([],$e->getMessage());
        }
        return $this->returnAjaxSuccess([], 'Delivered successfully');
    }

    public function getDeliveries($id){
        $data = $this->service->getDeliveryData($id);
        return $this->returnAjaxSuccess($data);
    }

    public function checkBarCode(Request $request, $id){
        $data = $this->service->checkBarCode($request, $id);
        return $data;
    }

}
