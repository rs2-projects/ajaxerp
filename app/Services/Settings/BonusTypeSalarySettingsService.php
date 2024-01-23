<?php

namespace App\Services\Settings;

use App\Models\SettingsBonusType;
use App\Models\SettingsBonusTypeSalaryBonus;
use App\Models\SettingsSalaryType;
use Carbon\Carbon;

class BonusTypeSalarySettingsService
{
    public function __construct()
    {
        $this->paginate_limit = config('commonData.paginate_limit');
    }

    public function indexData()
    {
        $data['bonusTypes'] = SettingsBonusType::where('deleted', SettingsBonusType::DELETED_NO)
            ->orderBy('title', 'asc')
            ->get();
        $data['salaryTypes'] = SettingsSalaryType::where('deleted', SettingsSalaryType::DELETED_NO)
            ->orderBy('title', 'asc')
            ->get();
        return $data;
    }

    public function getIndexFilteredData($request)
    {
        $data['bonusTypesSalary'] = SettingsBonusTypeSalaryBonus::with('bonusType', 'salaryType')
            ->where('deleted', SettingsBonusTypeSalaryBonus::DELETED_NO)
            ->orderBy('id', 'desc')
            ->paginate($this->paginate_limit);

        return $data;
    }

    public function storeBonusTypeSalarySettings($request)
    {
        try {

            if ($request->rate_type == SettingsBonusTypeSalaryBonus::RATE_TYPE_FIXED_AMOUNT){
                $request->merge(['salary_type' => SettingsBonusTypeSalaryBonus::SALARY_TYPE_NOT_SET]);
            }

            $bonusTypeSalary = new SettingsBonusTypeSalaryBonus();
            $bonusTypeSalary->settings_bonus_type_id = $request->settings_bonus_type_id;
            $bonusTypeSalary->settings_salary_type_id = $request->settings_salary_type_id;
            $bonusTypeSalary->rate_type = $request->rate_type;
            $bonusTypeSalary->salary_type = $request->salary_type??$bonusTypeSalary::SALARY_TYPE_NOT_SET;
            $bonusTypeSalary->rate = $request->rate;
            $bonusTypeSalary->created_by = auth()->id();
            $bonusTypeSalary->created_at = Carbon::now();
            $bonusTypeSalary->save();
        }catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }
    }

    public function editData($id)
    {
        $data['bonusTypes'] = SettingsBonusType::where('deleted', SettingsBonusType::DELETED_NO)
            ->orderBy('title', 'asc')
            ->get();
        $data['salaryTypes'] = SettingsSalaryType::where('deleted', SettingsSalaryType::DELETED_NO)
            ->orderBy('title', 'asc')
            ->get();

        $data['item'] = SettingsBonusTypeSalaryBonus::with('bonusType', 'salaryType')
            ->where('deleted', SettingsBonusTypeSalaryBonus::DELETED_NO)
            ->where('id', $id)
            ->first();
        if (!$data['item']){
           return throw new \Exception("Bonus Type Salary not found");
        }
        return $data;
    }

    public function updateBonusTypeSalarySettings($request, $id)
    {
        try {
            $bonusTypeSalary = SettingsBonusTypeSalaryBonus::where('deleted', SettingsBonusTypeSalaryBonus::DELETED_NO)
                ->where('id', $id)
                ->first();
            if (!$bonusTypeSalary){
                throw new \Exception("Bonus Type Salary not found");
            }

            if ($request->rate_type == $bonusTypeSalary::RATE_TYPE_FIXED_AMOUNT){
                $request->merge(['salary_type' => $bonusTypeSalary::SALARY_TYPE_NOT_SET]);
            }

            $bonusTypeSalary->settings_bonus_type_id = $request->settings_bonus_type_id;
            $bonusTypeSalary->settings_salary_type_id = $request->settings_salary_type_id;
            $bonusTypeSalary->rate_type = $request->rate_type;
            $bonusTypeSalary->salary_type = $request->salary_type??$bonusTypeSalary::SALARY_TYPE_NOT_SET;
            $bonusTypeSalary->rate = $request->rate;
            $bonusTypeSalary->updated_by = auth()->id();
            $bonusTypeSalary->updated_at = Carbon::now();
            $bonusTypeSalary->save();
        }catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }
    }

    public function destroyBonusTypeSalarySettings($id)
    {
        try {
            $bonusTypeSalary = SettingsBonusTypeSalaryBonus::where('deleted', SettingsBonusTypeSalaryBonus::DELETED_NO)
                ->where('id', $id)
                ->first();
            if (!$bonusTypeSalary){
                throw new \Exception("Bonus Type Salary not found");
            }
            $bonusTypeSalary->deleted = SettingsBonusTypeSalaryBonus::DELETED_YES;
            $bonusTypeSalary->deleted_by = auth()->id();
            $bonusTypeSalary->deleted_at = Carbon::now();
            $bonusTypeSalary->save();
        }catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }
    }

    public function statusUpdate($id, $status)
    {
        try {
            $bonusTypeSalary = SettingsBonusTypeSalaryBonus::where('deleted', SettingsBonusTypeSalaryBonus::DELETED_NO)
                ->where('id', $id)
                ->first();
            if (!$bonusTypeSalary){
                throw new \Exception("Bonus Type Salary not found");
            }
            $bonusTypeSalary->status = $status;
            $bonusTypeSalary->updated_by = auth()->id();
            $bonusTypeSalary->updated_at = Carbon::now();
            $bonusTypeSalary->save();
        }catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }
    }

}
