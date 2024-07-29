<?php

namespace App\Services\Hr;

use App\Helpers\AttendanceHistoryHelper;
use App\Helpers\SalarySetHelper;
use App\Helpers\LeaveHelper;
use App\Models\Contractor;
use App\Models\Department;
use App\Models\Designation;
use App\Models\Permission\Role;
use App\Models\SettingsLeaveType;
use App\Models\User;
use App\Models\UserBankInfo;
use App\Models\UserEducationInfo;
use App\Models\UserEmergencyContact;
use App\Models\UserExperienceInfo;
use App\Models\UserLeave;
use App\Models\UserLeaveDetail;
use App\Models\UserLifecycle;
use App\Services\Common\ImageUploadService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployeePromotionService
{
    public $paginate_limit;
    public function __construct()
    {
        $this->paginate_limit = config('commonData.paginate_limit');
    }

    public function promotionModalData($id){
        $data['employee'] = User::where('id', $id)->first();
        if(empty($data['employee'])) {
            throw new \Exception("Invalid Employee!");
        }
        $data['departments'] = Department::where('deleted', Department::DELETED_NO)
            ->orderBy('name', 'asc')
            ->get();
        $data['designations'] = Designation::where('deleted', Designation::DELETED_NO)
            ->orderBy('name', 'asc')
            ->get();

        //calculate and get employee current salary
        try {
            $salary_set_employee = SalarySetHelper::getEmployeeCurrentSalary($id);
            $data['basic_salary'] = $salary_set_employee->basic_salary;
        } catch(\Exception $exception) {
            $data['basic_salary'] = 0;
        }

        return $data;
    }

    public function storePromotion(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $user = User::where('id', $id)->first();
            if(empty($user)) {
                throw new \Exception("Invalid Employee!");
            }
            
            $currentDate = Carbon::now();

            $user->designation_id = $request->designation_id;
            $user->department_id = $request->department_id;
            $user->updated_by = auth()->id();
            $user->updated_at = $currentDate;
            $user->save();

            $basic_salary = $request->basic_salary;
            $salary_set_employee = SalarySetHelper::getEmployeeCurrentSalary($id);
            $salary_set_employee->basic_salary = $basic_salary;
            $salary_set_employee->save();
        

            $userLifecycleService = new UserLifecycleService();
            $userLifecycleService->storePromotion($user, $basic_salary, $currentDate->format('Y-m-d'));

        }catch (\Exception $exception) {
            DB::rollBack();
            throw new \Exception($exception->getMessage());
        }
        DB::commit();
    }

    public function demotionModalData($id){
        $data['employee'] = User::where('id', $id)->first();
        if(empty($data['employee'])) {
            throw new \Exception("Invalid Employee!");
        }
        $data['departments'] = Department::where('deleted', Department::DELETED_NO)
            ->orderBy('name', 'asc')
            ->get();
        $data['designations'] = Designation::where('deleted', Designation::DELETED_NO)
            ->orderBy('name', 'asc')
            ->get();

        //calculate and get employee current salary
        try {
            $salary_set_employee = SalarySetHelper::getEmployeeCurrentSalary($id);
            $data['basic_salary'] = $salary_set_employee->basic_salary;
        } catch(\Exception $exception) {
            $data['basic_salary'] = 0;
        }

        return $data;
    }

    public function storeDemotion(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $user = User::where('id', $id)->first();
            if(empty($user)) {
                throw new \Exception("Invalid Employee!");
            }
            
            $currentDate = Carbon::now();

            $user->designation_id = $request->designation_id;
            $user->department_id = $request->department_id;
            $user->updated_by = auth()->id();
            $user->updated_at = $currentDate;
            $user->save();

            $basic_salary = $request->basic_salary;
            $salary_set_employee = SalarySetHelper::getEmployeeCurrentSalary($id);
            $salary_set_employee->basic_salary = $basic_salary;
            $salary_set_employee->save();
        

            $userLifecycleService = new UserLifecycleService();
            $userLifecycleService->storeDemotion($user, $basic_salary, $currentDate->format('Y-m-d'));

        }catch (\Exception $exception) {
            DB::rollBack();
            throw new \Exception($exception->getMessage());
        }
        DB::commit();
    }
}
