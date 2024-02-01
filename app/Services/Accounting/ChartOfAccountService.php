<?php

namespace App\Services\Accounting;

class ChartOfAccountService
{
    public function __construct(){
        $this->paginate_limit = config('commonData.paginate_limit');
    }

    public function indexFilteredData($request)
    {
        $data['test'] = 'test';

        return $data;
    }
}
