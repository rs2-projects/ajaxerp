<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\BaseControllers\BackendController;
use App\Http\Requests\Settings\TerminationType\StoreTerminationTypeRequest;
use App\Services\Settings\TerminationTypeSettingsService;
use Illuminate\Http\Request;

class TerminationTypeSettingsController extends BackendController
{
    public function __construct()
    {
        $this->addBreadcrumbs('Settings', route('settings.termination-type'), 'fa fa-cog');
        $this->addBreadcrumbs('Termination Type');
    }

    public function index()
    {
        $this->setPageTitle("Termination Type");
        $this->setActiveMenu('settings.termination-type');

       return  $this->view('settings.termination-type.index');
    }

    public function indexFiltered(Request $request, TerminationTypeSettingsService $terminationTypeSettingsService)
    {
        $data = $terminationTypeSettingsService->getIndexFilteredData($request);
        $view = $this->view('settings.termination-type._index_filtered')->with($data)->render();

        return $this->returnAjaxSuccess(['view' => $view]);
    }

    public function store(StoreTerminationTypeRequest $request, TerminationTypeSettingsService $terminationTypeSettingsService)
    {
        try {
            $terminationTypeSettingsService->store($request);
        }catch (\Exception $exception) {
            return $this->returnAjaxException($exception);
        }
        return $this->returnAjaxSuccess([], "Create Success");
    }

    public function edit(TerminationTypeSettingsService $terminationTypeSettingsService, $id)
    {
        $data = $terminationTypeSettingsService->getEditData($id);

        $view = $this->view('settings.termination-type._edit_data')->with($data)
            ->render();

        return $this->returnAjaxSuccess(['view' => $view]);
    }

    public function update(StoreTerminationTypeRequest $request, TerminationTypeSettingsService $terminationTypeSettingsService, $id)
    {
        try {
            $terminationTypeSettingsService->update($request, $id);
        }catch (\Exception $exception) {
            return $this->returnAjaxException($exception);
        }
        return $this->returnAjaxSuccess([], "Update Success");
    }

    public function delete(TerminationTypeSettingsService $terminationTypeSettingsService, $id)
    {
        try {
            $terminationTypeSettingsService->delete($id);
        }catch (\Exception $exception) {
            return $this->returnAjaxException($exception);
        }
        return $this->returnAjaxSuccess([], "Delete Success");
    }
}
