<?php

namespace App\Services\Payroll;

use App\Models\Salary;
use App\Models\SalaryBonusTypes;
use App\Models\SalarySettingsSalarySets;
use App\Models\SettingsBonusType;
use App\Models\SettingsSalaryDeductionType;
use App\Services\Payroll\Traits\GenerateSalaryTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class GenerateSalaryService
{
    use GenerateSalaryTrait;

    public function __construct()
    {
        $this->paginate_limit = config('commonData.paginate_limit');
    }

    public function getIndexData($request)
    {
        $data['months'] = config('commonData.month_names');

        $data['bonus_types'] = SettingsBonusType::where('status', SettingsBonusType::STATUS_ACTIVE)
            ->where('deleted', SettingsBonusType::DELETED_NO)
            ->get();

        $data['deduction_types'] = SettingsSalaryDeductionType::where('status', SettingsSalaryDeductionType::STATUS_ACTIVE)
            ->where('deleted', SettingsSalaryDeductionType::DELETED_NO)
            ->get();

        return $data;
    }

    /**
     * @throws \Exception
     */
    public function generateSalary($request)
    {

        DB::beginTransaction();
        try {

            $salary = new Salary();
            $salary->salary_year = $request->year;
            $salary->salary_month = $request->month;

            $salary_date = $request->year. '-' . $request->month . '-01';

            $salary->salary_date = $salary_date;
            $salary->salary_generate_type = $request->salary_type;

            if($request->salary_type == Salary::SALARY_GENERATE_TYPE_FULL_MONTH) {
                $salary->salary_period = Salary::SALARY_PERIOD_FULL_MONTH;
                $salary_start_date = Carbon::parse($salary_date)->subMonth()->format('Y-m-26');
                $salary_end_date = Carbon::parse($salary_date)->endOfMonth()->format('Y-m-25');
            } else {
                $salary->salary_period = $request->period_type;

                if($request->period_type == Salary::SALARY_PERIOD_FIRST_HALF) {
                    $salary_start_date = Carbon::parse($salary_date)->subMonth();
                    $salary_start_date = $salary_start_date->format('Y-m-26');
                    $salary_end_date = Carbon::parse($salary_date)->startOfMonth();
                    $salary_end_date = $salary_end_date->format('Y-m-10');
                } else {
                    $salary_start_date = Carbon::parse($salary_date)->startOfMonth();
                    $salary_start_date = $salary_start_date->format('Y-m-11');
                    $salary_end_date = Carbon::parse($salary_date)->startOfMonth();
                    $salary_end_date = $salary_end_date->format('Y-m-25');
                }
            }
            dump($salary_start_date);
            dd($salary_end_date);

            if(isset($request->deduction_type) && ($request->deduction_type != '')) {
                $salary->settings_salary_deduction_type_id = $request->deduction_type;
            } else {
                $salary->settings_salary_deduction_type_id = null;
            }

            $salary->generated_by = auth()->id();
            $salary->generated_at = Carbon::now();
            $salary->generation_status = Salary::GENERATION_STATUS_RUNNING;
            $salary->start_date = $salary_start_date;
            $salary->end_date = $salary_end_date;
            $salary->no_of_days = Carbon::parse($salary_end_date)->diffInDays(Carbon::parse($salary_start_date));
            $salary->view_status = Salary::VIEW_STATUS_NOT_VIEWED;
            $salary->status = Salary::STATUS_ACTIVE;
            $salary->deleted = Salary::DELETED_NO;
            $salary->created_at = Carbon::now();
            $salary->created_by = auth()->id();
            $salary->updated_at = Carbon::now();
            $salary->updated_by = auth()->id();
            $salary->save();

            $salary_bonuses = [];
            if (isset($request->bonus_types) && is_array($request->bonus_types) && (count($request->bonus_types) > 0)) {
                foreach ($request->bonus_types as $bonus_type) {
                    $salary_bonus_types = new SalaryBonusTypes();
                    $salary_bonus_types->salary_id = $salary->id;
                    $salary_bonus_types->settings_bonus_type_id = $bonus_type;
                    $salary_bonus_types->total_bonus_amount = 0;
                    $salary_bonus_types->status = SalaryBonusTypes::STATUS_ACTIVE;
                    $salary_bonus_types->deleted = SalaryBonusTypes::DELETED_NO;
                    $salary_bonus_types->created_at = Carbon::now();
                    $salary_bonus_types->created_by = auth()->id();
                    $salary_bonus_types->updated_at = Carbon::now();
                    $salary_bonus_types->updated_by = auth()->id();
                    $salary_bonus_types->save();

                    $salary_bonuses[$bonus_type] = $salary_bonus_types;
                }
            }

            $total_salary_amount = 0;
            $total_bonus_amount = 0;
            $total_deduction_amount = 0;
            $total_amount_to_pay = 0;


            //loop through all salary set
            if (isset($request->salary_set) && is_array($request->salary_set) && (count($request->salary_set) > 0)) {
                foreach ($request->salary_set as $salary_set) {
                    $salary_ids = Salary::where('salary_year', $request->year)
                        ->where('salary_month', $request->month)
                        ->where('salary_generate_type', $request->salary_type)
                        ->where('salary_period', $request->period_type)
                        ->pluck('id')
                        ->toArray();

                    $generated_salary_set = SalarySettingsSalarySets::whereIn('salary_id', $salary_ids)
                        ->where('settings_salary_set_id', $salary_set)
                        ->first();

                    if (!empty($generated_salary_set)) {
                        continue;
                    }

                    $salarySettingsSalarySet = $this->generateSalarySetSalary($salary_set, $salary, $salary_bonuses);

                    $total_salary_amount += $salarySettingsSalarySet->total_salary_amount;
                    $total_bonus_amount += $salarySettingsSalarySet->total_bonus_amount;
                    $total_deduction_amount += $salarySettingsSalarySet->total_deduction_amount;
                    $total_amount_to_pay += $salarySettingsSalarySet->total_amount_to_pay;
                }
            }

            $salary->total_salary_amount = $total_salary_amount;
            $salary->total_bonus_amount = $total_bonus_amount;
            $salary->total_deduction_amount = $total_deduction_amount;
            $salary->total_amount_to_pay = $total_amount_to_pay;
            $salary->generation_status = Salary::GENERATION_STATUS_SUCCESS;
            $salary->save();

        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }

        DB::commit();
        return $salary;

    }
}
