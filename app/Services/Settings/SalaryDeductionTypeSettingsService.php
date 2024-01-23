<?php

namespace App\Services\Settings;

use App\Models\SettingsSalaryDeductionType;
use Carbon\Carbon;
use Illuminate\Support\Facades\Request;

class SalaryDeductionTypeSettingsService
{
    public function __construct()
    {
        $this->paginate_limit = config('commonData.paginate_limit');
    }

    public function getIndexFilteredData($request)
    {
        $data['salaryDeductionTypes'] = SettingsSalaryDeductionType::where('deleted', SettingsSalaryDeductionType::DELETED_NO)
            ->orderBy('id', 'desc')
            ->paginate($this->paginate_limit);

        return $data;
    }

    public function storeSalaryDeductionTypeSettings($request)
    {
        try {

            if ($request->rate_type == SettingsSalaryDeductionType::RATE_TYPE_FIXED_AMOUNT) {
                $request->salary_type = SettingsSalaryDeductionType::SALARY_TYPE_NOT_SET;
            }

            $salaryDeductionType = new SettingsSalaryDeductionType();
            $salaryDeductionType->title = $request->title;
            $salaryDeductionType->rate_type = $request->rate_type;
            $salaryDeductionType->salary_type = $request->salary_type;
            $salaryDeductionType->rate = $request->rate;
            $salaryDeductionType->description = $request->description;
            $salaryDeductionType->created_by = auth()->id();
            $salaryDeductionType->created_at = Carbon::now();
            $salaryDeductionType->updated_by = auth()->id();
            $salaryDeductionType->updated_at = Carbon::now();
            $salaryDeductionType->save();

            return $salaryDeductionType;
        }catch (\Exception $exception) {
            throw $exception;
        }
    }

    public function getEditData($id)
    {
        try {
            $data['item'] = SettingsSalaryDeductionType::where('id', $id)
                ->where('deleted', SettingsSalaryDeductionType::DELETED_NO)
                ->first();

            if (!$data['item']) {
                throw new \Exception("Salary Deduction Type not found");
            }
            return $data;
        }catch (\Exception $exception) {
            throw $exception;
        }
    }

    public function updateSalaryDeductionTypeSettings($request, $id)
    {
        try {
            $salaryDeductionType = SettingsSalaryDeductionType::where('id', $id)
                ->where('deleted', SettingsSalaryDeductionType::DELETED_NO)
                ->first();

            if (!$salaryDeductionType) {
                throw new \Exception("Salary Deduction Type not found");
            }

            if ($request->rate_type == SettingsSalaryDeductionType::RATE_TYPE_FIXED_AMOUNT) {
                $request->salary_type = SettingsSalaryDeductionType::SALARY_TYPE_NOT_SET;
            }

            $salaryDeductionType->title = $request->title;
            $salaryDeductionType->rate_type = $request->rate_type;
            $salaryDeductionType->salary_type = $request->salary_type;
            $salaryDeductionType->rate = $request->rate;
            $salaryDeductionType->description = $request->description;
            $salaryDeductionType->updated_by = auth()->id();
            $salaryDeductionType->updated_at = Carbon::now();
            $salaryDeductionType->save();

            return $salaryDeductionType;
        }catch (\Exception $exception) {
            throw $exception;
        }
    }

    public function deleteSalaryDeductionTypeSettings($id)
    {
        try {
            $salaryDeductionType = SettingsSalaryDeductionType::where('id', $id)
                ->where('deleted', SettingsSalaryDeductionType::DELETED_NO)
                ->first();

            if (!$salaryDeductionType) {
                throw new \Exception("Salary Deduction Type not found");
            }

            $salaryDeductionType->deleted = SettingsSalaryDeductionType::DELETED_YES;
            $salaryDeductionType->deleted_at = Carbon::now();
            $salaryDeductionType->deleted_by = auth()->id();
            $salaryDeductionType->save();

            return $salaryDeductionType;
        }catch (\Exception $exception) {
            throw $exception;
        }
    }

    public function statusUpdate($id, $status)
    {
        try {
            $salaryDeductionType = SettingsSalaryDeductionType::where('id', $id)
                ->where('deleted', SettingsSalaryDeductionType::DELETED_NO)
                ->first();

            if (!$salaryDeductionType) {
                throw new \Exception("Salary Deduction Type not found");
            }

            $salaryDeductionType->status = $status;
            $salaryDeductionType->save();

            return $salaryDeductionType;
        }catch (\Exception $exception) {
            throw $exception;
        }
    }

}
