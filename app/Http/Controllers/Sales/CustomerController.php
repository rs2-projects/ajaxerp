<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\BaseControllers\BackendController;
use App\Http\Requests\Sales\StoreCustomerRequest;
use App\Http\Requests\Sales\UpdateCustomerRequest;
use App\Services\Sales\Customer\CustomerService;
use Illuminate\Http\Request;


class CustomerController extends BackendController
{
    private CustomerService $service;
    public function __construct()
    {
        $this->addBreadcrumbs('Sales', route('sales.customer.index'), 'fa fa-home');
        $this->addBreadcrumbs('Customer');
        $this->service = new CustomerService();
    }
    //index
    public function index(){
        $this->setPageTitle('Customers');
        $this->setActiveMenu('sales.customer.index');
        $data = $this->service->indexData();
        return $this->view('sales.customer.index')->with($data);
    }
    //index filtered data
    public function indexFiltered(Request $request){
        $data = $this->service->indexFilteredData($request);
        $view = $this->view('sales.customer._index_filtered')
            ->with($data)
            ->render();
        return $this->returnAjaxSuccess(['view' => $view]);
    }

    //get state by country
    public function getStatesByCountry(Request $request)
    {
        $data = $this->service->getStatesByCountry($request);
        $view = $this->view('sales.customer.__state_options')
            ->with($data)
            ->render();

        return $this->returnAjaxSuccess(['view' => $view], 'Data Fetch Successfully');
    }
    //store customer data
    public function store(StoreCustomerRequest $request)
    {
        try {
            $this->service->store($request);
        }catch (\Exception $e) {
            return $this->returnAjaxError([],$e->getMessage());
        }
        return $this->returnAjaxSuccess([], 'Customer created successfully');
    }
    //retrieve customer data for edit
    public function edit($id)
    {
        try {
            $data = $this->service->editData($id);
            $view = $this->view('sales.customer._edit_data')
            ->with($data)
            ->render();
            return $this->returnAjaxSuccess(['view' => $view], 'Data Fetch Successfully');
        }catch(\Exception $e){
            return $this->returnAjaxError([],$e->getMessage());
        }

    }
    //update customer data
    public function update(UpdateCustomerRequest $request, $id)
    {
        try {
            $this->service->update($request,$id);
        }catch(\Exception $e){
            return $this->returnAjaxError([],$e->getMessage());
        }
        return $this->returnAjaxSuccess([], 'Customer updated successfully');
    }
    //delete customer data
    public function delete($id)
    {
        try {
          $this->service->delete($id);
        }catch(\Exception $e){
            return $this->returnAjaxError([],$e->getMessage());
        }
        return $this->returnAjaxSuccess([],'Customer deleted successfully');
    }
}
