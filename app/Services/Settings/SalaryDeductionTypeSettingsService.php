<?php

namespace App\Services\Settings;

use App\Models\SettingsSalaryDeductionType;
use Illuminate\Support\Facades\Request;

class SalaryDeductionTypeSettingsService
{
    public function __construct()
    {
        $this->paginate_limit = config('commonData.paginate_limit');
    }

    public function getIndexFilteredData($request)
    {
        $data['salaryDeductionTypes'] = SettingsSalaryDeductionType::where('deleted', SettingsSalaryDeductionType::DELETED_NO)
            ->orderBy('id', 'desc')
            ->paginate($this->paginate_limit);

        return $data;
    }

}
