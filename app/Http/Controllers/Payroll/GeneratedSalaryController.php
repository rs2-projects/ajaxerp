<?php

namespace App\Http\Controllers\Payroll;

use App\Http\Controllers\BaseControllers\BackendController;
use App\Http\Controllers\Controller;
use App\Services\Payroll\GeneratedSalaryService;
use Illuminate\Http\Request;

class GeneratedSalaryController extends BackendController
{
    private GeneratedSalaryService $service;
    public function __construct()
    {
        $this->addBreadcrumbs('HR', route('dashboard'), 'fa fa-home');
        $this->addBreadcrumbs('Generated Salary');

        $this->service = new GeneratedSalaryService();
    }

    public function index(Request $request)
    {
        $this->setPageTitle("Generate Salary");
        $this->setActiveMenu('payroll.generated-salary');

        return $this->view('payroll.generated-salary.index');
    }

    public function indexFiltered(Request $request)
    {

        $data = $this->service->getIndexFilteredData($request);

        $view = view('payroll.generated-salary._index_filtered')
            ->with($data)
            ->render();

        return $this->returnAjaxSuccess(['view' => $view]);
    }

    public function details($id)
    {
        $this->setPageTitle("Generated Salary Details");
        $this->setActiveMenu('payroll.generated-salary');
        $data = $this->service->getDetailsData($id);
        if (empty($data['salary'])){
            return redirect()->route('payroll.generated-salary')
                ->with('error', 'Data not found');
        }

        return $this->view('payroll.generated-salary.details')
            ->with($data);
    }

    public function detailsFiltered(Request$request, $id)
    {
        $data = $this->service->getDetailsFilteredData($request, $id);

        $view = view('payroll.generated-salary._details_filtered')
            ->with($data)
            ->render();

        return $this->returnAjaxSuccess(['view' => $view]);
    }
}
