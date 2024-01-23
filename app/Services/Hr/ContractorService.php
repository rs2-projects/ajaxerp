<?php

namespace App\Services\Hr;

use App\Models\Contractor;
use App\Models\ContractorEmergencyContact;
use App\Models\SettingsSalarySetEmployee;
use App\Models\User;
use App\Services\Common\ImageUploadService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ContractorService
{
    public function __construct()
    {
        $this->paginate_limit = config('commonData.paginate_limit');
    }

    public function getIndexData()
    {
        $salarySetEmployeeIds = SettingsSalarySetEmployee::where('deleted', SettingsSalarySetEmployee::DELETED_NO)
            ->pluck('employee_id')
            ->toArray();

        $data['employees'] = User::where('deleted', User::DELETED_NO)
            ->whereNotIn('id', $salarySetEmployeeIds)
            ->where(function ($q) {
                $q->where('terminated', User::TERMINATED_NO)
                    ->orWhere('terminate_date', '>', Carbon::now());
            })
            ->where(function ($q) {
                $q->where('resigned', User::RESIGNED_NO)
                    ->orWhere('resign_date', '>', Carbon::now());
            })
            ->where('is_contracted', User::CONTRACTED_NO)
            ->where('status', User::STATUS_ACTIVE)
            ->where('role', User::ROLE_EMPLOYEE)
            ->where('type', User::TYPE_EMPLOYEE)
            ->orderBy('first_name', 'asc')
            ->get();
        return $data;
    }

    public function getIndexFilteredData($request)
    {
        $data['userContractors'] = Contractor::with('emergencyContacts')
            ->where('deleted', Contractor::DELETED_NO)
            ->orderBy('id', 'desc')
            ->paginate($this->paginate_limit);

        return $data;
    }

    public function store($request)
    {
        DB::beginTransaction();
        try {

            $image_path = $request->image;
            if ($request->hasFile('image')) {
                $imageUploadService = new ImageUploadService();
                $image_path = $imageUploadService->update($request->image, 'contractor/image', $request->image);
                $image_path = $image_path['path'];
            }

            $check_email = Contractor::where('email', $request->email)
                ->where('deleted', Contractor::DELETED_NO)
                ->first();
            if ($check_email) {
                throw new \Exception("Email already exist");
            }

            $check_phone = Contractor::where('phone', $request->phone)
                ->where('deleted', Contractor::DELETED_NO)
                ->first();
            if ($check_phone) {
                throw new \Exception("Phone already exist");
            }

            // contractor
            $contractor = new Contractor();
            $contractor->name = $request->name;
            $contractor->phone = $request->phone;
            $contractor->phone2 = $request->phone2;
            $contractor->email = $request->email;
            $contractor->contract_value = $request->contract_value;
            $contractor->company_name = $request->company_name;
            $contractor->company_address = $request->company_address;
            $contractor->image = $image_path?? null;
            $contractor->created_at = Carbon::now();
            $contractor->created_by = auth()->user()->id;
            $contractor->updated_at = Carbon::now();
            $contractor->updated_by = auth()->user()->id;
            $contractor->save();

            // emergency contact
            if(is_array($request->contact_name) && count($request->contact_name) > 0){
                foreach ($request->contact_name as $key => $value){
                    if($request->contact_name[$key] == '' || $request->contact_name[$key] == null){
                        continue;
                    }

                    $contact = new ContractorEmergencyContact();
                    $contact->contractor_id = $contractor->id;
                    $contact->name = $request->contact_name[$key];
                    $contact->phone = $request->contact_phone[$key];
                    $contact->email = $request->contact_email[$key];
                    $contact->relationship = $request->contact_relation[$key];
                    $contact->status = ContractorEmergencyContact::STATUS_ACTIVE;
                    $contact->save();
                }
            }

            // if employee_id[] is not null then update employee is_contracted = 1
            if(is_array($request->employee_id) && count($request->employee_id) > 0){
                foreach ($request->employee_id as $key => $value){
                    if($request->employee_id[$key] == '' || $request->employee_id[$key] == null){
                        continue;
                    }

                    $check_employee = User::where('id', $request->employee_id[$key])
                        ->where('deleted', User::DELETED_NO)
                        ->where('status', User::STATUS_ACTIVE)
                        ->where('role', User::ROLE_EMPLOYEE)
                        ->where('type', User::TYPE_EMPLOYEE)
                        ->where('is_contracted', User::CONTRACTED_NO)
                        ->where(function ($q) {
                            $q->where('terminated', User::TERMINATED_NO)
                                ->orWhere('terminate_date', '>', Carbon::now());
                        })
                        ->where(function ($q) {
                            $q->where('resigned', User::RESIGNED_NO)
                                ->orWhere('resign_date', '>', Carbon::now());
                        })
                        ->first();

                    if($check_employee){
                        $check_employee->is_contracted = User::CONTRACTED_YES;
                        $check_employee->contractor_id = $contractor->id;
                        $check_employee->updated_at = Carbon::now();
                        $check_employee->updated_by = auth()->user()->id;
                        $check_employee->save();
                    }
                }
            }

        } catch (\Exception $exception) {
            DB::rollBack();
            throw new \Exception($exception->getMessage());
        }
        DB::commit();

    }

    public function getEditData($id)
    {
        $data['item'] = Contractor::with('emergencyContacts')
            ->where('deleted', Contractor::DELETED_NO)
            ->where('id', $id)
            ->first();

        $salarySetEmployeeIds = SettingsSalarySetEmployee::where('deleted', SettingsSalarySetEmployee::DELETED_NO)
            ->pluck('employee_id')
            ->toArray();

        $data['employees'] = User::where('deleted', User::DELETED_NO)
            ->whereNotIn('id', $salarySetEmployeeIds)
            ->where(function ($q) {
                $q->where('terminated', User::TERMINATED_NO)
                    ->orWhere('terminate_date', '>', Carbon::now());
            })
            ->where(function ($q) {
                $q->where('resigned', User::RESIGNED_NO)
                    ->orWhere('resign_date', '>', Carbon::now());
            })
            ->where(function ($q) use ($id) {
                $q->where('is_contracted', User::CONTRACTED_NO)
                    ->orWhere('contractor_id', $id);
            })
            ->where('status', User::STATUS_ACTIVE)
            ->where('role', User::ROLE_EMPLOYEE)
            ->where('type', User::TYPE_EMPLOYEE)
            ->orderBy('first_name', 'asc')
            ->get();

        $data['selected_employee_ids'] = User::where('deleted', User::DELETED_NO)
            ->where('contractor_id', $id)
            ->where('status', User::STATUS_ACTIVE)
            ->where('role', User::ROLE_EMPLOYEE)
            ->where('type', User::TYPE_EMPLOYEE)
            ->orderBy('first_name', 'asc')
            ->pluck('id')
            ->toArray();

        if(!$data['item']){
            throw new \Exception("Data not found");
        }

        return $data;
    }

    public function update($request, $id)
    {
        DB::beginTransaction();
        try {


            $check_email = Contractor::where('email', $request->email)
                ->where('deleted', Contractor::DELETED_NO)
                ->where('id', '!=', $id)
                ->first();
            if ($check_email) {
                throw new \Exception("Email already exist");
            }

            $check_phone = Contractor::where('phone', $request->phone)
                ->where('deleted', Contractor::DELETED_NO)
                ->where('id', '!=', $id)
                ->first();
            if ($check_phone) {
                throw new \Exception("Phone already exist");
            }

            // contractor
            $contractor = Contractor::where('deleted', Contractor::DELETED_NO)
                ->where('id', $id)
                ->first();
            if(!$contractor){
                throw new \Exception("Data not found");
            }

            $image_path = $contractor->image;
            if ($request->hasFile('image')) {
                $imageUploadService = new ImageUploadService();
                $image_path = $imageUploadService->update($request->image, 'contractor/image', $contractor->image);
                $image_path = $image_path['path'];
            }

            $contractor->name = $request->name;
            $contractor->phone = $request->phone;
            $contractor->phone2 = $request->phone2;
            $contractor->email = $request->email;
            $contractor->contract_value = $request->contract_value;
            $contractor->company_name = $request->company_name;
            $contractor->company_address = $request->company_address;
            $contractor->image = $image_path?? null;
            $contractor->updated_at = Carbon::now();
            $contractor->updated_by = auth()->user()->id;
            $contractor->save();

            // emergency contact

            if (is_array($request->contact_name) && count($request->contact_name)> 0){
                // check if not exist then delete first
                $contact_ids = $request->contact_id??[];
                $user_contact = ContractorEmergencyContact::where('contractor_id', $contractor->id)
                    ->whereNotIn('id', $contact_ids)
                    ->delete();
                foreach ($request->contact_name as $key => $value){
                    if (!isset($request->contact_name[$key])){
                        continue;
                    }
                    if ($request->contact_name[$key] == '' || $request->contact_name[$key] == null){
                        continue;
                    }
                    if (isset($request->contact_id[$key]) &&  $request->contact_id[$key] != null){
                        // update
                        $contact = ContractorEmergencyContact::where('id', $request->contact_id[$key])
                            ->where('contractor_id', $contractor->id)
                            ->first();
                        if ($contact){
                            $contact->name = $request->contact_name[$key];
                            $contact->phone = $request->contact_phone[$key];
                            $contact->email = $request->contact_email[$key];
                            $contact->relationship = $request->contact_relation[$key];
                            $contact->save();
                        }
                    }else{
                        // create
                        $contact = new ContractorEmergencyContact();
                        $contact->contractor_id = $contractor->id;
                        $contact->name = $request->contact_name[$key];
                        $contact->phone = $request->contact_phone[$key];
                        $contact->email = $request->contact_email[$key];
                        $contact->relationship = $request->contact_relation[$key];
                        $contact->status = ContractorEmergencyContact::STATUS_ACTIVE;
                        $contact->save();
                    }

                }

            }

            $get_request_employee_ids = $request->employee_id??[];
            $get_contract_employee_ids = User::where('deleted', User::DELETED_NO)
                ->where('contractor_id', $id)
                ->where('id', '!=', $get_request_employee_ids)
                ->where('is_contracted', User::CONTRACTED_YES)
                ->where('status', User::STATUS_ACTIVE)
                ->where('role', User::ROLE_EMPLOYEE)
                ->where('type', User::TYPE_EMPLOYEE)
                ->get();
            foreach ($get_contract_employee_ids as $key => $value){
                $value->is_contracted = User::CONTRACTED_NO;
                $value->contractor_id = null;
                $value->updated_at = Carbon::now();
                $value->updated_by = auth()->user()->id;
                $value->save();
            }

            if (count($get_request_employee_ids) > 0){
                foreach ($get_request_employee_ids as $key => $value){
                    if ($value == '' || $value == null){
                        continue;
                    }
                    $check_employee = User::where('id', $value)
                        ->where('deleted', User::DELETED_NO)
                        ->where('status', User::STATUS_ACTIVE)
                        ->where('role', User::ROLE_EMPLOYEE)
                        ->where('type', User::TYPE_EMPLOYEE)
                        ->where('is_contracted', User::CONTRACTED_NO)
                        ->where(function ($q) {
                            $q->where('terminated', User::TERMINATED_NO)
                                ->orWhere('terminate_date', '>', Carbon::now());
                        })
                        ->where(function ($q) {
                            $q->where('resigned', User::RESIGNED_NO)
                                ->orWhere('resign_date', '>', Carbon::now());
                        })
                        ->first();

                    if($check_employee){
                        $check_employee->is_contracted = User::CONTRACTED_YES;
                        $check_employee->contractor_id = $contractor->id;
                        $check_employee->updated_at = Carbon::now();
                        $check_employee->updated_by = auth()->user()->id;
                        $check_employee->save();
                    }
                }
            }


        } catch (\Exception $exception) {
            DB::rollBack();
            throw new \Exception($exception->getMessage());
        }
        DB::commit();

    }

    public function delete($id)
    {
        DB::beginTransaction();
        try {
            $contractor = Contractor::where('deleted', Contractor::DELETED_NO)
                ->where('id', $id)
                ->first();
            if(!$contractor){
                throw new \Exception("Data not found");
            }

            $contractor->deleted = Contractor::DELETED_YES;
            $contractor->deleted_at = Carbon::now();
            $contractor->deleted_by = auth()->user()->id;
            $contractor->save();

            $get_contract_employee_ids = User::where('deleted', User::DELETED_NO)
                ->where('contractor_id', $id)
                ->where('is_contracted', User::CONTRACTED_YES)
                ->where('status', User::STATUS_ACTIVE)
                ->where('role', User::ROLE_EMPLOYEE)
                ->where('type', User::TYPE_EMPLOYEE)
                ->get();
            foreach ($get_contract_employee_ids as $key => $value){
                $value->is_contracted = User::CONTRACTED_NO;
                $value->contractor_id = null;
                $value->updated_at = Carbon::now();
                $value->updated_by = auth()->user()->id;
                $value->save();
            }

        } catch (\Exception $exception) {
            DB::rollBack();
            throw new \Exception($exception->getMessage());
        }
        DB::commit();
    }

}
