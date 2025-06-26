<?php

namespace App\Services\Report\StockReport;

use App\Models\Products\ProductMaterial;

class ProductMaterialStockReportService
{
    private $paginate_limit;

    public function __construct()
    {
        $this->paginate_limit = config('commonData.paginate_limit');
    }

    public function indexFilteredData($request)
    {

        $keyword_filtered = $request->keyword_filtered;
        $stock_status = $request->stock_filter ?? '';

        $data['product_materials'] = ProductMaterial::where('deleted', ProductMaterial::DELETED_NO)
            ->where(function ($q) use ($keyword_filtered){
                if ($keyword_filtered !=''){
                    $q->where('name', 'like', '%'.$keyword_filtered.'%');
                    $q->orWhere('code', 'like', '%'.$keyword_filtered.'%');
                }
            })
            ->where(function ($q) use ($stock_status){
                if(($stock_status != '') && ($stock_status != 'all')) {
                    if($stock_status == 'stock_warning'){
                        $q->whereRaw('low_stock_warning >= available_qty')
                            ->whereRaw('low_stock_at_least < available_qty');
                    }else if($stock_status == 'stock_alert'){
                        $q->whereRaw('low_stock_at_least >= available_qty');
                    }
                }
            })
            ->orderBy('name', 'asc')
            ->paginate($this->paginate_limit);

        return $data;
    }

}
