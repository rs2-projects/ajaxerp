<?php

namespace App\Http\Controllers\Hr;

use App\Http\Controllers\BaseControllers\BackendController;
use App\Http\Requests\Hr\Employee\EmployeePromoteRequest;
use Illuminate\Http\Request;
use App\Services\Hr\EmployeePromotionService;

class EmployeePromotionController extends BackendController
{
    private EmployeePromotionService $service;
    public function __construct()
    {
        $this->addBreadcrumbs('HR', route('dashboard'), 'fa fa-home');
        $this->addBreadcrumbs('Employee', route('hr.employee'));
        $this->service = new EmployeePromotionService();
    }
    
    public function getPromotionModalData($id) 
    {
        
        $data = $this->service->promotionModalData($id);
        $response['view'] = $this->view('hr.employee.__promote_employee_modal_data')->with($data)->render();
        $response['status'] = 200;
        
        return $this->returnAjaxSuccess($response);
    }

    public function storeEmployeePromotion(EmployeePromoteRequest $request, $id) 
    {
        try {
            $this->service->storePromotion($request, $id);
        }catch (\Exception $exception) {
            return $this->returnAjaxException($exception);
        }

        return $this->returnAjaxSuccess([], "Promote Success");
    }
    
    public function getDemotionModalData($id) 
    {
        
        $data = $this->service->demotionModalData($id);
        $response['view'] = $this->view('hr.employee.__demote_employee_modal_data')->with($data)->render();
        $response['status'] = 200;
        
        return $this->returnAjaxSuccess($response);
    }

    public function storeEmployeeDemotion(EmployeePromoteRequest $request, $id) 
    {
        try {
            $this->service->storeDemotion($request, $id);
        }catch (\Exception $exception) {
            return $this->returnAjaxException($exception);
        }

        return $this->returnAjaxSuccess([], "Demote Success");
    }
}
