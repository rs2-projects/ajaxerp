<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\BaseControllers\BackendController;
use App\Services\Inventory\ReuseItemService;
use Illuminate\Http\Request;

class ReuseItemController extends BackendController
{
    private ReuseItemService $service;

    public function __construct()
    {
        $this->addBreadcrumbs('Inventory', route('dashboard'), 'fa fa-home');
        $this->addBreadcrumbs('Reuse Items');

        $this->service = new ReuseItemService();
    }

    public function index()
    {
        $this->setPageTitle("List");
        $this->setActiveMenu('inventory.reuse-items.index');
        $data = $this->service->indexData();
        return  $this->view('inventory.reuse-items.index')->with($data);
    }

    public function indexFiltered(Request $request)
    {
        $data = $this->service->indexFilteredData($request);
        $view = $this->view('inventory.reuse-items._index_filtered')
            ->with($data)
            ->render();

        return $this->returnAjaxSuccess(['view' => $view], 'Data Fetch Successfully');
    }

    public function details($id)
    {
        $data = $this->service->reuseItemDetailsData($id);
        $view = $this->view('inventory.reuse-items._details_modal_data')
            ->with($data)
            ->render();

        return $this->returnAjaxSuccess(['view' => $view], 'Data Fetch Successfully');
    }


}
