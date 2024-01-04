<?php

namespace App\Services\Hr;

use App\Models\SettingsTerminationType;
use App\Models\User;
use App\Models\UserTermination;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class UserTerminationService
{
    public function __construct()
    {
        $this->paginate_limit = config('commonData.paginate_limit');
    }

    public function getIndexData()
    {
        $data['terminationTypes'] = SettingsTerminationType::where('deleted', SettingsTerminationType::DELETED_NO)
            ->orderBy('name', 'asc')
            ->get();
        $data['employees'] = User::where('deleted', User::DELETED_NO)
//            ->where(function ($q) {
//                $q->where('terminated', User::TERMINATED_NO)
//                    ->orWhere('terminate_date', '>', Carbon::now());
//            })
            ->where('terminated', User::TERMINATED_NO)
            ->where(function ($q) {
                $q->where('resigned', User::RESIGNED_NO)
                    ->orWhere('resign_date', '>', Carbon::now());
            })
            ->where('status', User::STATUS_ACTIVE)
            ->where('role', User::ROLE_EMPLOYEE)
            ->where('type', User::TYPE_EMPLOYEE)
            ->orderBy('first_name', 'asc')
            ->get();
        return $data;
    }

    public function getIndexFilteredData($request)
    {
        $data['userTerminations'] = UserTermination::with('user', 'settingsTerminationType')
            ->where('deleted', UserTermination::DELETED_NO)
            ->orderBy('id', 'desc')
            ->paginate($this->paginate_limit);

        return $data;
    }

    public function store($request)
    {
        DB::beginTransaction();
        try {
            $chek_user = User::where('id', $request->user_id)
                ->where('deleted', User::DELETED_NO)
                ->first();
            if (!$chek_user) {
                throw new \Exception("User not found");
            }
            $userTermination = new UserTermination();
            $userTermination->user_id = $request->user_id;
            $userTermination->settings_termination_type_id = $request->settings_termination_type_id;
            $userTermination->notice_date = Carbon::now();
            $userTermination->termination_date = $request->termination_date;
            $userTermination->reason = $request->reason;
            $userTermination->termination_status = UserTermination::TERMINATION_STATUS_APPROVED;
            $userTermination->created_at = Carbon::now();
            $userTermination->created_by = auth()->user()->id;
            $userTermination->updated_at = Carbon::now();
            $userTermination->updated_by = auth()->user()->id;
            $userTermination->save();

            $chek_user->terminated = User::TERMINATED_YES;
            $chek_user->terminate_date = $request->termination_date;
            $chek_user->updated_at = Carbon::now();
            $chek_user->updated_by = auth()->user()->id;
            $chek_user->save();

        }catch (\Exception $exception) {
            DB::rollBack();
            throw new \Exception($exception->getMessage());
        }
        DB::commit();
    }

    public function getEditData($id)
    {
        $data['item'] = UserTermination::with('user', 'settingsTerminationType')
            ->where('deleted', UserTermination::DELETED_NO)
            ->where('id', $id)
            ->first();
        if (!$data['item']) {
            throw new \Exception("Data not found");
        }
        $data['terminationTypes'] = SettingsTerminationType::where('deleted', SettingsTerminationType::DELETED_NO)
            ->orderBy('name', 'asc')
            ->get();
        return $data;
    }

    public function update($request, $id)
    {
        DB::beginTransaction();
        try {
            $userTermination = UserTermination::where('id', $id)
                ->where('deleted', UserTermination::DELETED_NO)
                ->first();
            if (!$userTermination) {
                throw new \Exception("Data not found");
            }
            $chek_user = User::where('id', $userTermination->user_id)
                ->where('deleted', User::DELETED_NO)
                ->first();
            if (!$chek_user) {
                throw new \Exception("User not found");
            }
            $userTermination->settings_termination_type_id = $request->settings_termination_type_id;
            $userTermination->termination_date = $request->termination_date;
            $userTermination->reason = $request->reason;
            $userTermination->updated_at = Carbon::now();
            $userTermination->updated_by = auth()->user()->id;
            $userTermination->save();

            $chek_user->terminate_date = $request->termination_date;
            $chek_user->updated_at = Carbon::now();
            $chek_user->updated_by = auth()->user()->id;
            $chek_user->save();

        }catch (\Exception $exception) {
            DB::rollBack();
            throw new \Exception($exception->getMessage());
        }
        DB::commit();
    }

    public function delete($id)
    {
        DB::beginTransaction();
        try {
            $userTermination = UserTermination::where('id', $id)
                ->where('deleted', UserTermination::DELETED_NO)
                ->first();
            if (!$userTermination) {
                throw new \Exception("Data not found");
            }
            $chek_user = User::where('id', $userTermination->user_id)
                ->where('deleted', User::DELETED_NO)
                ->first();
            if (!$chek_user) {
                throw new \Exception("User not found");
            }

            $userTermination->deleted = UserTermination::DELETED_YES;
            $userTermination->deleted_at = Carbon::now();
            $userTermination->deleted_by = auth()->user()->id;
            $userTermination->save();

            $chek_user->terminated = User::TERMINATED_NO;
            $chek_user->terminate_date = null;
            $chek_user->updated_at = Carbon::now();
            $chek_user->updated_by = auth()->user()->id;
            $chek_user->save();

        }catch (\Exception $exception) {
            DB::rollBack();
            throw new \Exception($exception->getMessage());
        }
        DB::commit();

    }
}
