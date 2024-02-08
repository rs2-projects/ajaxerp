<?php

namespace App\Http\Controllers\Procurement\ProductMaterial;

use App\Http\Controllers\BaseControllers\BackendController;
use App\Http\Controllers\Controller;
use App\Services\Procurement\ProductMaterial\PurchaseInvestigationService;
use Illuminate\Http\Request;

class PurchaseInvestigationController extends BackendController
{
    private PurchaseInvestigationService $service;

    public function __construct()
    {
        $this->addBreadcrumbs('Procurement', route('dashboard'), 'fa fa-home');
        $this->addBreadcrumbs('Material Purchase Investigation');

        $this->service = new PurchaseInvestigationService();
    }
}
