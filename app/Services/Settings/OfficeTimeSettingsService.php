<?php

namespace App\Services\Settings;

use App\Models\SettingsOfficeTime;
use App\Models\SettingsOfficeTimeType;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OfficeTimeSettingsService
{
    public function __construct()
    {
        $this->weekDays = config('commonData.week_days');
    }

    public function getWeekDays()
    {
        return $this->weekDays;
    }

    public function getIndexData()
    {
        $data = [];
        $data['week_days'] = $this->getWeekDays();
        $data['office_time_types'] = $this->getOfficeTimeTypes();
        return $data;
    }

    public function getOfficeTimeTypes()
    {
        $office_time_types = SettingsOfficeTimeType::with('officeTimes')
            ->where('status', SettingsOfficeTimeType::STATUS_ACTIVE)
            ->where('deleted', SettingsOfficeTimeType::DELETED_NO)
            ->get();
        return $office_time_types;
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $type = new SettingsOfficeTimeType();
            $type->name = $request->title;
            $type->description = $request->description;
            $type->status = SettingsOfficeTimeType::STATUS_ACTIVE;
            $type->deleted = SettingsOfficeTimeType::DELETED_NO;
            $type->created_at = Carbon::now();
            $type->created_by = auth()->id();
            $type->save();

            foreach ($request->days as $key=> $day){
                $is_weekend_input = $day.'_is_weekend';
                $start_time_input = $day.'_start_time';
                $end_time_input = $day.'_end_time';
                $working_hour_input = $day.'_working_hour';

                if(isset($request->$is_weekend_input) && ($request->$is_weekend_input == 1)) {
                    $is_weekend = 1;
                } else {
                    $is_weekend = 0;
                }

                $office_time = new SettingsOfficeTime();
                $office_time->office_time_type_id = $type->id;
                $office_time->day = $day;
                $office_time->is_weekend = $is_weekend;
                $office_time->start_time = $request->$start_time_input;
                $office_time->end_time = $request->$end_time_input;
                $office_time->working_hour = $request->$working_hour_input??0;
                $office_time->save();

            }

        }catch (\Exception $exception){
            DB::rollBack();
            throw new \Exception($exception->getMessage());
        }

        DB::commit();

    }

    public function getEditData($id)
    {
        $data['item'] = SettingsOfficeTimeType::with('officeTimes')
            ->where('id', $id)
            ->where('deleted', SettingsOfficeTimeType::DELETED_NO)
            ->first();

        return $data;
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $type = SettingsOfficeTimeType::find($id);
            $type->name = $request->name;
            $type->description = $request->description;
            $type->updated_at = Carbon::now();
            $type->updated_by = auth()->id();
            $type->save();

            foreach ($request->days as $key=> $day){
                $is_weekend_input = $day.'_is_weekend';
                $start_time_input = $day.'_start_time';
                $end_time_input = $day.'_end_time';
                $working_hour_input = $day.'_working_hour';

                if(isset($request->$is_weekend_input) && ($request->$is_weekend_input == 1)) {
                    $is_weekend = 1;
                } else {
                    $is_weekend = 0;
                }

                $office_time = SettingsOfficeTime::where('office_time_type_id', $type->id)
                    ->where('day', $day)
                    ->first();

                if(!$office_time){
                    $office_time = new SettingsOfficeTime();
                }

                $office_time->office_time_type_id = $type->id;
                $office_time->day = $day;
                $office_time->is_weekend = $is_weekend;
                $office_time->start_time = $request->$start_time_input;
                $office_time->end_time = $request->$end_time_input;
                $office_time->working_hour = $request->$working_hour_input??0;
                $office_time->save();

            }

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
            $type = SettingsOfficeTimeType::find($id);
            $type->deleted = SettingsOfficeTimeType::DELETED_YES;
            $type->status = SettingsOfficeTimeType::STATUS_INACTIVE;
            $type->deleted_at = Carbon::now();
            $type->deleted_by = auth()->id();
            $type->save();
        }catch (\Exception $exception){
            DB::rollBack();
            throw new \Exception($exception->getMessage());
        }

        DB::commit();
    }

}
