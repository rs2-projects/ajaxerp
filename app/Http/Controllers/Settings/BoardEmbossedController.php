<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\BaseControllers\BackendController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\BoardEmbossed\StoreBoardEmbossedRequest;
use App\Http\Requests\Settings\BoardEmbossed\UpdateBoardEmbossedRequest;
use App\Services\Settings\BoardEmbossedService;
use Illuminate\Http\Request;

class BoardEmbossedController extends BackendController
{
    private BoardEmbossedService $service;

    public function __construct()
    {
        $this->addBreadcrumbs('Settings', route('settings.office-time'), 'fa fa-cog');
        $this->addBreadcrumbs('Board Embossed');

        $this->service = new BoardEmbossedService();
    }

    public function index()
    {
        $this->setPageTitle("Board Embossed");
        $this->setActiveMenu('settings.board-embossed.index');

        return  $this->view('settings.board-embossed.index');
    }

    public function indexFiltered(Request $request)
    {
        $data = $this->service->indexFilteredData($request);
        $view = $this->view('settings.board-embossed._index_filtered')
            ->with($data)
            ->render();

        return $this->returnAjaxSuccess(['view' => $view]);
    }

    public function store(StoreBoardEmbossedRequest $request)
    {
        try {
            $this->service->store($request);
        }catch (\Exception $e) {
            return $this->returnAjaxError([],$e->getMessage());
        }
        return $this->returnAjaxSuccess([], 'Board Embossed created successfully');
    }

    public function edit($id)
    {
        try {
            $data = $this->service->editData($id);
            $view = $this->view('settings.board-embossed._edit_data')
                ->with($data)
                ->render();
            return $this->returnAjaxSuccess(['view' => $view]);
        }catch (\Exception $e) {
            return $this->returnAjaxError([],$e->getMessage());
        }
    }

    public function update(UpdateBoardEmbossedRequest $request, $id)
    {
        try {
            $this->service->update($request, $id);
        }catch (\Exception $e) {
            return $this->returnAjaxError([],$e->getMessage());
        }
        return $this->returnAjaxSuccess([], 'Board Embossed updated successfully');
    }

    public function delete($id)
    {
        try {
            $this->service->delete($id);
        }catch (\Exception $e) {
            return $this->returnAjaxError([],$e->getMessage());
        }
        return $this->returnAjaxSuccess([], 'Board Embossed deleted successfully');
    }
}
