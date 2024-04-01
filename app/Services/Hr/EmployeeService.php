<?php

namespace App\Services\Hr;

use App\Models\Contractor;
use App\Models\Department;
use App\Models\Designation;
use App\Models\Permission\Role;
use App\Models\User;
use App\Models\UserBankInfo;
use App\Models\UserEducationInfo;
use App\Models\UserEmergencyContact;
use App\Models\UserExperienceInfo;
use App\Services\Common\ImageUploadService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class EmployeeService
{
    public function __construct()
    {
        $this->paginate_limit = config('commonData.paginate_limit');
    }

    public function indexData(){
        $data['departments'] = Department::where('deleted', Department::DELETED_NO)
            ->orderBy('name', 'asc')
            ->get();
        $data['designations'] = Designation::where('deleted', Designation::DELETED_NO)
            ->orderBy('name', 'asc')
            ->get();

        return $data;
    }

    public function getIndexFilteredData($request)
    {
        $keyword = $request->keyword_filtered??null;
        $department_id = $request->department_id??null;
        $designation_id = $request->designation_id??null;
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
            ->where(function ($q) use ($department_id){
                if ($department_id !=''){
                    $q->whereIn('department_id', $department_id);
                }
            })
            ->where(function ($q) use ($designation_id){
                if ($designation_id !=''){
                    $q->whereIn('designation_id', $designation_id);
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

        $data['contractors'] = Contractor::where('deleted', Contractor::DELETED_NO)
            ->where('status', Contractor::STATUS_ACTIVE)
            ->orderBy('name', 'asc')
            ->get();

        $data['roles'] = Role::where('deleted', Role::DELETED_NO)
            ->where('status', Role::STATUS_ACTIVE)
            ->orderBy('title', 'asc')
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

            if(isset($request->is_contracted)){
                if($request->contractor_id == null || $request->contractor_id == ''){
                    throw new \Exception("Contractor is required");
                }
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
            $user->role_id = $request->role_id;
            $user->department_id = $request->department_id;
            $user->is_contracted = $request->is_contracted??User::CONTRACTED_NO;
            $user->contractor_id = $request->contractor_id??null;
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
            if (is_array($request->bank_name) && count($request->bank_name) > 0){
                foreach ($request->bank_name as $key=>$item){
                    $user_bank_info = new UserBankInfo();
                    $user_bank_info->user_id = $user->id;
                    $user_bank_info->bank_name = $request->bank_name[$key];
                    $user_bank_info->branch_name = $request->branch_name[$key];
                    $user_bank_info->account_name = $request->account_name[$key];
                    $user_bank_info->account_number = $request->account_number[$key];
                    $user_bank_info->routing_number = $request->routing_number[$key];
                    $user_bank_info->swift_code = $request->swift_code[$key];
                    $user_bank_info->note = $request->note[$key];
                    $user_bank_info->created_by = auth()->id();
                    $user_bank_info->created_at = Carbon::now();
                    $user_bank_info->updated_by = auth()->id();
                    $user_bank_info->updated_at = Carbon::now();
                    $user_bank_info->save();
                }
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
        $data['employee'] = User::with('designation', 'department', 'userEmergencyContacts', 'userBankInfo', 'userEducationInfo')
            ->where('id', $id)
            ->where('deleted', User::DELETED_NO)
            ->first();
        if (!$data['employee']){
            throw new \Exception("Employee not found!");
        }

        $data['contractors'] = Contractor::where('deleted', Contractor::DELETED_NO)
            ->where('status', Contractor::STATUS_ACTIVE)
            ->orderBy('name', 'asc')
            ->get();
        
        $data['roles'] = Role::where('deleted', Role::DELETED_NO)
            ->where('status', Role::STATUS_ACTIVE)
            ->orderBy('title', 'asc')
            ->get();

        return $data;
    }


    public function updateEmployee($request, $id)
    {
        DB::beginTransaction();
        try {
            $user = User::where('id', $id)
                ->where('deleted', User::DELETED_NO)
                ->first();
            if (!$user) {
                throw new \Exception("Employee not found!");
            }

            $check_email = User::where('email', $request->email)
                ->where('deleted', User::DELETED_NO)
                ->where('id', '!=', $id)
                ->first();
            if ($check_email) {
                throw new \Exception("Email already exists");
            }

            $check_phone = User::where('phone', $request->phone)
                ->where('deleted', User::DELETED_NO)
                ->where('id', '!=', $id)
                ->first();
            if ($check_phone) {
                throw new \Exception("Phone already exists");
            }

            if(isset($request->is_contracted)){
                if($request->contractor_id == null || $request->contractor_id == ''){
                    throw new \Exception("Contractor is required");
                }
                $contractorId = $request->contractor_id;
            }else{
                $contractorId = null;
            }

            $nid_image_path = $user->nid_image;
            if ($request->hasFile('nid_image')) {
                $imageUploadService = new ImageUploadService();
                $nid_image_path = $imageUploadService->update($request->nid_image, 'employee/nid', $user->nid_image);
                $nid_image_path = $nid_image_path['path'];
            }
            $passport_image_path = $user->passport_image;
            if ($request->hasFile('passport_image')) {
                $imageUploadService = new ImageUploadService();
                $passport_image_path = $imageUploadService->update($request->passport_image, 'employee/passport', $user->passport_image);
                $passport_image_path = $passport_image_path['path'];
            }

            // user
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->email = $request->email;
            $user->phone = $request->phone ?? null;
            $user->joining_date = $request->joining_date;
            $user->designation_id = $request->designation_id;
            $user->department_id = $request->department_id;
            $user->role_id = $request->role_id;
            $user->is_contracted = $request->is_contracted??User::CONTRACTED_NO;
            $user->contractor_id = $contractorId??null;
            $user->nid_no = $request->nid_no ?? null;
            $user->nid_image = $nid_image_path ?? null;
            $user->passport_no = $request->passport_no ?? null;
            $user->passport_expiry_date = $request->passport_expiry;
            $user->passport_image = $passport_image_path ?? null;
            $user->date_of_birth = $request->date_of_birth ?? null;
            $user->gender = $request->gender??null;
            $user->religion = $request->religion??null;
            $user->marital_status = $request->marital_status??null;
            $user->marriage_date = $request->marriage_date??null;
            $user->present_address = $request->present_address??null;
            $user->permanent_address = $request->permanent_address??null;
            $user->updated_by = auth()->id();
            $user->updated_at = Carbon::now();
            $user->save();

            // user emergency contact update or create new or delete

            if (is_array($request->contact_name) && count($request->contact_name)> 0){
                // check if not exist then delete first
                $contact_ids = $request->contact_id??[];
                $user_contact = UserEmergencyContact::where('user_id', $user->id)
                    ->whereNotIn('id', $contact_ids)
                    ->delete();
                foreach ($request->contact_name as $key => $value){
                    if (!isset($request->contact_name[$key])){
                        continue;
                    }
                    if ($request->contact_name[$key] == '' || $request->contact_name[$key] == null){
                        continue;
                    }
                    if ($request->contact_id[$key] != null){
                        // update
                        $contact = UserEmergencyContact::where('id', $request->contact_id[$key])
                            ->where('user_id', $user->id)
                            ->first();
                        if ($contact){
                            $contact->name = $request->contact_name[$key];
                            $contact->phone = $request->contact_phone[$key];
                            $contact->email = $request->contact_email[$key];
                            $contact->relation = $request->contact_relation[$key];
                            $contact->save();
                        }
                    }else{
                        // create
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

            }

            // user bank info update or create new or delete

            if (is_array($request->bank_name) && count($request->bank_name) > 0){
                // check if not exist then delete first
                $bank_ids = $request->bank_id??[];
                $user_bank_info = UserBankInfo::where('user_id', $user->id)
                    ->whereNotIn('id', $bank_ids)
                    ->delete();
                foreach ($request->bank_name as $key=>$item){
                    if (!isset($request->bank_name[$key])){
                        continue;
                    }
                    if ($request->bank_name[$key] == '' || $request->bank_name[$key] == null){
                        continue;
                    }
                    if ($request->bank_id[$key] != null){
                        // update
                        $bank_info = UserBankInfo::where('id', $request->bank_id[$key])
                            ->where('user_id', $user->id)
                            ->first();
                        if ($bank_info){
                            $bank_info->bank_name = $request->bank_name[$key];
                            $bank_info->branch_name = $request->branch_name[$key];
                            $bank_info->account_name = $request->account_name[$key];
                            $bank_info->account_number = $request->account_number[$key];
                            $bank_info->routing_number = $request->routing_number[$key];
                            $bank_info->swift_code = $request->swift_code[$key];
                            $bank_info->note = $request->note[$key];
                            $bank_info->updated_by = auth()->id();
                            $bank_info->updated_at = Carbon::now();
                            $bank_info->save();
                        }
                    }else{
                        // create
                        $bank_info = new UserBankInfo();
                        $bank_info->user_id = $user->id;
                        $bank_info->bank_name = $request->bank_name[$key];
                        $bank_info->branch_name = $request->branch_name[$key];
                        $bank_info->account_name = $request->account_name[$key];
                        $bank_info->account_number = $request->account_number[$key];
                        $bank_info->routing_number = $request->routing_number[$key];
                        $bank_info->swift_code = $request->swift_code[$key];
                        $bank_info->note = $request->note[$key];
                        $bank_info->created_by = auth()->id();
                        $bank_info->created_at = Carbon::now();
                        $bank_info->updated_by = auth()->id();
                        $bank_info->updated_at = Carbon::now();
                        $bank_info->save();
                    }
                }
            }

            // user education info update or create new or delete

            if (is_array($request->degree) && count($request->degree) > 0){
                // check if not exist then delete first
                $education_ids = $request->education_id??[];
                $user_edu_info = UserEducationInfo::where('user_id', $user->id)
                    ->whereNotIn('id', $education_ids)
                    ->delete();
                foreach ($request->degree as $key => $value){
                    if (!isset($request->degree[$key])){
                        continue;
                    }
                    if ($request->degree[$key] == '' || $request->degree[$key] == null){
                        continue;
                    }
                    if ($request->education_id[$key] != null){
                        // update
                        $edu_info = UserEducationInfo::where('id', $request->education_id[$key])
                            ->where('user_id', $user->id)
                            ->first();
                        if ($edu_info){
                            $edu_info->degree = $request->degree[$key];
                            $edu_info->institute_name = $request->institute_name[$key];
                            $edu_info->subject = $request->subject[$key];
                            $edu_info->grade = $request->grade[$key];
                            $edu_info->start_date = $request->start_date[$key];
                            $edu_info->end_date = $request->end_date[$key];
                            $edu_info->updated_by = auth()->id();
                            $edu_info->updated_at = Carbon::now();
                            $edu_info->save();
                        }
                    }else{
                        // create
                        $edu_info = new UserEducationInfo();
                        $edu_info->user_id = $user->id;
                        $edu_info->degree = $request->degree[$key];
                        $edu_info->institute_name = $request->institute_name[$key];
                        $edu_info->subject = $request->subject[$key];
                        $edu_info->grade = $request->grade[$key];
                        $edu_info->start_date = $request->start_date[$key];
                        $edu_info->end_date = $request->end_date[$key];
                        $edu_info->created_by = auth()->id();
                        $edu_info->created_at = Carbon::now();
                        $edu_info->updated_by = auth()->id();
                        $edu_info->updated_at = Carbon::now();
                        $edu_info->save();
                    }
                }
            }


        }catch (\Exception $exception) {
            DB::rollBack();
            throw new \Exception($exception->getMessage());
        }
        DB::commit();
    }

    public function getDetailsData($id)
    {
        $data['departments'] = Department::where('deleted', Department::DELETED_NO)
            ->orderBy('name', 'asc')
            ->get();
        $data['designations'] = Designation::where('deleted', Designation::DELETED_NO)
            ->orderBy('name', 'asc')
            ->get();
        $data['employee'] = User::with('designation', 'department', 'user_role', 'userEmergencyContacts', 'userBankInfo', 'userEducationInfo','userExperienceInfo')
            ->where('id', $id)
            ->where('deleted', User::DELETED_NO)
            ->first();
        if (!$data['employee']){
            throw new \Exception("Employee not found!");
        }

        return $data;
    }

    public function getDetailFilteredData($request, $id)
    {
        /*$data['departments'] = Department::where('deleted', Department::DELETED_NO)
            ->orderBy('name', 'asc')
            ->get();
        $data['designations'] = Designation::where('deleted', Designation::DELETED_NO)
            ->orderBy('name', 'asc')
            ->get();*/
        $data['employee'] = User::with('designation', 'department', 'userEmergencyContacts', 'userBankInfo', 'userEducationInfo')
            ->where('id', $id)
            ->where('deleted', User::DELETED_NO)
            ->first();
        if (!$data['employee']){
            throw new \Exception("Employee not found!");
        }

        return $data;
    }

    public function updateProfileInfo($request, $id)
    {
        DB::beginTransaction();
        try {
            $user = User::where('id', $id)
                ->where('deleted', User::DELETED_NO)
                ->first();
            if (!$user) {
                throw new \Exception("Employee not found!");
            }

            $check_email = User::where('email', $request->email)
                ->where('deleted', User::DELETED_NO)
                ->where('id', '!=', $id)
                ->first();
            if ($check_email) {
                throw new \Exception("Email already exists");
            }

            $check_phone = User::where('phone', $request->phone)
                ->where('deleted', User::DELETED_NO)
                ->where('id', '!=', $id)
                ->first();
            if ($check_phone) {
                throw new \Exception("Phone already exists");
            }

            $image_path = $user->image;
            if ($request->hasFile('image')) {
                $imageUploadService = new ImageUploadService();
                $image_path = $imageUploadService->update($request->image, 'employee/image', $user->image);
                $image_path = $image_path['path'];
            }

            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->email = $request->email;
            $user->phone = $request->phone ?? null;
            $user->joining_date = $request->joining_date;
            $user->designation_id = $request->designation_id;
            $user->department_id = $request->department_id;
            $user->image = $image_path ?? null;
            $user->updated_by = auth()->id();
            $user->updated_at = Carbon::now();
            $user->save();


        }catch (\Exception $exception) {
            DB::rollBack();
            throw new \Exception($exception->getMessage());
        }
        DB::commit();
    }

    public function updatePersonalInfo($request, $id)
    {
        try {

            $user = User::where('id', $id)
                ->where('deleted', User::DELETED_NO)
                ->first();
            if (!$user) {
                throw new \Exception("Employee not found!");
            }

            // nid image
            $nid_image_path = $user->nid_image;
            if ($request->hasFile('nid_image')) {
                $imageUploadService = new ImageUploadService();
                $nid_image_path = $imageUploadService->update($request->nid_image, 'employee/nid', $user->nid_image);
                $nid_image_path = $nid_image_path['path'];
            }

            // passport image
            $passport_image_path = $user->passport_image;
            if ($request->hasFile('passport_image')) {
                $imageUploadService = new ImageUploadService();
                $passport_image_path = $imageUploadService->update($request->passport_image, 'employee/passport', $user->passport_image);
                $passport_image_path = $passport_image_path['path'];
            }

            $user->nid_no = $request->nid_no ?? null;
            $user->nid_image = $nid_image_path ?? null;
            $user->passport_no = $request->passport_no ?? null;
            $user->passport_expiry_date = $request->passport_expiry_date ?? null;
            $user->passport_image = $passport_image_path ?? null;
            $user->date_of_birth = $request->date_of_birth ?? null;
            $user->gender = $request->gender ?? null;
            $user->religion = $request->religion ?? null;
            $user->marital_status = $request->marital_status ?? null;
            $user->marriage_date = $request->marriage_date ?? null;
            $user->present_address = $request->present_address ?? null;
            $user->permanent_address = $request->permanent_address ?? null;
            $user->updated_by = auth()->id();
            $user->updated_at = Carbon::now();
            $user->save();

        }catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }
    }

    public function updateBankInfo($request ,$id)
    {
        try {
            $user = User::where('id', $id)
                ->where('deleted', User::DELETED_NO)
                ->first();
            if (!$user) {
                throw new \Exception("Employee not found!");
            }

            // user bank info update or create new or delete

            if (is_array($request->bank_name) && count($request->bank_name) > 0) {
                // check if not exist then delete first
                $bank_ids = $request->bank_id??[];
                $user_bank_info = UserBankInfo::where('user_id', $user->id)
                    ->whereNotIn('id', $bank_ids)
                    ->delete();
                foreach ($request->bank_name as $key => $item) {
                    if (!isset($request->bank_name[$key])) {
                        continue;
                    }
                    if ($request->bank_name[$key] == '' || $request->bank_name[$key] == null) {

                        continue;
                    }
                    if (isset($request->bank_id[$key]) && $request->bank_id[$key] != null) {
                        // update
                        $bank_info = UserBankInfo::where('id', $request->bank_id[$key])
                            ->where('user_id', $user->id)
                            ->first();
                        if ($bank_info) {
                            $bank_info->bank_name = $request->bank_name[$key];
                            $bank_info->branch_name = $request->branch_name[$key];
                            $bank_info->account_name = $request->account_name[$key];
                            $bank_info->account_number = $request->account_number[$key];
                            $bank_info->routing_number = $request->routing_number[$key];
                            $bank_info->swift_code = $request->swift_code[$key];
                            $bank_info->note = $request->note[$key];
                            $bank_info->updated_by = auth()->id();
                            $bank_info->updated_at = Carbon::now();
                            $bank_info->save();
                        }
                    } else {
                        // create
                        $bank_info = new UserBankInfo();
                        $bank_info->user_id = $user->id;
                        $bank_info->bank_name = $request->bank_name[$key];
                        $bank_info->branch_name = $request->branch_name[$key];
                        $bank_info->account_name = $request->account_name[$key];
                        $bank_info->account_number = $request->account_number[$key];
                        $bank_info->routing_number = $request->routing_number[$key];
                        $bank_info->swift_code = $request->swift_code[$key];
                        $bank_info->note = $request->note[$key];
                        $bank_info->created_by = auth()->id();
                        $bank_info->created_at = Carbon::now();
                        $bank_info->updated_by = auth()->id();
                        $bank_info->updated_at = Carbon::now();
                        $bank_info->save();
                    }
                }
            }

        }catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());

        }

    }

    public function updateEducationInfo($request, $id)
    {
        try {
            $user = User::where('id', $id)
                ->where('deleted', User::DELETED_NO)
                ->first();
            if (!$user) {
                throw new \Exception("Employee not found!");
            }

            // user education info update or create new or delete

            if (is_array($request->degree) && count($request->degree) > 0) {
                // check if not exist then delete first
                $education_ids = $request->education_id??[];
                $user_edu_info = UserEducationInfo::where('user_id', $user->id)
                    ->whereNotIn('id', $education_ids)
                    ->delete();
                foreach ($request->degree as $key => $value) {
                    if (!isset($request->degree[$key])) {
                        continue;
                    }
                    if ($request->degree[$key] == '' || $request->degree[$key] == null) {
                        continue;
                    }
                    if (isset($request->education_id[$key]) && $request->education_id[$key] != null) {
                        // update
                        $edu_info = UserEducationInfo::where('id', $request->education_id[$key])
                            ->where('user_id', $user->id)
                            ->first();
                        if ($edu_info) {
                            $edu_info->degree = $request->degree[$key];
                            $edu_info->institute_name = $request->institute_name[$key];
                            $edu_info->subject = $request->subject[$key];
                            $edu_info->grade = $request->grade[$key];
                            $edu_info->start_date = $request->start_date[$key];
                            $edu_info->end_date = $request->end_date[$key];
                            $edu_info->updated_by = auth()->id();
                            $edu_info->updated_at = Carbon::now();
                            $edu_info->save();
                        }
                    } else {
                        // create
                        $edu_info = new UserEducationInfo();
                        $edu_info->user_id = $user->id;
                        $edu_info->degree = $request->degree[$key];
                        $edu_info->institute_name = $request->institute_name[$key];
                        $edu_info->subject = $request->subject[$key];
                        $edu_info->grade = $request->grade[$key];
                        $edu_info->start_date = $request->start_date[$key];
                        $edu_info->end_date = $request->end_date[$key];
                        $edu_info->created_by = auth()->id();
                        $edu_info->created_at = Carbon::now();
                        $edu_info->updated_by = auth()->id();
                        $edu_info->updated_at = Carbon::now();
                        $edu_info->save();

                    }
                }

            }
        }catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }

    }

    public function updateExperienceInfo($request, $id)
    {
        try {
            $user = User::where('id', $id)
                ->where('deleted', User::DELETED_NO)
                ->first();
            if (!$user) {
                throw new \Exception("Employee not found!");
            }

            // user experience info update or create new or delete

            if (is_array($request->company_name) && count($request->company_name) > 0) {
                // check if not exist then delete first
                $experience_ids = $request->experience_id??[];
                $user_exp_info = UserExperienceInfo::where('user_id', $user->id)
                    ->whereNotIn('id', $experience_ids)
                    ->delete();
                foreach ($request->company_name as $key => $value) {
                    if (!isset($request->company_name[$key])) {
                        continue;
                    }
                    if ($request->company_name[$key] == '' || $request->company_name[$key] == null) {
                        continue;
                    }
                    if (isset($request->experience_id[$key]) && $request->experience_id[$key] != null) {
                        // update
                        $exp_info = UserExperienceInfo::where('id', $request->experience_id[$key])
                            ->where('user_id', $user->id)
                            ->first();
                        if ($exp_info) {
                            $exp_info->company_name = $request->company_name[$key];
                            $exp_info->designation = $request->designation[$key];
                            $exp_info->start_date = $request->start_date[$key];
                            $exp_info->end_date = $request->end_date[$key];
                            $exp_info->updated_by = auth()->id();
                            $exp_info->updated_at = Carbon::now();
                            $exp_info->save();
                        }
                    } else {
                        // create
                        $exp_info = new UserExperienceInfo();
                        $exp_info->user_id = $user->id;
                        $exp_info->company_name = $request->company_name[$key];
                        $exp_info->designation = $request->designation[$key];
                        $exp_info->start_date = $request->start_date[$key];
                        $exp_info->end_date = $request->end_date[$key];
                        $exp_info->created_by = auth()->id();
                        $exp_info->created_at = Carbon::now();
                        $exp_info->updated_by = auth()->id();
                        $exp_info->save();

                    }
                }
            }
        }catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }
    }

    public function updateEmergencyContactInfo($request, $id)
    {
        try {
            $user = User::where('id', $id)
                ->where('deleted', User::DELETED_NO)
                ->first();
            if (!$user) {
                throw new \Exception("Employee not found!");
            }

            // user emergency contact update or create new or delete

            if (is_array($request->contact_name) && count($request->contact_name) > 0) {
                // check if not exist then delete first
                $contact_ids = $request->contact_id??[];
                $user_contact = UserEmergencyContact::where('user_id', $user->id)
                    ->whereNotIn('id', $contact_ids)
                    ->delete();
                foreach ($request->contact_name as $key => $value) {
                    if (!isset($request->contact_name[$key])) {
                        continue;
                    }
                    if ($request->contact_name[$key] == '' || $request->contact_name[$key] == null) {
                        continue;
                    }
                    if (isset($request->contact_id[$key]) && $request->contact_id[$key] != null) {
                        // update
                        $contact = UserEmergencyContact::where('id', $request->contact_id[$key])
                            ->where('user_id', $user->id)
                            ->first();
                        if ($contact) {
                            $contact->name = $request->contact_name[$key];
                            $contact->phone = $request->contact_phone[$key];
                            $contact->email = $request->contact_email[$key];
                            $contact->relation = $request->contact_relation[$key];
                            $contact->save();
                        }
                    } else {
                        // create
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
            }
        }catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }
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

    public function changeRoleData($id){
        $data['item'] = User::where('id', $id)
            ->where('deleted', User::DELETED_NO)
            ->first();
        
        $data['roles'] = Role::where('deleted', Role::DELETED_NO)
            ->where('status', Role::STATUS_ACTIVE)
            ->orderBy('title', 'asc')
            ->get();

        return $data;
    }

    public function updateRole($request, $id){
        $user = User::where('id', $id)
            ->where('deleted', User::DELETED_NO)
            ->first();

        if (!$user) {
            throw new \Exception('User not found');
        }

        $user->role_id = $request->role_id;
        $user->updated_by = auth()->user()->id;
        $user->updated_at = now();
        $user->save();
    }
}
