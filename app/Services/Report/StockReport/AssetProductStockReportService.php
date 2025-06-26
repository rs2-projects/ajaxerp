<?php

namespace App\Services\Report\StockReport;

use App\Models\Products\AssetProduct;

class AssetProductStockReportService
{
    private $paginate_limit;

    public function __construct()
    {
        $this->paginate_limit = config('commonData.paginate_limit');
    }

    public function indexFilteredData($request)
    {

        $keyword_filtered = $request->keyword_filtered;

        $data['assets'] = AssetProduct::where('deleted', AssetProduct::DELETED_NO)
            ->where(function ($q) use ($keyword_filtered){
                if ($keyword_filtered !=''){
                    $q->where('name', 'like', '%'.$keyword_filtered.'%');
                }
            })
            ->orderBy('name', 'asc')
            ->paginate($this->paginate_limit);

        return $data;
    }
}
