<?php

namespace App\Services\Payroll;

use App\Models\SettingsBonusType;
use App\Models\SettingsSalaryDeductionType;

class GenerateSalaryService
{
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

    public function generateSalary($request)
    {

    }
}
