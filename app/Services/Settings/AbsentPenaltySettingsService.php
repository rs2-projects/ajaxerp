<?php

namespace App\Services\Settings;

use App\Models\SettingsAbsentPenalty;
use Carbon\Carbon;

class AbsentPenaltySettingsService
{
    public function __construct()
    {
        $this->paginate_limit = config('commonData.paginate_limit');
    }

    public function getIndexFilteredData($request)
    {
        $data['absentPenalties'] = SettingsAbsentPenalty::where('deleted', SettingsAbsentPenalty::DELETED_NO)
            ->orderBy('title', 'asc')
            ->paginate($this->paginate_limit);

        return $data;
    }

    public function storeAbsentPenaltySettings($request)
    {
        try {
            $absentPenalty = new SettingsAbsentPenalty();
            $absentPenalty->title = $request->title;
            $absentPenalty->description = $request->description;
            $absentPenalty->rate_type = $request->rate_type;
            $absentPenalty->rate = $request->rate;
            $absentPenalty->salary_type = $request->salary_type;
            $absentPenalty->created_by = auth()->id();
            $absentPenalty->created_at = Carbon::now();
            $absentPenalty->save();
        }catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }
    }

    public function getEditData($id)
    {
        $data['item'] = SettingsAbsentPenalty::where('id', $id)
            ->where('deleted', SettingsAbsentPenalty::DELETED_NO)
            ->first();
        return $data;
    }

    public function update($request, $id)
    {
        try {
            $absentPenalty = SettingsAbsentPenalty::where('id', $id)
                ->where('deleted', SettingsAbsentPenalty::DELETED_NO)
                ->first();
            if (!$absentPenalty) {
             return throw new \Exception("Data not found");
            }
            $absentPenalty->title = $request->title;
            $absentPenalty->description = $request->description;
            $absentPenalty->rate_type = $request->rate_type;
            $absentPenalty->rate = $request->rate;
            $absentPenalty->salary_type = $request->salary_type;
            $absentPenalty->updated_by = auth()->id();
            $absentPenalty->updated_at = Carbon::now();
            $absentPenalty->save();
        }catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }


    }

    public function delete($id)
    {
        try {
            $absentPenalty = SettingsAbsentPenalty::where('id', $id)
                ->where('deleted', SettingsAbsentPenalty::DELETED_NO)
                ->first();
            if (!$absentPenalty) {
                return throw new \Exception("Data not found");
            }
            $absentPenalty->deleted = SettingsAbsentPenalty::DELETED_YES;
            $absentPenalty->deleted_at = Carbon::now();
            $absentPenalty->deleted_by = auth()->id();
            $absentPenalty->save();
        }catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }
    }

}
