<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\BaseControllers\BackendController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Inventory\Board\StoreBoardRequest;
use App\Http\Requests\Inventory\Board\UpdateBoardRequest;
use App\Services\Inventory\BoardsService;
use Illuminate\Http\Request;

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
        $this->setActiveMenu('inventory.boards.index');

        return  $this->view('inventory.boards.index');
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
            $this->service->store($request);
        }catch (\Exception $e) {
            return $this->returnAjaxError([],$e->getMessage());
        }
        return $this->returnAjaxSuccess([], 'Board created successfully');
    }

    public function edit($id)
    {
        try {
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
            $this->service->update($request, $id);
        }catch (\Exception $e) {
            return $this->returnAjaxError([],$e->getMessage());
        }
        return $this->returnAjaxSuccess([], 'Board updated successfully');
    }

    public function delete($id)
    {
        try {
            $this->service->delete($id);
        }catch (\Exception $e) {
            return $this->returnAjaxError([],$e->getMessage());
        }
        return $this->returnAjaxSuccess([], 'Board deleted successfully');
    }
}
