<?php

namespace App\Http\Controllers\ProductionStaff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseControllers\BackendController;
use App\Http\Requests\ProductionStaff\Production\StoreProductionDispatchRequest;
use App\Http\Requests\ProductionStaff\Production\StoreProductionReceiveRequest;
use App\Http\Requests\ProductionStaff\Production\StoreProductionScanRequest;
use App\Models\Production\PreProduction;
use App\Services\ProductionStaff\ProductionService;
use Picqer\Barcode\BarcodeGeneratorPNG;
use PDF;

class ProductionController extends BackendController
{
    private ProductionService $service;

    public function __construct()
    {
        // $this->addBreadcrumbs('Dashboard', route('production-staff.dashboard'), 'fa fa-home');
        // $this->addBreadcrumbs('Production');

        $this->service = new ProductionService();
    }

    public function index()
    {
        $this->setPageTitle("Production");
        $this->setActiveMenu('production-staff.production.production.index');
        return $this->view('production-staff.production.index');
    }

    public function indexFiltered(Request $request)
    {
        $data = $this->service->indexFilteredData($request);
        return $this->returnAjaxSuccess(['view' => $data['view']], 'Data Fetch Successfully');
    }

    public function getDocument($id)
    {
        try {
            $data = $this->service->getDocument($id);
            $view = $this->view('production-staff.production.__document_modal_data')
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
        return $this->view('production-staff.production._details')->with($data);
    }

    public function changeProcessStatus($id,$processId, $status){
        try {
            $this->service->statusUpdateData($id, $processId, $status);
            // return redirect()->back()->with(['success' => 'Status Updated Successfully']);
            return $this->returnAjaxSuccess([], 'Status Updated Successfully');
        }catch (\Exception $e) {
            // return redirect()->back()->with(['failed' => $e->getMessage()]);
            return $this->returnAjaxError([], $e->getMessage());
        }
    }

    public function receive($id){
        $this->setPageTitle("Receive Product");
        $this->setActiveMenu('production.production.index');
        $data = $this->service->receiveData($id);
        return $this->view('production-staff.production._receive')->with($data);
    }

    public function receiveStore(StoreProductionReceiveRequest $request, $id){
        try {
            $this->service->receiveStoreData($request, $id);
            $data = $this->service->getDeliveryData($id);
        }catch (\Exception $e) {
            return $this->returnAjaxError([],$e->getMessage());
        }
        return $this->returnAjaxSuccess($data, 'Received successfully');
    }

    public function getDeliveries($id){
        $data = $this->service->getDeliveryData($id);
        return $this->returnAjaxSuccess($data);
    }

    public function checkBarCode(Request $request, $id){
        $data = $this->service->checkBarCode($request, $id);
        return $data;
    }

    public function getScanDeliveries($id){
        $data = $this->service->getDeliveryScanData($id);
        return $this->returnAjaxSuccess($data);
    }

    public function checkScanBarCode(Request $request, $id){
        $data = $this->service->checkScanBarCode($request, $id);
        return $data;
    }

    public function scanStore(StoreProductionScanRequest $request, $id){
        try {
            $this->service->scanStoreData($request, $id);
            $data = $this->service->getDeliveryScanData($id);
        }catch (\Exception $e) {
            return $this->returnAjaxError([],$e->getMessage());
        }
        return $this->returnAjaxSuccess($data, 'Scanned successfully');
    }

    public function dispatch($id){
        $this->setPageTitle("Production Dispatch");
        $this->setActiveMenu('production.production.index');
        $data = $this->service->dispatchData($id);
        return $this->view('production-staff.production._dispatch')->with($data);
    }

    public function dispatchStore(StoreProductionDispatchRequest $request, $id){
        try {
            $this->service->dispatchStoreData($request, $id);
        }catch (\Exception $e) {
            return $this->returnAjaxError([],$e->getMessage());
        }
        return $this->returnAjaxSuccess([], 'Dispatched successfully');
    }

    public function verifyOutput($id, $processId)
    {
        try {
            $data = $this->service->verifyOutputData($id, $processId);
            $view = $this->view('production-staff.production._verify_output_data')
                ->with($data)
                ->render();
            return $this->returnAjaxSuccess(['view' => $view]);
        }catch (\Exception $e) {
            return $this->returnAjaxError([],$e->getMessage());
        }
    }

    public function updateVerifyOutput($id, $type)
    {   
        try {
            $data = $this->service->updateVerifyOutput($id, $type);
            return $this->returnAjaxSuccess([$data], 'Verified Successfully');
        }catch (\Exception $e) {
            return $this->returnAjaxError([],$e->getMessage());
        }
    }

    public function getMaterialByCategory(Request $request){
        try {
            $data = $this->service->getMaterialByCategory($request);
            $view = $this->view('production-staff.production._get_material_by_category')->with($data)
                ->render();

            return $this->returnAjaxSuccess(['view' => $view]);
        }catch (\Exception $e) {
            return $this->returnAjaxError([],$e->getMessage());
        }
    }

    public function reRecuisitionStore(Request $request){

        try {
            $data = $this->service->reRecuisitionStore($request);
            return $this->returnAjaxSuccess([], 'Re-Recuisition Success');
        }catch (\Exception $e) {
            return $this->returnAjaxError([],$e->getMessage());
        }
    }


    public function printBarcode($id, $type){
        try {

            $production = PreProduction::where('deleted', PreProduction::DELETED_NO)
                ->where('status', PreProduction::STATUS_ACTIVE)
                ->where('id', $id)
                ->first();
            if (empty($production)) {
                return redirect()->back()->with(['failed' => 'Invalid Production!']);
            }

            $code_generator = new BarcodeGeneratorPNG();
            if($type == 'printer'){
                return view('production-staff.production.print-barcode-printer', compact(
                    'code_generator',
                    'production'
                ));
            }

            $pdf = PDF::loadView('production-staff.production.print-barcode-pdf', compact(
                'code_generator',
                'production'
            ));
            $pdf->setPaper('a4');
            $pdf->setOrientation('portrait');
            // $footer_text = CommonHelper::getInvoiceFooterText('');
            $pdf->setOption('footer-html', "Powered By: Retinasoft | Hotline: +8801877756677 | http://www.retinasoft.com.bd");
            return $pdf->inline();

        } catch (\Exception $exception) {
            return redirect()->back()->with(['failed' => $exception->getMessage()]);
        }
    }
}
