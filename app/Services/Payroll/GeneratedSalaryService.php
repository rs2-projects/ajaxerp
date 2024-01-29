<?php

namespace App\Services\Payroll;

use App\Models\Salary;
use App\Models\SalaryDetails;
use App\Models\SalarySettingsSalarySets;
use Illuminate\Support\Facades\DB;

class GeneratedSalaryService
{
    public function __construct()
    {
        $this->paginate_limit = config('commonData.paginate_limit');
    }

    public function getIndexFilteredData($request)
    {
        $data['salaries'] = Salary::where('deleted', Salary::DELETED_NO)
            ->paginate($this->paginate_limit);

        return $data;
    }

    public function getDetailsData($id)
    {
        $data['salary'] = Salary::where('id', $id)
            ->where('deleted', Salary::DELETED_NO)
            ->first();

        return $data;
    }

    public function getDetailsFilteredData($request, $id)
    {
        $data['salary'] = Salary::where('id', $id)
            ->where('deleted', Salary::DELETED_NO)
            ->first();

        $data['salaryDetails'] = SalaryDetails::with('employee')
            ->where('salary_id', $id)
            ->where('deleted', SalaryDetails::DELETED_NO)
            ->paginate($this->paginate_limit);

        return $data;
    }

    public function getSalaryDetailsEditData($id)
    {
        try {
            $salaryDetails = SalaryDetails::with('employee','salaryDetailsAdditions', 'salaryDetailsDeductions')
                ->where('id', $id)
                ->where('deleted', SalaryDetails::DELETED_NO)
                ->first();
            if (!$salaryDetails) {
                throw new \Exception("Data not found");
            }
            $data['salaryDetails'] = $salaryDetails;

            return $data;
        }catch (\Exception $e){
            throw $e;
        }
    }

    public function salaryDetailsUpdate($request,$id)
    {
        DB::beginTransaction();
        try{
            $salaryDetails = SalaryDetails::where('id', $id)
                ->where('deleted', SalaryDetails::DELETED_NO)
                ->first();
            if (!$salaryDetails) {
                throw new \Exception("Data not found");
            }

            $salary = Salary::where('id', $salaryDetails->salary_id)
                ->where('deleted', Salary::DELETED_NO)
                ->first();
            if (!$salary) {
                throw new \Exception("Data not found");
            }

            $salarySettingsSalarySets = SalarySettingsSalarySets::where('salary_id', $salary->id)
                ->where('deleted', SalarySettingsSalarySets::DELETED_NO)
                ->first();
            if (!$salarySettingsSalarySets) {
                throw new \Exception("Data not found");
            }

            $currentNetPayableSalary = $salaryDetails->net_payable_salary;
            $currentCustomAddAmount = $salaryDetails->custom_add_amount;
            $currentCustomDeductAmount = $salaryDetails->custom_deduct_amount;

            $newNetPayableSalary = ($currentNetPayableSalary - $currentCustomAddAmount) + $request->custom_add_amount;
            $newNetPayableSalary = ($newNetPayableSalary + $currentCustomDeductAmount) - $request->custom_deduct_amount;

            $salaryDetails->custom_add_amount_text = $request->custom_add_amount_text??null;
            $salaryDetails->custom_add_amount = $request->custom_add_amount??null;
            $salaryDetails->custom_deduct_amount_text = $request->custom_deduct_amount_text??null;
            $salaryDetails->custom_deduct_amount = $request->custom_deduct_amount??null;
            $salaryDetails->net_payable_salary = 0;
            $salaryDetails->save();

            $salaryCurrentTotalAmountToPay = $salary->total_amount_to_pay;
            $salaryCurrentTotalBonusAmount = $salary->total_bonus_amount;
            $salaryCurrentTotalDeductionAmount = $salary->total_deduction_amount;

            /*$salaryNewTotalAmountToPay = ($salaryCurrentTotalAmountToPay - $salaryCurrentTotalBonusAmount) + $request->custom_add_amount;
            $salaryNewTotalAmountToPay =*/


        }catch (\Exception $e){
            DB::rollBack();
            throw $e;
        }
        DB::commit();
    }

    public function getSalaryDetailsShowData($id)
    {
        try {
            $salaryDetails = SalaryDetails::with('employee','salaryDetailsAdditions', 'salaryDetailsDeductions')
                ->where('id', $id)
                ->where('deleted', SalaryDetails::DELETED_NO)
                ->first();
            if (!$salaryDetails) {
                throw new \Exception("Data not found");
            }
            $data['salaryDetails'] = $salaryDetails;

            return $data;
        }catch (\Exception $e){
            throw $e;
        }
    }

}
