<?php

namespace App\Http\Controllers\Production\BoardPreProduction;

use App\Http\Controllers\BaseControllers\BackendController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Production\BoardPreProduction\StoreCalculatePriceRequest;
use App\Services\Production\BoardPreProduction\CalculateBoardPriceService;
use Illuminate\Http\Request;

class CalculateBoardPriceController extends BackendController
{
    private CalculateBoardPriceService $service;

    public function __construct()
    {
        $this->addBreadcrumbs('Dashboard', route('dashboard'), 'fa fa-home');
        $this->addBreadcrumbs('Calculate Price');

        $this->service = new CalculateBoardPriceService();
    }

    // other prodcts start
    public function index($id)
    {
        try {
            $this->setPageTitle("Calculate Price");
            $this->setActiveMenu('production.board-pre-production.index');
            $data = $this->service->indexData($id);
        } catch (\Exception $e) {
            return redirect()->route('production.board-pre-production.index')->with('error', $e->getMessage());
        }
        return $this->view('production.board-pre-production.calculate_price')->with($data);
    }

    public function store(StoreCalculatePriceRequest $request, $id)
    {
        try {
            $this->service->storeData($request, $id);

            return $this->returnAjaxSuccess([], 'Price Calculated Successfully');
        } catch (\Exception $e) {
            return $this->returnAjaxError([],$e->getMessage());
        }
    }
}
