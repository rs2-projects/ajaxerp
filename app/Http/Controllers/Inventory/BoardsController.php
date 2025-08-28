<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\BaseControllers\BackendController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Inventory\Board\StoreBoardRequest;
use App\Http\Requests\Inventory\Board\UpdateBoardRequest;
use App\Services\Inventory\BoardsService;
use Illuminate\Http\Request;
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;

class BoardsController extends BackendController
{
    private BoardsService $service;

    public function __construct()
    {
        $this->addBreadcrumbs('Inventory',route('inventory.boards.index'),'fa fa-home');
        $this->addBreadcrumbs('Boards');

        $this->service = new BoardsService();
    }

    public function index()
    {
        $this->setPageTitle("Boards");
        $this->setActivemenu('inventory.boards.index');
        $data = $this->service->indexData();
        return $this->view('inventory.boards.index')->with($data);
    }

    public function indexFiltered(Request $request)
    {
        $data = $this->service->indexFilteredData($request);
        $view = $this->view('inventory.boards._index_filtered')
            ->with($data)
            ->render();

        return $this->returnAjaxSuccess(['view' => $view]);
    }

    public function store(StoreBoardRequest $request)
    {
        try {
            $this->service->storeData($request);
        }catch (\Exception $e) {
            return $this->returnAjaxError([],$e->getMessage());
        }
        return $this->returnAjaxSuccess([], 'Board created successfully');
    }

    public function edit($id)
    {
        try {
            $this->setPageTitle("Edit Boards");
            $this->setActiveMenu('inventory.boards.index');
            $data = $this->service->editData($id);
            $view = $this->view('inventory.boards._edit_data')
                ->with($data)
                ->render();
            return $this->returnAjaxSuccess(['view' => $view]);
        }catch (\Exception $e) {
            return $this->returnAjaxError([],$e->getMessage());
        }
    }

    public function update(UpdateBoardRequest $request, $id)
    {
        try {
            $this->service->updateData($request, $id);
        }catch (\Exception $e) {
            return $this->returnAjaxError([],$e->getMessage());
        }
        return $this->returnAjaxSuccess([], 'Board updated successfully');
    }

    public function delete($id)
    {
        try {
            $this->service->deleteData($id);
        }catch (\Exception $e) {
            return $this->returnAjaxError([],$e->getMessage());
        }
        return $this->returnAjaxSuccess([], 'Board deleted successfully');
    }

    public function printQrCode(Request $request)
    {
        try {
            $data = $this->service->printQrCode($request);

            $pdf = PDF::loadView('inventory.boards._print_qrcode_pdf', compact('data'));
            $pdf->setPaper('a4');
            $pdf->setOrientation('portrait');
            $pdf->setOption('footer-center', "Powered By: Retinasoft | Hotline: +8801877756677 | http://www.retinasoft.com.bd");

            return $pdf->inline();
        } catch (\Exception $e) {
            return $this->returnAjaxError([], $e->getMessage());
        }

        return $this->returnAjaxSuccess([], 'QR Code printed successfully');
    }

}
