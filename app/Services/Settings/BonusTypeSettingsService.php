<?php

namespace App\Services\Settings;

use App\Models\SettingsBonusType;
use Carbon\Carbon;

class BonusTypeSettingsService
{
    public function __construct()
    {
        $this->paginate_limit = config('commonData.paginate_limit');
    }

    public function getIndexFilteredData($request)
    {
        $data['bonusTypes'] = SettingsBonusType::where('deleted', SettingsBonusType::DELETED_NO)
            ->orderBy('title', 'asc')
            ->paginate($this->paginate_limit);

        return $data;
    }

    public function storeBonusTypeSettings($request)
    {
        try {
            $bonusType = new SettingsBonusType();
            $bonusType->title = $request->title;
            $bonusType->description = $request->description;
            $bonusType->created_by = auth()->id();
            $bonusType->created_at = Carbon::now();
            $bonusType->save();
        }catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }
    }
    public function getEditData($id)
    {
        $data['item'] = SettingsBonusType::findOrFail($id);
        return $data;
    }

    public function update($request, $id)
    {
        try {
            $bonusType = SettingsBonusType::findOrFail($id);
            $bonusType->title = $request->title;
            $bonusType->description = $request->description;
            $bonusType->updated_by = auth()->id();
            $bonusType->updated_at = Carbon::now();
            $bonusType->save();

        }catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $bonusType = SettingsBonusType::findOrFail($id);
            $bonusType->deleted = SettingsBonusType::DELETED_YES;
            $bonusType->deleted_at = Carbon::now();
            $bonusType->deleted_by = auth()->id();
            $bonusType->save();
        }catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function statusUpdate($id, $status)
    {
        try {
            $bonusType = SettingsBonusType::findOrFail($id);
            $bonusType->status = $status;
            $bonusType->updated_by = auth()->id();
            $bonusType->updated_at = Carbon::now();
            $bonusType->save();
        }catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
