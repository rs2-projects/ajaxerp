<?php

namespace App\Services\Inventory;

use App\Imports\Inventory\BoardProductsImport;
use App\Imports\Inventory\OtherProductsImport;
use App\Imports\Inventory\PaperProductsImport;
use App\Models\Accounting\AccCoaAccount;
use App\Models\Accounting\AccCoaSubCategory;
use App\Models\Inventory\CutOutBoard;
use App\Models\Inventory\CutOutBoardInventory;
use App\Models\Inventory\Warehouse;
use App\Models\Inventory\WarehouseSection;
use App\Models\Inventory\WarehouseSectionRack;
use App\Models\Procurements\ProductMaterialPurchase;
use App\Models\Procurements\ProductMaterialPurchaseCalculatedPrice;
use App\Models\Procurements\ProductMaterialPurchaseDetails;
use App\Models\Products\ProductMaterial;
use App\Models\Products\ProductMaterialCategory;
use App\Models\Products\ProductMaterialRack;
use App\Models\Products\ProductMaterialSection;
use App\Services\Common\ImageUploadService;
use App\Traits\LatestCalculatedPurchaseCostTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ReuseItemService
{
    private $paginate_limit;

    public function __construct()
    {
        $this->paginate_limit = config('commonData.paginate_limit');
    }

    public function indexData()
    {
        $data = [];
        return $data;
    }

    public function indexFilteredData($request)
    {
        $keyword_filtered = $request->keyword_filtered;
       
        $data['items'] = CutOutBoard::where('deleted', ProductMaterial::DELETED_NO)
            ->where('status', ProductMaterial::STATUS_ACTIVE)
            ->where(function ($q) use ($keyword_filtered){
                if ($keyword_filtered !=''){
                    $q->where('name', 'like', '%'.$keyword_filtered.'%');
                }
            })
            ->paginate($this->paginate_limit);

        return $data;
    }

    public function reuseItemDetailsData($id)
    {
        $data['item'] = CutOutBoard::find($id);
        $data['itemDetails'] = CutOutBoardInventory::where('cut_out_board_id', $id)->get();
        return $data;
    }
}
