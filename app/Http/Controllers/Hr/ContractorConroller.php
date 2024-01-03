<?php

namespace App\Http\Controllers\Hr;

use App\Http\Controllers\BaseControllers\BackendController;
use App\Http\Requests\Hr\Contractor\StoreContractorRequest;
use App\Http\Requests\Hr\Contractor\UpdateContractorRequest;
use App\Services\Hr\ContractorService;
use Illuminate\Support\Facades\Request;

class ContractorConroller extends BackendController
{
    public function __construct()
    {
        $this->addBreadcrumbs('HR', route('hr.user-contractor'), 'fa fa-users');
        $this->addBreadcrumbs('Contractor');
    }

    public function index()
    {
        $this->setPageTitle("Contractor");
        $this->setActiveMenu('hr.user-contractor');
        return  $this->view('hr.user-contractor.index');
    }

    public function indexFiltered(Request $request, ContractorService $contractorService)
    {
        $data = $contractorService->getIndexFilteredData($request);
        $view = $this->view('hr.user-contractor._index_filtered')->with($data)->render();

        return $this->returnAjaxSuccess(['view' => $view]);
    }

    public function store(StoreContractorRequest $request, ContractorService $contractorService)
    {
        try {
            $contractorService->store($request);
        }catch (\Exception $exception) {
            return $this->returnAjaxException($exception);
        }
        return $this->returnAjaxSuccess([], "Create Success");
    }

    public function edit(ContractorService $contractorService, $id)
    {
        try {
            $data = $contractorService->getEditData($id);
            if (empty($data['item'])){
                return throw new \Exception("Data not found");
            }
            $view = $this->view('hr.user-contractor._edit_data')->with($data)
                ->render();
        }catch (\Exception $exception) {
            return $this->returnAjaxException($exception);
        }

        return $this->returnAjaxSuccess(['view' => $view]);
    }

    public function update(UpdateContractorRequest $request, ContractorService $contractorService, $id)
    {
        try {
            $contractorService->update($request, $id);
        }catch (\Exception $exception) {
            return $this->returnAjaxException($exception);
        }
        return $this->returnAjaxSuccess([], "Update Success");
    }

    public function delete(ContractorService $contractorService, $id)
    {
        try {
            $contractorService->delete($id);
        }catch (\Exception $exception) {
            return $this->returnAjaxException($exception);
        }
        return $this->returnAjaxSuccess([], "Delete Success");
    }
}
