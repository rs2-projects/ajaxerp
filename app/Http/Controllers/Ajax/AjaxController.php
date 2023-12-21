<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\BaseControllers\BackendController;
use App\Models\Designation;
use App\Services\Ajax\AjaxService;
use Illuminate\Http\Request;

class AjaxController extends BackendController
{
    public function getDesignationByDepartment(Request $request, AjaxService $ajaxService)
    {
        try {
            $data = $ajaxService->getDesignationByDepartment($request);
            $view = $this->view('ajax._get_designation_by_department')->with($data)
                ->render();

            return $this->returnAjaxSuccess(['view' => $view]);
        }catch (\Exception $exception) {
            return $this->returnAjaxError($exception->getMessage());
        }
    }
}
