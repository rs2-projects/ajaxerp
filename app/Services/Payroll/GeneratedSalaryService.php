<?php

namespace App\Services\Payroll;

use App\Models\Salary;
use App\Models\SalaryDetails;
use App\Models\SalarySettingsSalarySets;

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
}
