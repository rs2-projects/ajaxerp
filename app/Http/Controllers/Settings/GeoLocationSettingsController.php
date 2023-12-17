<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\BaseControllers\BackendController;
use App\Http\Requests\Settings\GeoLocation\StoreGeoLocationSettingsRequest;
use App\Http\Requests\Settings\GeoLocation\UpdateGeoLocationSettingsRequest;
use App\Services\Settings\GeoLocationSettingsService;
use Illuminate\Http\Request;

class GeoLocationSettingsController extends BackendController
{
    public function __construct()
    {
        $this->addBreadcrumbs('Settings', route('settings.office-time'), 'fa fa-cog');
        $this->addBreadcrumbs('Geo Location');
    }

    public function index()
    {
        $this->setPageTitle("Geo Location");
        $this->setActiveMenu('settings.geo-location');

        return $this->view('settings.geo-location.index');
    }

    public function indexFiltered(Request $request, GeoLocationSettingsService $geoLocationSettingsService)
    {
        $data = $geoLocationSettingsService->getIndexFilteredData($request);
        $view = $this->view('settings.geo-location._index_filtered')->with($data)->render();

        return $this->returnAjaxSuccess(['view' => $view]);
    }

    public function store(StoreGeoLocationSettingsRequest $request, GeoLocationSettingsService $geoLocationSettingsService)
    {
        try {
            $geoLocationSettingsService->storeGeoLocationSettings($request);
        }catch (\Exception $exception) {
            return $this->returnAjaxException($exception);
        }
        return $this->returnAjaxSuccess([], "Create Success");
    }

    public function edit(GeoLocationSettingsService $geoLocationSettingsService, $id)
    {
        $data = $geoLocationSettingsService->getEditData($id);

        $view = $this->view('settings.geo-location._edit_data')->with($data)
            ->render();

        return $this->returnAjaxSuccess([
            'view' => $view,
            'location_data' => $data['location_data']??[]
        ]);
    }

    public function update(UpdateGeoLocationSettingsRequest $request, GeoLocationSettingsService $geoLocationSettingsService, $id)
    {
        try {
            $geoLocationSettingsService->update($request, $id);
        }catch (\Exception $exception) {
            return $this->returnAjaxException($exception);
        }
        return $this->returnAjaxSuccess([], "Update Success");
    }

    public function delete(GeoLocationSettingsService $geoLocationSettingsService, $id)
    {
        try {
            $geoLocationSettingsService->delete($id);
        }catch (\Exception $exception) {
            return $this->returnAjaxException($exception);
        }
        return $this->returnAjaxSuccess([], "Delete Success");
    }

    public function statusUpdate(GeoLocationSettingsService $geoLocationSettingsService, $id, $status)
    {
        try {
            $geoLocationSettingsService->statusUpdate($id, $status);
        }catch (\Exception $exception) {
            return $this->returnAjaxException($exception);
        }
        return $this->returnAjaxSuccess([], "Status Update Success");
    }
}
