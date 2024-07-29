<?php

namespace App\Services\User;

use App\Models\UserResignation;
use App\Services\Hr\UserLifecycleService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ResignationService
{
    public function __construct()
    {
        $this->paginate_limit = config('commonData.paginate_limit');
    }

    public function getIndexData($request)
    {
        $data['check_resignation'] = UserResignation::where('user_id', auth()->user()->id)
            ->where('deleted', UserResignation::DELETED_NO)
            ->whereNot('resignation_status', UserResignation::RESIGNATION_STATUS_REJECTED)
            ->first();

        return $data;
    }

    public function getIndexFilteredData($request)
    {
        $auth_user = auth()->user();
        $data['userResignations'] = UserResignation::with('user')
            ->where('deleted', UserResignation::DELETED_NO)
            ->orderBy('id', 'desc')
            ->where('user_id', $auth_user->id)
            ->paginate($this->paginate_limit);

        return $data;
    }

    public function store($request)
    {
        DB::beginTransaction();
        try {
            $auth_user = auth()->user();
            $check_resignation = UserResignation::where('user_id', $auth_user->id)
                ->where('deleted', UserResignation::DELETED_NO)
                ->whereNot('resignation_status', UserResignation::RESIGNATION_STATUS_REJECTED)
                ->first();
            if ($check_resignation) {
                throw new \Exception("You have already submitted a resignation request.");
            }
            $resignation = new UserResignation();
            $resignation->user_id = $auth_user->id;
            $resignation->notice_date = Carbon::now();
            $resignation->resignation_date = $request->resignation_date;
            $resignation->reason = $request->reason;
            $resignation->resignation_status = UserResignation::RESIGNATION_STATUS_PENDING;
            $resignation->created_at = Carbon::now();
            $resignation->created_by = $auth_user->id;
            $resignation->updated_at = Carbon::now();
            $resignation->updated_by = $auth_user->id;
            $resignation->save();

            $userLifecycleService = new UserLifecycleService();
            $userLifecycleService->storeResignationRequest($resignation);
        }catch (\Exception $exception) {
            DB::rollBack();
            throw new \Exception($exception->getMessage());
        }
        DB::commit();
    }

    public function getEditData($id)
    {
        $data['item'] = UserResignation::with('user')
            ->where('deleted', UserResignation::DELETED_NO)
            ->where('id', $id)
            ->first();

        return $data;
    }

    public function update($request, $id)
    {
        try {
            $auth_user = auth()->user();
            $resignation = UserResignation::where('id', $id)
                ->where('deleted', UserResignation::DELETED_NO)
                ->where('user_id', $auth_user->id)
                ->first();
            if (!$resignation) {
                throw new \Exception("Data not found");
            }
            $resignation->resignation_date = $request->resignation_date;
            $resignation->reason = $request->reason;
            $resignation->updated_at = Carbon::now();
            $resignation->updated_by = $auth_user->id;
            $resignation->save();
        }catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $auth_user = auth()->user();
            $resignation = UserResignation::where('id', $id)
                ->where('deleted', UserResignation::DELETED_NO)
                ->where('user_id', $auth_user->id)
                ->first();
            if (!$resignation) {
                throw new \Exception("Data not found");
            }
            $resignation->deleted = UserResignation::DELETED_YES;
            $resignation->deleted_at = Carbon::now();
            $resignation->deleted_by = $auth_user->id;
            $resignation->save();
        }catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }
    }
}
