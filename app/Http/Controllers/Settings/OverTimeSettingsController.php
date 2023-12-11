<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\BaseControllers\BackendController;
use Illuminate\Http\Request;

class OverTimeSettingsController extends BackendController
{

    public function __construct()
    {
        $this->addBreadcrumbs('Settings', route('settings.office-time'), 'fa fa-cog');
        $this->addBreadcrumbs('Over Time');
    }
    public function showOverTimeSettings()
    {
        $this->setPageTitle("Over Time");
        $this->setActiveMenu('settings.over-time');

        return $this->view('settings.over-time.index');
    }
}
