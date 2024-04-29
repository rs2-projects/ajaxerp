<?php

namespace App\Http\Controllers\ProductionStaff;

use App\Http\Controllers\BaseControllers\BackendController;
use App\Services\ProductionStaff\DashboardService;

class DashboardController extends BackendController
{
    public function __construct()
    {
        $this->addBreadcrumbs('Home', route('production-staff.dashboard'), 'fa fa-home');
    }

    public function showDashboard(DashboardService $dashboardService)
    {
        $this->setPageTitle("Dashboard");
        $this->setPageHeaderTitle("Dashboard");
        $this->setActiveMenu('dashboard');
        $data = $dashboardService->getDashboardData();
        return $this->view('production-staff.pages.index')->with($data);
    }
}
