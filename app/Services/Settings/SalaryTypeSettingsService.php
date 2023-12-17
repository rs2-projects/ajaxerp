<?php

namespace App\Services\Settings;

use App\Models\SettingsSalaryType;
use App\Models\SettingsSalaryTypeDetails;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SalaryTypeSettingsService
{
    public function __construct()
    {
        $this->paginate_limit = config('commonData.paginate_limit');
    }

    public function getIndexFilteredData($request)
    {
        $data['salaryTypes'] = SettingsSalaryType::where('deleted', SettingsSalaryType::DELETED_NO)
            ->orderBy('title', 'asc')
            ->paginate($this->paginate_limit);

        return $data;
    }

    public function store($request)
    {
        DB::beginTransaction();
        try {
            $salaryType = new SettingsSalaryType();
            $salaryType->title = $request->title;
            $salaryType->description = $request->description;
            $salaryType->created_at = Carbon::now();
            $salaryType->created_by = auth()->user()->id;
            $salaryType->updated_at = Carbon::now();
            $salaryType->updated_by = auth()->user()->id;
            $salaryType->save();

            if (is_array($request->detail_type) && count($request->detail_type) > 0) {
                foreach ($request->detail_type as $key => $value) {
                    $salaryTypeDetail = new SettingsSalaryTypeDetails();
                    $salaryTypeDetail->settings_salary_type_id = $salaryType->id;
                    $salaryTypeDetail->title = $request->detail_title[$key];
                    $salaryTypeDetail->type = $request->detail_type[$key];
                    $salaryTypeDetail->value = $request->detail_value[$key];
                    $salaryTypeDetail->save();
                }
            }

        }catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
        DB::commit();

    }

    public function getEditData($id)
    {
        $data['item'] = SettingsSalaryType::with('salaryTypeDetails')
            ->where('id', $id)
            ->where('deleted', SettingsSalaryType::DELETED_NO)
            ->first();

        if (!$data['item']) {
            throw new \Exception('Salary Type not found');
        }

        return $data;
    }

    public function update($request, $id)
    {
        DB::beginTransaction();
        try {
            $salaryType = SettingsSalaryType::where('id', $id)->first();
            $salaryType->title = $request->title;
            $salaryType->description = $request->description;
            $salaryType->updated_at = Carbon::now();
            $salaryType->updated_by = auth()->user()->id;
            $salaryType->save();

            if (is_array($request->detail_type) && count($request->detail_type) > 0) {
                // check if any detail is deleted
                $existingDetailIds = SettingsSalaryTypeDetails::where('settings_salary_type_id', $salaryType->id)->pluck('id')->toArray();
                $requestDetailIds = $request->detail_id;
                $deletedDetailIds = array_diff($existingDetailIds, $requestDetailIds);

                if (count($deletedDetailIds) > 0) {
                    SettingsSalaryTypeDetails::whereIn('id', $deletedDetailIds)->delete();
                }

                foreach ($request->detail_type as $key => $value) {
                    if (isset($request->detail_id[$key])) {
                        $salaryTypeDetail = SettingsSalaryTypeDetails::where('id', $request->detail_id[$key])->first();
                    } else {
                        $salaryTypeDetail = new SettingsSalaryTypeDetails();
                        $salaryTypeDetail->settings_salary_type_id = $salaryType->id;
                    }
                    $salaryTypeDetail->title = $request->detail_title[$key];
                    $salaryTypeDetail->type = $request->detail_type[$key];
                    $salaryTypeDetail->value = $request->detail_value[$key];
                    $salaryTypeDetail->save();
                }
            }

        }catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
        DB::commit();

    }

    public function delete($id)
    {
        DB::beginTransaction();
        try {
            $salaryType = SettingsSalaryType::where('id', $id)
                ->where('deleted', SettingsSalaryType::DELETED_NO)
                ->first();

            if (!$salaryType) {
                throw new \Exception('Salary Type not found');
            }
            $salaryType->deleted = SettingsSalaryType::DELETED_YES;
            $salaryType->deleted_at = Carbon::now();
            $salaryType->deleted_by = auth()->user()->id;
            $salaryType->save();

//            SettingsSalaryTypeDetails::where('settings_salary_type_id', $salaryType->id)->delete();

        }catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
        DB::commit();

    }

    public function statusUpdate($id, $status)
    {
        $salaryType = SettingsSalaryType::where('id', $id)
            ->where('deleted', SettingsSalaryType::DELETED_NO)
            ->first();

        if (!$salaryType) {
            throw new \Exception('Salary Type not found');
        }

        $salaryType->status = $status;
        $salaryType->save();
    }
}
