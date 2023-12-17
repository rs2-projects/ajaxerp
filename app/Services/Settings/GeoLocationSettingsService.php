<?php

namespace App\Services\Settings;

use App\Models\SettingsGeoLocation;
use Carbon\Carbon;

class GeoLocationSettingsService
{
    public function __construct()
    {
        $this->paginate_limit = config('commonData.paginate_limit');
    }

    public function getIndexFilteredData($request)
    {
        $data['geoLocations'] = SettingsGeoLocation::where('deleted', SettingsGeoLocation::DELETED_NO)
            ->orderBy('title', 'asc')
            ->paginate($this->paginate_limit);

        return $data;
    }

    public function storeGeoLocationSettings($request)
    {
        try {
            $geoLocation = new SettingsGeoLocation();
            $geoLocation->title = $request->title;
            $geoLocation->description = $request->description;
            $geoLocation->map_type = 0;
            $geoLocation->location_data = $request->location_data;
            $geoLocation->is_default = $request->is_default??0;
            $geoLocation->created_by = auth()->id();
            $geoLocation->created_at = Carbon::now();
            $geoLocation->save();
        }catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }
    }

    public function getEditData($id)
    {
        $data['item'] = SettingsGeoLocation::findOrFail($id);
        $data['location_data'] = json_decode($data['item']->location_data, true);
        return $data;
    }

    public function update($request, $id)
    {
        try {
            $geoLocation = SettingsGeoLocation::findOrFail($id);
            $geoLocation->title = $request->title;
            $geoLocation->description = $request->description;
            $geoLocation->map_type = 0;
            $geoLocation->location_data = $request->location_data;
            $geoLocation->is_default = $request->is_default??0;
            $geoLocation->updated_by = auth()->id();
            $geoLocation->updated_at = Carbon::now();
            $geoLocation->save();

        }catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $geoLocation = SettingsGeoLocation::findOrFail($id);
            $geoLocation->deleted = SettingsGeoLocation::DELETED_YES;
            $geoLocation->deleted_at = Carbon::now();
            $geoLocation->deleted_by = auth()->id();
            $geoLocation->save();
        }catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }
    }

    public function statusUpdate($id, $status)
    {
        try {
            $geoLocation = SettingsGeoLocation::findOrFail($id);
            $geoLocation->status = $status;
            $geoLocation->updated_by = auth()->id();
            $geoLocation->updated_at = Carbon::now();
            $geoLocation->save();
        }catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }
    }
}
