<?php

namespace App\Http\Controllers\Inventory;
use App\Http\Controllers\BaseControllers\BackendController;
use App\Services\Inventory\PreProductionMaterialRequestService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Inventory\MaterialRequest\StoreMaterialRequest;
use Illuminate\Http\Request;
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;
use Picqer\Barcode\BarcodeGeneratorPNG;

class PreProductionMaterialRequestController extends BackendController
{
    private PreProductionMaterialRequestService $service;

    public function __construct()
    {
        $this->addBreadcrumbs('Dashboard', route('dashboard'), 'fa fa-home');
        $this->addBreadcrumbs('Material Request (Production)');

        $this->service = new PreProductionMaterialRequestService();
    }

    public function index()
    {
        $this->setPageTitle("Material Request (Production)");
        $this->setActiveMenu('inventory.material-request.index');
        return $this->view('inventory.material-request.index');
    }

    public function indexFiltered(Request $request)
    {
        $data = $this->service->indexFilteredData($request);
        $view = $this->view('inventory.material-request._index_filtered')
            ->with($data)
            ->render();
        return $this->returnAjaxSuccess(['view' => $view]);
    }

    public function getDocument($id)
    {
        try {
            $data = $this->service->getDocument($id);
            $view = $this->view('inventory.material-request.__document_modal_data')
                ->with($data)
                ->render();
            return $this->returnAjaxSuccess(['view' => $view]);
        }catch (\Exception $e) {
            return $this->returnAjaxError([],$e->getMessage());
        }
    }

    public function deliver($id)
    {
        $this->setPageTitle("Deliver Material Request (Production)");
        $this->setActiveMenu('inventory.material-request.deliver');
        $data = $this->service->deliverData($id);
        return $this->view('inventory.material-request.deliver')->with($data);
    }

    public function deliverStore(StoreMaterialRequest $request, $id){
        try {
            $this->service->deliverStoreData($request, $id);
        }catch (\Exception $e) {
            return $this->returnAjaxError([],$e->getMessage());
        }
        return $this->returnAjaxSuccess([], 'Delivered successfully');
    }

    public function details($id){
        $this->setPageTitle("Material Request (Production) Details");
        $this->setActiveMenu('inventory.material-request.deliver');

        $data = $this->service->detailsData($id);
        // return $data;
        return $this->view('inventory.material-request.delivery_details')->with($data);
    }

    public function getMaterials($id){
        $data = $this->service->getMaterialData($id);
        return $this->returnAjaxSuccess($data);
    }

    public function checkBarCode($material_id, $barcode, $count, $type){
        $data = $this->service->checkBarCode($material_id, $barcode, $count, $type);
        return $data;
    }

    public function barcodeDetails($id){
        $data = $this->service->barcodeDetails($id);

        $code_generator = new BarcodeGeneratorPNG();
        $product_materials = $data['product_materials'];
        $finished_boards = $data['finished_boards'];
        // return view('inventory.material-request.qrcode_print', compact(
        //     'product_materials',
        //     'code_generator'
        // ));
        $pdf = PDF::loadView('inventory.material-request.qrcode_print', compact(
            'product_materials',
            'code_generator',
            'finished_boards'
        ));
        $pdf->setPaper('a4');
        $pdf->setOrientation('portrait');
        $pdf->setOption('footer-center', "Powered By: Retinasoft | Hotline: +8801877756677 | http://www.retinasoft.com.bd");
        return $pdf->inline();
    }

    public function newerPickedMaterials(){
        $this->setPageTitle("Newer Picked Materials");
        $this->setActiveMenu('nothing');
        
        $data = $this->service->newerPickedMaterials();
        
        return $this->view('inventory.material-request.newer_picked_materials')->with($data);
    }
}
