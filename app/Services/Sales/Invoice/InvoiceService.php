<?php

namespace App\Services\Sales\Invoice;

class InvoiceService
{
    public function __construct()
    {
        $this->paginate_limit = config('commonData.paginate_limit');
    }

    // index data
    public function indexData()
    {
        $data['months'] = config('commonData.month_names');
        return $data;
    }
}
