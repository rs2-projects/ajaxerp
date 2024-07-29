<?php

namespace App\Services\Settings;

use App\Models\SettingsLatePenalty;
use Carbon\Carbon;

class LatePenaltySettingsService
{
    public SettingsSalarySetUpdateHelperService $updateSalarySetHelperService;
    public function __construct()
    {
        $this->paginate_limit = config('commonData.paginate_limit');
        $this->updateSalarySetHelperService = new SettingsSalarySetUpdateHelperService();
    }

    public function getIndexFilteredData($request)
    {
        $data['latePenalties'] = SettingsLatePenalty::where('deleted', SettingsLatePenalty::DELETED_NO)
            ->where('status', SettingsLatePenalty::STATUS_ACTIVE)
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
        $latePenalty->status =  SettingsLatePenalty::STATUS_ACTIVE;
        $latePenalty->created_by = auth()->id();
        $latePenalty->created_at = Carbon::now();
        $latePenalty->updated_by = auth()->id();
        $latePenalty->updated_at = Carbon::now();
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
        if (empty($latePenalty)) {
            throw new \Exception("Late Penalty not found");
        }
        $latePenalty->status =  SettingsLatePenalty::STATUS_INACTIVE;
        $latePenalty->updated_by = auth()->id();
        $latePenalty->updated_at = Carbon::now();
        $latePenalty->save();


        $newLatePenalty = new SettingsLatePenalty();
        $newLatePenalty->title = $request->title;
        $newLatePenalty->description = $request->description;
        $newLatePenalty->late_count_minutes = $request->late_count_minutes;
        $newLatePenalty->salary_type = $request->salary_type;
        $newLatePenalty->rate = $request->rate;
        $newLatePenalty->status =  SettingsLatePenalty::STATUS_ACTIVE;
        $newLatePenalty->created_by = auth()->id();
        $newLatePenalty->created_at = Carbon::now();
        $newLatePenalty->updated_by = auth()->id();
        $newLatePenalty->updated_at = Carbon::now();
        $newLatePenalty->save();

        $this->updateSalarySetHelperService->updateLatePenalty($latePenalty, $newLatePenalty);
        /*
        $latePenalty->title = $request->title;
        $latePenalty->description = $request->description;
        $latePenalty->late_count_minutes = $request->late_count_minutes;
        $latePenalty->salary_type = $request->salary_type;
        $latePenalty->rate = $request->rate;
        $latePenalty->save();*/
    }

    public function delete($id)
    {
        $latePenalty = SettingsLatePenalty::where('id', $id)->first();
        if (empty($latePenalty)) {
            throw new \Exception("Late Penalty not found");
        }
        $latePenalty->deleted = SettingsLatePenalty::DELETED_YES;
        $latePenalty->save();
    }

}
