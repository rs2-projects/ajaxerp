<?php

namespace App\Services\Settings;

use App\Models\SettingsLatePenalty;

class LatePenaltySettingsService
{
    public function __construct()
    {
        $this->paginate_limit = config('commonData.paginate_limit');
    }

    public function getIndexFilteredData($request)
    {
        $data['latePenalties'] = SettingsLatePenalty::where('deleted', SettingsLatePenalty::DELETED_NO)
            ->orderBy('title', 'asc')
            ->paginate($this->paginate_limit);

        return $data;
    }

    public function storeLatePenaltySettings($request)
    {
        $latePenalty = new SettingsLatePenalty();
        $latePenalty->title = $request->title;
        $latePenalty->description = $request->description;
        $latePenalty->late_count_minutes = $request->late_count_minutes;
        $latePenalty->salary_type = $request->salary_type;
        $latePenalty->rate = $request->rate;
        $latePenalty->save();

    }

    public function getEditData($id)
    {
        $data['item'] = SettingsLatePenalty::where('id', $id)->first();

        return $data;
    }

    public function update($request, $id)
    {
        $latePenalty = SettingsLatePenalty::where('id', $id)->first();
        if (!$latePenalty) {
         return   throw new \Exception("Late Penalty not found");
        }
        $latePenalty->title = $request->title;
        $latePenalty->description = $request->description;
        $latePenalty->late_count_minutes = $request->late_count_minutes;
        $latePenalty->salary_type = $request->salary_type;
        $latePenalty->rate = $request->rate;
        $latePenalty->save();
    }

    public function delete($id)
    {
        $latePenalty = SettingsLatePenalty::where('id', $id)->first();
        if (!$latePenalty) {
            return   throw new \Exception("Late Penalty not found");
        }
        $latePenalty->deleted = SettingsLatePenalty::DELETED_YES;
        $latePenalty->save();
    }

}
