<?php

namespace App\Services\Hr;

use App\Models\User;
use App\Models\UserResignation;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class UserResignationService
{

    public function __construct()
    {
        $this->paginate_limit = config('commonData.paginate_limit');
    }

    public function getIndexData($request)
    {

        $data['employees'] = User::where('deleted', User::DELETED_NO)
            ->where('status', User::STATUS_ACTIVE)
            ->where('type', User::TYPE_EMPLOYEE)
            ->where('role', User::ROLE_EMPLOYEE)
           /* ->where(function ($q) {
                $q->where('terminated', User::TERMINATED_NO)
                    ->orWhere('terminate_date', '>', Carbon::now());
            })*/
           ->where('terminated', User::TERMINATED_NO)
            ->where('resigned', User::RESIGNED_NO)
//            ->where(function ($q) {
//                $q->where('resigned', User::RESIGNED_NO)
//                    ->orWhere('resign_date', '>', Carbon::now());
//            })
            ->get();

        return $data;
    }

    public function getIndexFilteredData($request)
    {
        $data['userResignations'] = UserResignation::with('user')
            ->where('deleted', UserResignation::DELETED_NO)
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
            $userResignation = new UserResignation();
            $userResignation->user_id = $request->user_id;
            $userResignation->notice_date = $request->notice_date;
            $userResignation->resignation_date = $request->resignation_date;
            $userResignation->reason = $request->reason;
            $userResignation->resignation_status = UserResignation::RESIGNATION_STATUS_APPROVED;
            $userResignation->approved_at = Carbon::now();
            $userResignation->approved_by = auth()->user()->id;
            $userResignation->created_at = Carbon::now();
            $userResignation->created_by = auth()->user()->id;
            $userResignation->updated_at = Carbon::now();
            $userResignation->updated_by = auth()->user()->id;
            $userResignation->save();

            $chek_user->resigned = User::RESIGNED_YES;
            $chek_user->resign_date = $request->resignation_date;
            $chek_user->save();

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
        DB::beginTransaction();
        try {

            $userResignation = UserResignation::where('deleted', UserResignation::DELETED_NO)
                ->where('id', $id)
                ->first();
            if (!$userResignation) {
                throw new \Exception("Data not found");
            }
            $chek_user = User::where('id', $userResignation->user_id)
                ->where('deleted', User::DELETED_NO)
                ->first();

            if (!$chek_user) {
                throw new \Exception("User not found");
            }

            $userResignation->notice_date = $request->notice_date;
            $userResignation->resignation_date = $request->resignation_date;
            $userResignation->reason = $request->reason;
            $userResignation->updated_at = Carbon::now();
            $userResignation->updated_by = auth()->user()->id;
            $userResignation->save();

            $chek_user->resigned = User::RESIGNED_YES;
            $chek_user->resign_date = $request->resignation_date;
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

            $userResignation = UserResignation::where('deleted', UserResignation::DELETED_NO)
                ->where('id', $id)
                ->first();
            if (!$userResignation) {
                throw new \Exception("Data not found");
            }
            $chek_user = User::where('id', $userResignation->user_id)
                ->where('deleted', User::DELETED_NO)
                ->first();

            if (!$chek_user) {
                throw new \Exception("User not found");
            }

            $userResignation->deleted = UserResignation::DELETED_YES;
            $userResignation->deleted_at = Carbon::now();
            $userResignation->deleted_by = auth()->user()->id;
            $userResignation->save();

            $chek_user->resigned = User::RESIGNED_NO;
            $chek_user->resign_date = null;
            $chek_user->save();

        }catch (\Exception $exception) {
            DB::rollBack();
            throw new \Exception($exception->getMessage());
        }
        DB::commit();
    }

    public function statusUpdate($id, $status)
    {
        DB::beginTransaction();
        try {

            $userResignation = UserResignation::where('deleted', UserResignation::DELETED_NO)
                ->where('id', $id)
                ->first();
            if (!$userResignation) {
                throw new \Exception("Data not found");
            }
            $chek_user = User::where('id', $userResignation->user_id)
                ->where('deleted', User::DELETED_NO)
                ->first();

            if (!$chek_user) {
                throw new \Exception("User not found");
            }

            if ($status == UserResignation::RESIGNATION_STATUS_APPROVED) {
                $userResignation->resignation_status = UserResignation::RESIGNATION_STATUS_APPROVED;
                $userResignation->approved_at = Carbon::now();
                $userResignation->approved_by = auth()->user()->id;
                $userResignation->save();

                $chek_user->resigned = User::RESIGNED_YES;
                $chek_user->resign_date = $userResignation->resignation_date;
                $chek_user->save();

                $userLifecycleService = new UserLifecycleService();
                $userLifecycleService->storeResignationRequestApproved($userResignation);

            }elseif ($status == UserResignation::RESIGNATION_STATUS_REJECTED) {
                $userResignation->resignation_status = UserResignation::RESIGNATION_STATUS_REJECTED;
                $userResignation->rejected_at = Carbon::now();
                $userResignation->rejected_by = auth()->user()->id;
                $userResignation->save();

                $chek_user->resigned = User::RESIGNED_NO;
                $chek_user->resign_date = null;
                $chek_user->save();

                $userLifecycleService = new UserLifecycleService();
                $userLifecycleService->storeResignationRequestRejected($userResignation);
            }else {
                throw new \Exception("Invalid status");
            }

        }catch (\Exception $exception) {
            DB::rollBack();
            throw new \Exception($exception->getMessage());
        }
        DB::commit();
    }

    public function statusReject($id)
    {
        try {
            $data['item'] = UserResignation::with('user')
                ->where('deleted', UserResignation::DELETED_NO)
                ->where('id', $id)
                ->first();
            if (!$data['item']) {
                throw new \Exception("Data not found");
            }
            return $data;
        }catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }
    }

    public function statusRejectUpdate($id, $request)
    {
        DB::beginTransaction();
        try {

            $userResignation = UserResignation::where('deleted', UserResignation::DELETED_NO)
                ->where('id', $id)
                ->first();
            if (!$userResignation) {
                throw new \Exception("Data not found");
            }
            $chek_user = User::where('id', $userResignation->user_id)
                ->where('deleted', User::DELETED_NO)
                ->first();

            if (!$chek_user) {
                throw new \Exception("User not found");
            }

            $userResignation->resignation_status = UserResignation::RESIGNATION_STATUS_REJECTED;
            $userResignation->rejected_at = Carbon::now();
            $userResignation->rejected_by = auth()->user()->id;
            $userResignation->reject_reason = $request->reject_reason;
            $userResignation->save();

            $chek_user->resigned = User::RESIGNED_NO;
            $chek_user->resign_date = null;
            $chek_user->save();

            $userLifecycleService = new UserLifecycleService();
            $userLifecycleService->storeResignationRequestRejected($userResignation);

        }catch (\Exception $exception) {
            DB::rollBack();
            throw new \Exception($exception->getMessage());
        }
        DB::commit();
    }

}
