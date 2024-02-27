<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\BaseControllers\BackendController;
use App\Http\Requests\Inventory\FinishedGood\StoreFinishedGoodCategoryRequest;
use App\Http\Requests\Inventory\FinishedGood\UpdateFinishedGoodCategoryRequest;
use App\Services\Inventory\FinishedGoodCategoryService;
use Illuminate\Http\Request;


class FinishedGoodCategoryController extends BackendController
{
    private FinishedGoodCategoryService $service;

    public function __construct()
    {
        $this->addBreadcrumbs('Inventory', route('dashboard'), 'fa fa-home');
        $this->addBreadcrumbs('Finished Good Category');
        $this->service = new FinishedGoodCategoryService();
    }
    //filtered data show
    public function indexFiltered(Request $request)
    {
        $data = $this->service->indexFilteredData($request);
        $view = $this->view('inventory.finished-good.finished-good-category._index_filtered')
            ->with($data)
            ->render();
        return $this->returnAjaxSuccess(['view' => $view], 'Data Fetch Successfully');
    }
    public function index()
    {
        $this->setPageTitle("Finished Good Category");
        $this->setActiveMenu('inventory.finished-good-category.index');
        return  $this->view('inventory.finished-good.finished-good-category.index');
    }
    //store category data
    public function store(StoreFinishedGoodCategoryRequest $request)
    {
        try {
            $this->service->store($request);
        }catch (\Exception $e) {
            return $this->returnAjaxError([],$e->getMessage());
        }
        return $this->returnAjaxSuccess([], 'Finished Good Category created successfully');
    }
    // edit category data
    public function edit($id)
    {
        try {
            $data = $this->service->editData($id);
            $view = $this->view('inventory.finished-good.finished-good-category._edit_data')
                ->with($data)
                ->render();
            return $this->returnAjaxSuccess(['view' => $view]);
        }catch (\Exception $e) {
            return $this->returnAjaxError([],$e->getMessage());
        }
    }
    //update category data
    public function update(UpdateFinishedGoodCategoryRequest $request)
    {
        try {
            $this->service->update($request);
        }catch(\Exception $e){
            return $this->returnAjaxError([],$e->getMessage());
        }
        return $this->returnAjaxSuccess([], 'Finished Good Category Updated successfully');
    }
    //delete category
    public function delete($id)
    {
        try {
            $this->service->destroy($id);
        }catch(\Exception $e){
            return $this->returnAjaxError([],$e->getMessage());
        }
        return $this->returnAjaxSuccess([], 'Finished Good Category Deleted successfully');
    }
}
