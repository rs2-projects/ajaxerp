<?php

namespace App\Services\Settings;
use App\Models\SettingsOvertimeType;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OverTimeSettingsService
{
    public SettingsSalarySetUpdateHelperService $updateSalarySetHelperService;

    public function __construct()
    {
        $this->paginate_limit = config('commonData.paginate_limit');
        $this->updateSalarySetHelperService = new SettingsSalarySetUpdateHelperService();
    }

    public function getIndexData()
    {
        $data = [];
        $data['over_time_types'] = $this->getOverTimeTypes();
        return $data;
    }

    public function getOverTimeTypes()
    {
        $over_time_types = SettingsOvertimeType::where('status', SettingsOvertimeType::STATUS_ACTIVE)
            ->where('deleted', SettingsOvertimeType::DELETED_NO)
            ->get();
        return $over_time_types;
    }

    public function getIndexFilteredData(Request $request)
    {

        $data['over_time_types'] =  SettingsOvertimeType::where('status', SettingsOvertimeType::STATUS_ACTIVE)
            ->where('deleted', SettingsOvertimeType::DELETED_NO)
            ->orderBy('title', 'asc')
            ->paginate($this->paginate_limit);

        return $data;
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {

            $over_time = new SettingsOvertimeType();
            $over_time->title = $request->title;
            $over_time->description = $request->description;
            $over_time->salary_type = $request->salary_type;
            $over_time->rate = $request->rate;
            $over_time->special_rate = $request->special_rate;
            $over_time->status = SettingsOvertimeType::STATUS_ACTIVE;
            $over_time->deleted = SettingsOvertimeType::DELETED_NO;
            $over_time->created_at = Carbon::now();
            $over_time->created_by = auth()->id();
            $over_time->save();

        }catch (\Exception $exception){
            DB::rollBack();
            throw new \Exception($exception->getMessage());
        }

        DB::commit();

    }

    public function getEditData($id)
    {
        $data = [];
        $data['item'] = SettingsOvertimeType::findOrFail($id);
        return $data;
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {

            $over_time = SettingsOvertimeType::findOrFail($id);
            if (empty($over_time)){
                throw new \Exception("Invalid Overtime!");
            }
            $over_time->status = SettingsOvertimeType::STATUS_INACTIVE;
            $over_time->updated_at = Carbon::now();
            $over_time->updated_by = auth()->id();
            $over_time->save();
            /*$over_time->title = $request->title;
            $over_time->description = $request->description;
            $over_time->salary_type = $request->salary_type;
            $over_time->rate = $request->rate;
            $over_time->special_rate = $request->special_rate;
            $over_time->updated_at = Carbon::now();
            $over_time->updated_by = auth()->id();
            $over_time->save();*/

            $newOvertime = new SettingsOvertimeType();
            $newOvertime->title = $request->title;
            $newOvertime->description = $request->description;
            $newOvertime->salary_type = $request->salary_type;
            $newOvertime->rate = $request->rate;
            $newOvertime->special_rate = $request->special_rate;
            $newOvertime->status = SettingsOvertimeType::STATUS_ACTIVE;
            $newOvertime->deleted = SettingsOvertimeType::DELETED_NO;
            $newOvertime->created_at = Carbon::now();
            $newOvertime->created_by = auth()->id();
            $newOvertime->save();

            /*update salary set or create new if required*/
            $this->updateSalarySetHelperService->updateOvertimeType($over_time, $newOvertime);


        }catch (\Exception $exception){
            DB::rollBack();
            throw new \Exception($exception->getMessage());
        }

        DB::commit();
    }

    public function delete($id)
    {
        DB::beginTransaction();
        try {

            $over_time = SettingsOvertimeType::findOrFail($id);
            $over_time->deleted = SettingsOvertimeType::DELETED_YES;
            $over_time->status = SettingsOvertimeType::STATUS_INACTIVE;
            $over_time->deleted_at = Carbon::now();
            $over_time->deleted_by = auth()->id();
            $over_time->save();

        }catch (\Exception $exception){
            DB::rollBack();
            throw new \Exception($exception->getMessage());
        }

        DB::commit();
    }
}
