<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\BaseControllers\BackendController;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanySettingsController extends BackendController
{
    public function __construct()
    {
        $this->addBreadcrumbs('Settings', route('settings.company'), 'fa fa-cog');
        $this->addBreadcrumbs('Company');
    }

    public function edit()
    {
        $this->setPageTitle('Company');
        $this->setActiveMenu('settings.company');

        $company = Company::query()->where('deleted', 0)->first();

        return $this->view('settings.company.edit')->with([
            'company' => $company,
        ]);
    }

    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'company_name' => ['required', 'string', 'max:191'],
            'email' => ['required', 'email', 'max:191'],
            'phone' => ['required', 'string', 'max:60'],
            'address' => ['required', 'string', 'max:255'],
        ]);

        $company = Company::query()->first();

        if ($company) {
            $company->update(array_merge($validatedData, [
                'updated_at' => now(),
            ]));
        } else {
            $company = Company::query()->create(array_merge($validatedData, [
                'status' => 1,
                'deleted' => 0,
                'created_at' => now(),
                'updated_at' => now(),
                'synced' => false,
            ]));
        }

        return $this->returnAjaxSuccess([
            'company_id' => $company->id,
        ], 'Company updated successfully');
    }
}

