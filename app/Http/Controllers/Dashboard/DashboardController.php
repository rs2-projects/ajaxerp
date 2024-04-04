<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\BaseControllers\BackendController;
use App\Services\Dashboard\DashboardService;
use Illuminate\Http\Request;

class DashboardController extends BackendController
{
    public function __construct()
    {
        $this->addBreadcrumbs('Home', route('dashboard'), 'fa fa-home');
    }

    public function showDashboard(DashboardService $dashboardService)
    {
        $this->setPageTitle("Dashboard");
        $this->setPageHeaderTitle("Dashboard");
        $this->setActiveMenu('dashboard');
        $data = $dashboardService->getDashboardData();
        return $this->view('pages.index')->with($data);
    }
}
