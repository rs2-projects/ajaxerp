<?php

namespace App\Services\Settings;

use App\Models\SettingsTerminationType;
use Carbon\Carbon;

class TerminationTypeSettingsService
{
    public function __construct()
    {
        $this->paginate_limit = config('commonData.paginate_limit');
    }

    public function getIndexFilteredData($request)
    {
        $data['terminationTypes'] = SettingsTerminationType::where('deleted', SettingsTerminationType::DELETED_NO)
            ->orderBy('name', 'asc')
            ->paginate($this->paginate_limit);

        return $data;
    }

    public function store($request)
    {
        try {
            $terminationType = new SettingsTerminationType();
            $terminationType->name = $request->name;
            $terminationType->description = $request->description;
            $terminationType->created_at = Carbon::now();
            $terminationType->created_by = auth()->user()->id;
            $terminationType->updated_at = Carbon::now();
            $terminationType->updated_by = auth()->user()->id;
            $terminationType->save();
        }catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }


    }

    public function getEditData($id)
    {
        try {
            $data['item'] = SettingsTerminationType::where('id', $id)
                ->where('deleted', SettingsTerminationType::DELETED_NO)
                ->first();
            if (!$data['item']) {
                throw new \Exception("Termination Type not found");
            }
            return $data;
        }catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }
    }

    public function update($request, $id)
    {
        try {
            $terminationType = SettingsTerminationType::where('id', $id)
                ->where('deleted', SettingsTerminationType::DELETED_NO)
                ->first();
            if (!$terminationType) {
                throw new \Exception("Termination Type not found");
            }
            $terminationType->name = $request->name;
            $terminationType->description = $request->description;
            $terminationType->updated_at = Carbon::now();
            $terminationType->updated_by = auth()->user()->id;
            $terminationType->save();
        }catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $terminationType = SettingsTerminationType::where('id', $id)
                ->where('deleted', SettingsTerminationType::DELETED_NO)
                ->first();
            if (!$terminationType) {
                throw new \Exception("Termination Type not found");
            }
            $terminationType->deleted = SettingsTerminationType::DELETED_YES;
            $terminationType->deleted_at = Carbon::now();
            $terminationType->deleted_by = auth()->user()->id;
            $terminationType->save();
        }catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }
    }
}
