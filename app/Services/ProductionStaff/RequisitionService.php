<?php

namespace App\Services\ProductionStaff;


class RequisitionService
{
    private $paginate_limit;
    public function __construct()
    {
        $this->paginate_limit = config('commonData.paginate_limit');
    }

}
