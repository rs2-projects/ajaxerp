<?php

namespace App\Services\Procurement\Assets;

use App\Models\Procurements\AssetProductPurchaseRequest;
use App\Models\Procurements\AssetProductPurchaseRequestDetails;
use App\Models\Products\AssetProduct;
use App\Models\Products\AssetProductCategory;
use App\Services\Common\ImageUploadService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class UserPurchaseRequestService
{
    public function __construct()
    {
        $this->paginate_limit = config('commonData.paginate_limit');
    }

    public function getAssetProducts($request)
    {
        $category_id = $request->category_id;
        $data['products'] = AssetProduct::where('asset_product_category_id', $category_id)
            ->orderBy('name', 'asc')
            ->get();

        return $data;
    }

    public function createData(){
        $data['asset_categories'] = AssetProductCategory::where('deleted', AssetProductCategory::DELETED_NO)
            ->where('status', AssetProductCategory::STATUS_ACTIVE)
            ->orderBy('name', 'asc')->get();
        return $data;
    }

    public function store($request)
    {
        DB::beginTransaction();
        try {
            $purchase_request = new AssetProductPurchaseRequest();
            $purchase_request->title = $request->title;
            $purchase_request->description = $request->note;
            $purchase_request->requested_by = auth()->user()->id;
            $purchase_request->created_by = auth()->user()->id;
            $purchase_request->created_at = Carbon::now();
            $purchase_request->updated_by = auth()->user()->id;
            $purchase_request->updated_at = Carbon::now();
            $purchase_request->save();

          
            if (isset($request->asset_product_id) && is_array($request->asset_product_id) && count($request->asset_product_id) > 0) {
                foreach ($request->asset_product_id as $key=>$product_id) {
                    $image_path = null;
                    if ($request->hasFile('image') && isset($request->image[$key])) {
                        $imageUploadService = new ImageUploadService();
                        $image_path = $imageUploadService->store($request->image[$key], 'procurement/assets_purchase_request');
                        $image_path = $image_path['path'];
                    }
                    $request_details = new AssetProductPurchaseRequestDetails();
                    $request_details->asset_product_purchase_request_id = $purchase_request->id;
                    $request_details->asset_product_category_id = $request->asset_product_category_id[$key];
                    $request_details->asset_product_id = $product_id;
                    $request_details->qty = $request->qty[$key];
                    $request_details->description = $request->description[$key];
                    $request_details->file = $image_path??null;
                    $request_details->created_by = auth()->user()->id;
                    $request_details->created_at = Carbon::now();
                    $request_details->updated_by = auth()->user()->id;
                    $request_details->updated_at = Carbon::now();
                    $request_details->save();
                }
            }

        }catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
        DB::commit();

        // return $purchase_request;
    }
}
