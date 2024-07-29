<?php

namespace App\Services\Settings;

use App\Models\SettingsAbsentPenalty;
use Carbon\Carbon;

class AbsentPenaltySettingsService
{
    public SettingsSalarySetUpdateHelperService $updateSalarySetHelperService;
    public function __construct()
    {
        $this->paginate_limit = config('commonData.paginate_limit');
        $this->updateSalarySetHelperService = new SettingsSalarySetUpdateHelperService();
    }

    public function getIndexFilteredData($request)
    {
        $data['absentPenalties'] = SettingsAbsentPenalty::where('deleted', SettingsAbsentPenalty::DELETED_NO)
            ->where('status', SettingsAbsentPenalty::STATUS_ACTIVE)
            ->orderBy('title', 'asc')
            ->paginate($this->paginate_limit);

        return $data;
    }

    public function storeAbsentPenaltySettings($request)
    {
        try {

            if ($request->rate_type == SettingsAbsentPenalty::RATE_TYPE_FIXED_AMOUNT){
                $request->merge(['salary_type' => SettingsAbsentPenalty::SALARY_TYPE_NOT_SET]);
            }

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
            if (empty($absentPenalty)) {
             throw new \Exception("Invalid Absent Panalty Type!");
            }
            $absentPenalty->status = SettingsAbsentPenalty::STATUS_INACTIVE;
            $absentPenalty->updated_by = auth()->id();
            $absentPenalty->updated_at = Carbon::now();
            $absentPenalty->save();

            if ($request->rate_type == SettingsAbsentPenalty::RATE_TYPE_FIXED_AMOUNT){
                $request->merge(['salary_type' => SettingsAbsentPenalty::SALARY_TYPE_NOT_SET]);
            }

            $newAbsentPenalty = new SettingsAbsentPenalty();
            $newAbsentPenalty->title = $request->title;
            $newAbsentPenalty->description = $request->description;
            $newAbsentPenalty->rate_type = $request->rate_type;
            $newAbsentPenalty->rate = $request->rate;
            $newAbsentPenalty->salary_type = $request->salary_type;
            $newAbsentPenalty->created_by = auth()->id();
            $newAbsentPenalty->created_at = Carbon::now();
            $newAbsentPenalty->save();

            $this->updateSalarySetHelperService->updateAbsentPenalty($absentPenalty, $newAbsentPenalty);

            /*if ($request->rate_type == SettingsAbsentPenalty::RATE_TYPE_FIXED_AMOUNT){
                $request->merge(['salary_type' => SettingsAbsentPenalty::SALARY_TYPE_NOT_SET]);
            }

            $absentPenalty->title = $request->title;
            $absentPenalty->description = $request->description;
            $absentPenalty->rate_type = $request->rate_type;
            $absentPenalty->rate = $request->rate;
            $absentPenalty->salary_type = $request->salary_type;
            $absentPenalty->updated_by = auth()->id();
            $absentPenalty->updated_at = Carbon::now();
            $absentPenalty->save();*/
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
                throw new \Exception("Data not found");
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
