<?php

namespace App\Services\Settings;

use App\Models\SettingsHoliday;
use Carbon\Carbon;

class HolidaySettingsService
{
    public function __construct()
    {
        $this->paginate_limit = config('commonData.paginate_limit');
    }

    public function getIndexFilteredData($request)
    {
        $data['holidays'] = SettingsHoliday::where('deleted', SettingsHoliday::DELETED_NO)
            ->orderBy('title', 'asc')
            ->paginate($this->paginate_limit);

        return $data;
    }

    public function storeHolidaySettings($request)
    {
        try {

            $holiday = new SettingsHoliday();
            $holiday->title = $request->title;
            $holiday->description = $request->description;
            $holiday->start_date = $request->start_date;
            $holiday->end_date = $request->end_date;
            $holiday->created_by = auth()->user()->id;
            $holiday->created_at = Carbon::now();
            $holiday->save();

        }catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function getEditData($id)
    {
        $data['item'] = SettingsHoliday::findOrFail($id);
        return $data;
    }

    public function update($request, $id)
    {
        try {
            $holiday = SettingsHoliday::findOrFail($id);
            $holiday->title = $request->title;
            $holiday->description = $request->description;
            $holiday->start_date = $request->start_date;
            $holiday->end_date = $request->end_date;
            $holiday->updated_by = auth()->user()->id;
            $holiday->updated_at = Carbon::now();
            $holiday->save();
        }catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $holiday = SettingsHoliday::findOrFail($id);
            $holiday->deleted = SettingsHoliday::DELETED_YES;
            $holiday->status = SettingsHoliday::STATUS_INACTIVE;
            $holiday->deleted_at = Carbon::now();
            $holiday->deleted_by = auth()->user()->id;
            $holiday->save();
        }catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
