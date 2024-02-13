<?php

namespace App\Services\Procurement\Assets\PurchaseOrder;

use App\Models\Procurements\Supplier;
use App\Models\Products\AssetProduct;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PurchaseOrderService
{
    public function __construct()
    {
        $this->paginate_limit = config('commonData.paginate_limit');
    }

    public function createData()
    {
        $data['purchaseDate'] = Carbon::now();
        $data['estimatedDeliveryDate'] = Carbon::now();

        return $data;

    }

    public function getAllAssetProducts($request)
    {
        if(isset($request->q) && ($request->q != '') && ($request->q != null)) {
            $search_keyword = $request->q;
        } else {
            $search_keyword = null;
        }
        $data['asset_products'] = AssetProduct::where('deleted', AssetProduct::DELETED_NO)
            ->when($search_keyword, function ($q) use($search_keyword){
                return $q->where('name', 'LIKE', '%'.$search_keyword.'%');
            })
            ->where('status', AssetProduct::STATUS_ACTIVE)
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'name' => $item->name,
                    'show_image' => asset($item->show_image),
                    'description' => $item->description
                ];
            });
        return $data;

    }

    public function getAllTaxes($request)
    {
        $coaSubCat = AccCoaSubCategory::where('is_sales_tax', AccCoaSubCategory::IS_SALES_TAX_YES)
            ->where('status', AccCoaSubCategory::STATUS_ACTIVE)
            ->where('deleted', AccCoaSubCategory::DELETED_NO)
            ->first();
        if (!empty($coaSubCat)) {
            $data['vat_taxes'] = AccCoaAccount::where('acc_coa_sub_category_id', $coaSubCat->id)

                ->where('status', AccCoaAccount::STATUS_ACTIVE)
                ->where('deleted',AccCoaAccount::DELETED_NO)
                ->get();
        } else {
            $data['vat_taxes'] = [];
        }


        return $data;
    }

    public function getAllSuppliers($request)
    {
        if(isset($request->q) && ($request->q != '') && ($request->q != null)) {
            $search_keyword = $request->q;
        } else {
            $search_keyword = null;
        }

        $data['suppliers'] = Supplier::where('status', Supplier::STATUS_ACTIVE)
            ->where('deleted', Supplier::DELETED_NO)
            ->when($search_keyword, function ($q) use($search_keyword){
                $q->where(function ($j) use ($search_keyword) {
                        $j->where('business_name', 'LIKE', '%'.$search_keyword.'%')
                        ->orWhere('phone', 'LIKE', '%'.$search_keyword.'%');
                });
            })
            ->get()
            ->map(function ($supplier) {
                return [
                    'id' => $supplier->id,
                    'business_name' => $supplier->business_name,
                    'phone' => $supplier->phone,
                    'email' => $supplier->email,
                    'show_image_full_url' => asset($supplier->show_image),
                    'contact_full_name' => $supplier->full_name,
                    'address' => $supplier->address,
                ];
            });

        return $data;
    }
}
