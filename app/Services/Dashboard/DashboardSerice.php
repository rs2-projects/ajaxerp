<?php

namespace App\Services\Dashboard;

use App\Helpers\DashboardDataHelper;

class DashboardSerice
{
    public function getDashboardData()
    {
        $dashboard_data = new DashboardDataHelper();

        $data = [
            'total_department_count' => $dashboard_data->getTotalDepartmentCount(),
            'total_employee_count' => $dashboard_data->getTotalEmployeeCount(),
            'new_employee_count' => $dashboard_data->getNewEmployeeCount(30),
            'remaining_holiday_count' => $dashboard_data->getRemainingHolidayCount(),
        ];

        return $data;
    }

}
