<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\BaseControllers\BackendController;

class OfficeTimeSettingsController extends BackendController
{
    public function __construct()
    {
        $this->addBreadcrumbs('Settings', route('settings.office-time'), 'fa fa-cog');
        $this->addBreadcrumbs('Office Time');
    }
    public function showOfficeTimeSettings()
    {
        $this->setPageTitle("Office Time");
        $this->setActiveMenu('settings.office-time');

        return $this->view('settings.office-time.index');
    }
}
