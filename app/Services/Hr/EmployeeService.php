<?php

namespace App\Services\Hr;

use App\Models\Department;
use App\Models\Designation;
use App\Models\User;
use App\Models\UserBankInfo;
use App\Models\UserEducationInfo;
use App\Models\UserEmergencyContact;
use App\Services\Common\ImageUploadService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class EmployeeService
{
    public function __construct()
    {
        $this->paginate_limit = config('commonData.paginate_limit');
    }
    public function getIndexFilteredData($request)
    {
        $keyword = $request->keyword_filtered??null;
        $data['employees'] = User::with('designation', 'department')
            ->where('type', User::TYPE_EMPLOYEE)
            ->where('role', User::ROLE_EMPLOYEE)
            ->where('deleted', User::DELETED_NO)
            ->where(function ($query) use ($keyword) {
                if ($keyword != null && $keyword != '') {
                    $query->where('first_name', 'LIKE', "%{$keyword}%");
                    $query->orWhere('last_name', 'LIKE', "%{$keyword}%");
                    $query->orWhere('email', 'LIKE', "%{$keyword}%");
                    $query->orWhere('phone', 'LIKE', "%{$keyword}%");
                    $query->orWhere('employee_id', 'LIKE', "%{$keyword}%");
                }
            })
            ->orderBy('first_name', 'asc')
            ->paginate($this->paginate_limit);

        return $data;
    }

    public function getCreateData(){
        $data['departments'] = Department::where('deleted', Department::DELETED_NO)
            ->orderBy('name', 'asc')
            ->get();
        $data['designations'] = Designation::where('deleted', Designation::DELETED_NO)
            ->orderBy('name', 'asc')
            ->get();

        return $data;

    }

    public function storeEmployee($request)
    {
        DB::beginTransaction();
        try {
            $check_email = User::where('email', $request->email)
                ->where('deleted', User::DELETED_NO)
                ->first();
            if ($check_email){

                throw new \Exception("Email already exists");
            }

            $check_phone = User::where('phone', $request->phone)
                ->where('deleted', User::DELETED_NO)
                ->first();
            if ($check_phone){
                throw new \Exception("Phone already exists");
            }
            $nid_image_path = null;
            if ($request->hasFile('nid_image')) {
                $imageUploadService = new ImageUploadService();
                $nid_image_path = $imageUploadService->store($request->nid_image, 'employee/nid');
                $nid_image_path = $nid_image_path['path'];
            }
            $passport_image_path = null;
            if ($request->hasFile('passport_image')) {
                $imageUploadService = new ImageUploadService();
                $passport_image_path = $imageUploadService->store($request->passport_image, 'employee/passport');
                $passport_image_path = $passport_image_path['path'];
            }

            // user
            $user = new User();
            $user->type = User::TYPE_EMPLOYEE;
            $user->role = User::ROLE_EMPLOYEE;
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->email = $request->email;
            $user->phone = $request->phone??null;
            $user->joining_date = $request->joining_date;
            $user->designation_id = $request->designation_id;
            $user->department_id = $request->department_id;
            $user->password = bcrypt($request->password);
            $user->nid_no = $request->nid_no??null;
            $user->nid_image = $nid_image_path??null;
            $user->passport_no = $request->passport_no??null;
            $user->passport_expiry_date = $request->passport_expiry_date??null;
            $user->passport_image = $passport_image_path??null;
            $user->date_of_birth = $request->date_of_birth??null;
            $user->gender = $request->gender??null;
            $user->religion = $request->religion??null;
            $user->marital_status = $request->marital_status??null;
            $user->marriage_date = $request->marriage_date??null;
            $user->present_address = $request->present_address??null;
            $user->permanent_address = $request->permanent_address??null;
            $user->created_by = auth()->id();
            $user->created_at = Carbon::now();
            $user->updated_by = auth()->id();
            $user->updated_at = Carbon::now();
            $user->save();

            // user emergency contact
            if(is_array($request->contact_name) && count($request->contact_name) > 0){
                foreach ($request->contact_name as $key => $value){
                    if($request->contact_name[$key] == '' || $request->contact_name[$key] == null){
                        continue;
                    }

                    $contact = new UserEmergencyContact();
                    $contact->user_id = $user->id;
                    $contact->name = $request->contact_name[$key];
                    $contact->phone = $request->contact_phone[$key];
                    $contact->email = $request->contact_email[$key];
                    $contact->relation = $request->contact_relation[$key];
                    $contact->status = UserEmergencyContact::STATUS_ACTIVE;
                    $contact->save();
                }
            }

            // user back info
            if ($request->bank_name !=null && $request->bank_name !=''){

                $user_bank_info = new UserBankInfo();
                $user_bank_info->user_id = $user->id;
                $user_bank_info->bank_name = $request->bank_name;
                $user_bank_info->branch_name = $request->branch_name;
                $user_bank_info->account_name = $request->account_name;
                $user_bank_info->account_number = $request->account_number;
                $user_bank_info->routing_number = $request->routing_number;
                $user_bank_info->swift_code = $request->swift_code;
                $user_bank_info->note = $request->note;
                $user_bank_info->created_by = auth()->id();
                $user_bank_info->created_at = Carbon::now();
                $user_bank_info->updated_by = auth()->id();
                $user_bank_info->updated_at = Carbon::now();
                $user_bank_info->save();

            }

            // user education info
            if(is_array($request->degree) && count($request->degree) > 0){
                foreach ($request->degree as $key => $value){
                    if($request->degree[$key] == '' || $request->degree[$key] == null){
                        continue;
                    }
                    $user_edu_info = new UserEducationInfo();
                    $user_edu_info->user_id = $user->id;
                    $user_edu_info->degree = $request->degree[$key];
                    $user_edu_info->institute_name = $request->institute_name[$key];
                    $user_edu_info->subject = $request->subject[$key];
                    $user_edu_info->grade = $request->grade[$key];
                    $user_edu_info->start_date = $request->start_date[$key];
                    $user_edu_info->end_date = $request->end_date[$key];
                    $user_edu_info->created_by = auth()->id();
                    $user_edu_info->created_at = Carbon::now();
                    $user_edu_info->updated_by = auth()->id();
                    $user_edu_info->updated_at = Carbon::now();
                    $user_edu_info->save();
                }
            }


        }catch (\Exception $exception) {
            DB::rollBack();
             throw new \Exception($exception->getMessage());
        }
        DB::commit();
    }

    public function getEditData($id)
    {
        $data['departments'] = Department::where('deleted', Department::DELETED_NO)
            ->orderBy('name', 'asc')
            ->get();
        $data['designations'] = Designation::where('deleted', Designation::DELETED_NO)
            ->orderBy('name', 'asc')
            ->get();
        $data['employee'] = User::with('designation', 'department')
            ->where('id', $id)
            ->where('deleted', User::DELETED_NO)
            ->first();
        if (!$data['employee']){
            throw new \Exception("Employee not found!");
        }

        return $data;
    }

    public function deleteEmployee($id)
    {
        DB::beginTransaction();
        try {
            $user = User::where('id', $id)
                ->where('deleted', User::DELETED_NO)
                ->first();
            if (!$user){
                throw new \Exception("Employee not found!");
            }
            $user->status = User::STATUS_INACTIVE;
            $user->deleted = User::DELETED_YES;
            $user->deleted_at = Carbon::now();
            $user->deleted_by = auth()->id();
            $user->save();

            $user_contact = UserEmergencyContact::where('user_id', $id)
                ->get();
            if ($user_contact){
                foreach ($user_contact as $contact){
                    $contact->status = UserEmergencyContact::STATUS_INACTIVE;
                    $contact->save();
                }
            }

            $user_bank_info = UserBankInfo::where('user_id', $id)
                ->where('deleted', UserBankInfo::DELETED_NO)
                ->get();
            if ($user_bank_info){
                foreach ($user_bank_info as $bank_info){
                    $bank_info->status = UserBankInfo::STATUS_INACTIVE;
                    $bank_info->deleted = UserBankInfo::DELETED_YES;
                    $bank_info->deleted_at = Carbon::now();
                    $bank_info->deleted_by = auth()->id();
                    $bank_info->save();
                }
            }

            $user_edu_info = UserEducationInfo::where('user_id', $id)
                ->where('deleted', UserEducationInfo::DELETED_NO)
                ->get();
            if ($user_edu_info){
                foreach ($user_edu_info as $edu_info){
                    $edu_info->status = UserEducationInfo::STATUS_INACTIVE;
                    $edu_info->deleted = UserEducationInfo::DELETED_YES;
                    $edu_info->deleted_at = Carbon::now();
                    $edu_info->deleted_by = auth()->id();
                    $edu_info->save();
                }
            }
        }catch (\Exception $exception) {
            DB::rollBack();
            throw new \Exception($exception->getMessage());
        }
        DB::commit();
    }
}
