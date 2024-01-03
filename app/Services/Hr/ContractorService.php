<?php

namespace App\Services\Hr;

use App\Models\Contractor;

class ContractorService
{
    public function __construct()
    {
        $this->paginate_limit = config('commonData.paginate_limit');
    }

    public function getIndexFilteredData($request)
    {
        $data['userContractors'] = Contractor::with('emergencyContacts')
            ->where('deleted', Contractor::DELETED_NO)
            ->orderBy('id', 'desc')
            ->paginate($this->paginate_limit);

        return $data;
    }


}
