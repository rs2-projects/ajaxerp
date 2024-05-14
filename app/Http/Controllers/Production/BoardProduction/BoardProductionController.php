<?php

namespace App\Http\Controllers\Production\BoardProduction;

use App\Http\Controllers\BaseControllers\BackendController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Production\BoardProduction\StoreBoardProductionDispatchRequest;
use App\Http\Requests\Production\BoardProduction\StoreBoardProductionReceiveRequest;
use App\Models\Production\PreProduction;
use App\Services\Production\BoardProduction\BoardProductionService;
use Illuminate\Http\Request;
use Picqer\Barcode\BarcodeGeneratorPNG;
use PDF;

class BoardProductionController extends BackendController
{
    private BoardProductionService $service;

    public function __construct()
    {
        $this->addBreadcrumbs('Dashboard', route('dashboard'), 'fa fa-home');
        $this->addBreadcrumbs('Board Production');

        $this->service = new BoardProductionService();
    }

    public function index()
    {
        $this->setPageTitle("Board Production");
        $this->setActiveMenu('production.board-production.index');
        return $this->view('production.board-production.index');
    }

    public function indexFiltered(Request $request)
    {
        $data = $this->service->indexFilteredData($request);
        return $this->returnAjaxSuccess(['view' => $data['view']], 'Data Fetch Successfully');
    }

    public function details($id){
        $this->setPageTitle("Board Production Details");
        $this->setActiveMenu('production.board-production.index');
        $data = $this->service->detailsData($id);
        return $this->view('production.board-production._details')->with($data);
    }

    public function pendingVerification(){
        $this->setPageTitle("Pending Verification");
        $this->setActiveMenu('production.board-production.pending-verification');
        return $this->view('production.pending-board-production.index');
        
    }

    public function pendingVerificationData(Request $request){
        $data = $this->service->pendingVerificationData($request);
        return $this->returnAjaxSuccess(['view' => $data['view']], 'Data Fetch Successfully');
    }

    public function pendingDetails($id){
        $this->setPageTitle("Pending Verification Details");
        $this->setActiveMenu('production.board-production.pending-verification');
        $data = $this->service->pendingDetailsData($id);
        return $this->view('production.pending-board-production._details')->with($data);
    }

    public function statusUpdate($id, $status)
    {
        try {
            $data = $this->service->verificationStatusUpdate($id, $status);
            return $this->returnAjaxSuccess([$data], 'Status Update Successfully');
        }catch (\Exception $e) {
            return $this->returnAjaxError([],$e->getMessage());
        }
    }

    public function changeProcessStatus($id,$processId, $status){
        try {
            $this->service->statusUpdateData($id, $processId, $status);
            return $this->returnAjaxSuccess([], 'Status Updated Successfully');
        }catch (\Exception $e) {
            return $this->returnAjaxError([], $e->getMessage());
        }
    }

    public function receive($id){
        $this->setPageTitle("Receive Product");
        $this->setActiveMenu('production.board-production.index');
        $data = $this->service->receiveData($id);
        return $this->view('production.board-production._receive')->with($data);
    }

    public function receiveStore(StoreBoardProductionReceiveRequest $request, $id){
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

    public function dispatch($id){
        $this->setPageTitle("Board Production Dispatch");
        $this->setActiveMenu('production.board-production.index');
        $data = $this->service->dispatchData($id);
        return $this->view('production.board-production._dispatch')->with($data);
    }

    public function dispatchStore(StoreBoardProductionDispatchRequest $request, $id){
        try {
            $this->service->dispatchStoreData($request, $id);
        }catch (\Exception $e) {
            return $this->returnAjaxError([],$e->getMessage());
        }
        return $this->returnAjaxSuccess([], 'Dispatched successfully');
    }

    public function printBarcode($id, $type){
        try {

            $production = PreProduction::where('deleted', PreProduction::DELETED_NO)
                ->where('status', PreProduction::STATUS_ACTIVE)
                ->where('type', PreProduction::TYPE_BOARD)
                ->where('id', $id)
                ->first();
            if (empty($production)) {
                return redirect()->back()->with(['failed' => 'Invalid Production!']);
            }

            $code_generator = new BarcodeGeneratorPNG();
            if($type == 'printer'){
                return view('production.board-production.print-barcode-printer', compact(
                    'code_generator',
                    'production'
                ));
            }

            $pdf = PDF::loadView('production.board-production.print-barcode-pdf', compact(
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
