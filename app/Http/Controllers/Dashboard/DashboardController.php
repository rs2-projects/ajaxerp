<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\BaseControllers\BackendController;
use Illuminate\Http\Request;

class DashboardController extends BackendController
{
    public function __construct()
    {
        $this->addBreadcrumbs('Dashboard', route('dashboard'), 'fa fa-home');
    }

    public function showDashboard()
    {
        $this->setPageTitle("Dashboard");
        $this->setPageHeaderTitle("Dashboard");
        $this->addBreadcrumbs('Home');

        return $this->view('pages.index');
    }
}
