<?php

namespace App\Services\Inventory;

class ProductMaterialService
{
    public function __construct()
    {
        $this->paginate_limit = config('commonData.paginate_limit');
    }

    public function indexFilteredData($request)
    {
        $data['product_materials'] =[];

        return $data;
    }
}
