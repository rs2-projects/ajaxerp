<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\BaseControllers\BackendController;
use Illuminate\Http\Request;

class DashboardController extends BackendController
{
    public function __construct()
    {
        $this->addBreadcrumbs('HR', route('dashboard'), 'fa fa-home');
        $this->addBreadcrumbs('Employee', route('dashboard'));
    }

    public function showDashboard()
    {
        $this->setPageTitle("Dashboard");
        $this->setPageHeaderTitle("Dashboard");
        $this->addBreadcrumbs('Details');
        $this->setActiveMenu('dashboard');

        return $this->view('pages.index');
    }
}
