<?php

namespace App\Services\Dashboard;

use App\Traits\DashboardDataTrait;

class DashboardService
{
    use DashboardDataTrait;
    public function getDashboardData()
    {
        $data = [
            'invoice' => $this->totalInvoiceData(),
            'procurement' => $this->totalProcurementData(),
            'production' => $this->totalProductionData(),
            'accounts' => $this->cashAndBanks(),
            'recentOrders' => $this->recentOrders()
        ];

        return $data;
    }

}
