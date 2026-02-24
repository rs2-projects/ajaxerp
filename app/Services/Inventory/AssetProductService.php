<?php

namespace App\Services\Inventory;

use App\Models\Accounting\AccCoaAccount;
use App\Models\Accounting\AccCoaSubCategory;
use App\Models\Accounting\Transaction;
use App\Models\Department;
use App\Models\Products\AssetProduct;
use App\Models\Products\AssetProductAssign;
use App\Models\Products\AssetProductAssignAttachment;
use App\Models\Products\AssetProductCategory;
use App\Services\Common\FileUploadService;
use App\Services\Common\ImageUploadService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AssetProductService
{
    public function __construct()
    {
        $this->paginate_limit = config('commonData.paginate_limit');
    }

    public function indexData(){
        $data['product_count'] = AssetProduct::where('deleted', AssetProduct::DELETED_NO)->count();

        $data['categories'] = AssetProductCategory::where('deleted', AssetProductCategory::DELETED_NO)
            ->where('status', AssetProductCategory::STATUS_ACTIVE)
            ->orderBy('name', 'asc')->get();

        $data['departments'] = Department::where('deleted', Department::DELETED_NO)
            ->orderBy('name', 'asc')
            ->get();

        $data['accounts_sub_categories'] = AccCoaSubCategory::with('accounts')
            ->where('deleted', AccCoaSubCategory::DELETED_NO)
            ->where('status', AccCoaSubCategory::STATUS_ACTIVE)
            ->where('is_account_type', AccCoaSubCategory::IS_ACCOUNT_TYPE_YES)
            ->get();

        $data['ppe_sub_category'] = AccCoaSubCategory::with('accounts')
            ->where('slug', 'property-plant-equipment')
            ->where('deleted', AccCoaSubCategory::DELETED_NO)
            ->where('status', AccCoaSubCategory::STATUS_ACTIVE)
            ->first();

        $data['return_types'] = AssetProductAssign::RETURN_TYPES;

        return $data;
    }

    public function indexFilteredData($request)
    {
        $status = $request->status_filtered;

        switch ($status){
            case 'all':
                return $this->getAllAssetProducts($request);
                break;
            case 'available':
                return $this->getAvailableAssetProducts($request);
                break;
            case 'assigned':
                return $this->getAssignedAssetProducts($request);
                break;
            case 'maintenance':
                return $this->getMaintenanceAssetProducts($request);
                break;
            case 'sold':
                return $this->getSoldAssetProducts($request);
                break;
            case 'disposed':
                return $this->getDisposedAssetProducts($request);
                break;
        }
    }

    public function getAllAssetProducts($request)
    {
        $keyword_filtered = $request->keyword_filtered;
        $category_id = $request->category_id;
        $data['product_count'] = AssetProduct::where('deleted', AssetProduct::DELETED_NO)
            ->where('status', AssetProduct::STATUS_ACTIVE)->count();
        $data['products'] = AssetProduct::where('deleted', AssetProduct::DELETED_NO)
            ->where(function ($q) use ($keyword_filtered){
                if ($keyword_filtered !=''){
                    $q->where('name', 'like', '%'.$keyword_filtered.'%');
                }
            })
            ->where(function ($q) use ($category_id){
                if ($category_id !=''){
                    $q->where('asset_product_category_id', $category_id);
                }
            })
            ->orderBy('id', 'desc')->paginate($this->paginate_limit);

        $data['view'] = view('inventory.assets.asset-product._index_filtered', $data)->render();
        return $data;
    }

    public function getAvailableAssetProducts($request)
    {
        $keyword_filtered = $request->keyword_filtered;
        $category_id = $request->category_id;
        $data['product_count'] = AssetProduct::where('deleted', AssetProduct::DELETED_NO)
            ->where('status', AssetProduct::STATUS_ACTIVE)->count();
        $data['products'] = AssetProduct::where('deleted', AssetProduct::DELETED_NO)
            ->where('available_qty', '>', 0)
            ->where(function ($q) use ($keyword_filtered){
                if ($keyword_filtered !=''){
                    $q->where('name', 'like', '%'.$keyword_filtered.'%');
                }
            })
            ->where(function ($q) use ($category_id){
                if ($category_id !=''){
                    $q->where('asset_product_category_id', $category_id);
                }
            })
            ->orderBy('id', 'desc')->paginate($this->paginate_limit);

        $data['view'] = view('inventory.assets.asset-product._available_filtered', $data)->render();
        return $data;
    }

    public function getAssignedAssetProducts($request)
    {
        $keyword_filtered = $request->keyword_filtered;
        $category_id = $request->category_id;
        $data['product_count'] = AssetProduct::where('deleted', AssetProduct::DELETED_NO)
            ->where('status', AssetProduct::STATUS_ACTIVE)->count();
        $data['products'] = AssetProduct::where('deleted', AssetProduct::DELETED_NO)
            ->where('assigned_qty', '>', 0)
            ->where(function ($q) use ($keyword_filtered){
                if ($keyword_filtered !=''){
                    $q->where('name', 'like', '%'.$keyword_filtered.'%');
                }
            })
            ->where(function ($q) use ($category_id){
                if ($category_id !=''){
                    $q->where('asset_product_category_id', $category_id);
                }
            })
            ->orderBy('id', 'desc')->paginate($this->paginate_limit);

        $data['view'] = view('inventory.assets.asset-product._assigned_filtered', $data)->render();
        return $data;
    }

    public function getMaintenanceAssetProducts($request)
    {
        $keyword_filtered = $request->keyword_filtered;
        $category_id = $request->category_id;
        $data['product_count'] = AssetProduct::where('deleted', AssetProduct::DELETED_NO)
            ->where('status', AssetProduct::STATUS_ACTIVE)->count();
        $data['products'] = AssetProduct::where('deleted', AssetProduct::DELETED_NO)
            ->where('maintenance_qty', '>', 0)
            ->where(function ($q) use ($keyword_filtered){
                if ($keyword_filtered !=''){
                    $q->where('name', 'like', '%'.$keyword_filtered.'%');
                }
            })
            ->where(function ($q) use ($category_id){
                if ($category_id !=''){
                    $q->where('asset_product_category_id', $category_id);
                }
            })
            ->orderBy('id', 'desc')->paginate($this->paginate_limit);

        $data['view'] = view('inventory.assets.asset-product._maintenance_filtered', $data)->render();
        return $data;
    }

    public function getSoldAssetProducts($request)
    {
        $keyword_filtered = $request->keyword_filtered;
        $category_id = $request->category_id;
        $data['product_count'] = AssetProduct::where('deleted', AssetProduct::DELETED_NO)
            ->where('status', AssetProduct::STATUS_ACTIVE)->count();
        $data['products'] = AssetProduct::where('deleted', AssetProduct::DELETED_NO)
            ->where('sold_qty', '>', 0)
            ->where(function ($q) use ($keyword_filtered){
                if ($keyword_filtered !=''){
                    $q->where('name', 'like', '%'.$keyword_filtered.'%');
                }
            })
            ->where(function ($q) use ($category_id){
                if ($category_id !=''){
                    $q->where('asset_product_category_id', $category_id);
                }
            })
            ->orderBy('id', 'desc')->paginate($this->paginate_limit);

        $data['view'] = view('inventory.assets.asset-product._sold_filtered', $data)->render();
        return $data;
    }

    public function getDisposedAssetProducts($request)
    {
        $keyword_filtered = $request->keyword_filtered;
        $category_id = $request->category_id;
        $data['product_count'] = AssetProduct::where('deleted', AssetProduct::DELETED_NO)
            ->where('status', AssetProduct::STATUS_ACTIVE)->count();
        $data['products'] = AssetProduct::where('deleted', AssetProduct::DELETED_NO)
            ->where('disposed_qty', '>', 0)
            ->where(function ($q) use ($keyword_filtered){
                if ($keyword_filtered !=''){
                    $q->where('name', 'like', '%'.$keyword_filtered.'%');
                }
            })
            ->where(function ($q) use ($category_id){
                if ($category_id !=''){
                    $q->where('asset_product_category_id', $category_id);
                }
            })
            ->orderBy('id', 'desc')->paginate($this->paginate_limit);

        $data['view'] = view('inventory.assets.asset-product._disposed_filtered', $data)->render();
        return $data;
    }

    public function store($request)
    {
        $check_duplicate = AssetProduct::where('name', $request->name)
            ->where('asset_product_category_id', $request->asset_product_category_id)
            ->where('deleted', AssetProduct::DELETED_NO)
            ->first();
        if (!empty($check_duplicate)) {
            throw new \Exception("Asset Product already exists");
        }

        $check_code_duplicate = AssetProduct::where('code', $request->code)
            ->where('deleted', AssetProduct::DELETED_NO)
            ->first();
        if (!empty($check_code_duplicate)) {
            throw new \Exception("Asset Product code already exists");
        }
        
        $image_path = null;
        if ($request->hasFile('image')) {
            $imageUploadService = new ImageUploadService();
            $image_path = $imageUploadService->store($request->image, 'inventory/asset-product');
            $image_path = $image_path['path'];
        }
        
        $product = new AssetProduct();
        $product->asset_product_category_id = $request->asset_product_category_id;
        $product->name = $request->name;
        $product->code = $request->code ?? null;
        $product->image = $image_path;
        $product->description = $request->description;
        $product->created_by = auth()->user()->id;
        $product->created_at = now();
        $product->updated_by = auth()->user()->id;
        $product->updated_at = now();
        $product->save();
    }

    public function editData($id)
    {
        $data['item'] = AssetProduct::where('id', $id)
            ->where('deleted', AssetProduct::DELETED_NO)
            ->first();
        $data['categories'] = AssetProductCategory::where('deleted', AssetProductCategory::DELETED_NO)
            ->where('status', AssetProductCategory::STATUS_ACTIVE)
            ->orderBy('name', 'asc')->get();

        if (!$data['item']) {
            throw new \Exception('Asset Product not found');
        }
        return $data;
    }

    public function update($request, $id)
    {
        $product = AssetProduct::where('id', $id)
            ->where('deleted', AssetProduct::DELETED_NO)
            ->first();
        if (!$product) {
            throw new \Exception('Asset Product not found');
        }

        $check_duplicate = AssetProduct::where('name', $request->name)
                ->where('asset_product_category_id', $request->asset_product_category_id)
                ->where('deleted', AssetProduct::DELETED_NO)
                ->where('id', '!=', $id)
                ->first();
        if (!empty($check_duplicate)) {
            throw new \Exception("Asset Product already exists");
        }

        $check_code_duplicate = AssetProduct::where('code', $request->code)
            ->where('deleted', AssetProduct::DELETED_NO)
            ->where('id', '!=', $id)
            ->first();
        if (!empty($check_code_duplicate)) {
            throw new \Exception("Asset Product code already exists");
        }

        $image_path = null;
        if ($request->hasFile('image')) {
            $imageUploadService = new ImageUploadService();
            $image_path = $imageUploadService->store($request->image, 'inventory/asset-product');
            $image_path = $image_path['path'];
        }

        $product->asset_product_category_id = $request->asset_product_category_id;
        $product->name = $request->name;
        $product->code = $request->code ?? null;
        $product->image = $image_path?? $product->image;
        $product->description = $request->description;
        $product->updated_by = auth()->user()->id;
        $product->updated_at = now();
        $product->save();
    }

    public function assetDetails($id, $type)
    {
        $data['item'] = AssetProduct::where('id', $id)
            ->where('deleted', AssetProduct::DELETED_NO)
            ->first();
            
        if (!$data['item']) {
            throw new \Exception('Asset Product not found');
        }

        if($type == 'assigned'){
            $data['details'] = AssetProductAssign::where('asset_product_id', $id)
                ->where('deleted', AssetProductAssign::DELETED_NO)
                ->where('status', AssetProductAssign::STATUS_ACTIVE)
                ->where('assign_status', AssetProductAssign::ASSIGN_STATUS_ASSIGNED)
                ->where('return_type', null)
                ->where('return_date', null)
                ->orderBy('id', 'desc')
                ->get();

        }else if ($type == 'maintenance'){
            $data['details'] = AssetProductAssign::where('asset_product_id', $id)
                ->where('deleted', AssetProductAssign::DELETED_NO)
                ->where('status', AssetProductAssign::STATUS_ACTIVE)
                ->where('assign_status', AssetProductAssign::ASSIGN_STATUS_MAINTENANCE)
                ->where('repair_date', null)
                ->where('repaired_by', null)
                ->orderBy('id', 'desc')
                ->get();
        }

        $data['type'] = $type;

        return $data;
    }

    public function assetProductDetails($id)
    {
        $data['item'] = AssetProduct::where('id', $id)
            ->where('deleted', AssetProduct::DELETED_NO)
            ->first();

        if (!$data['item']) {
            throw new \Exception('Asset Product not found');
        }

        $data['details'] = AssetProductAssign::with(['employee.department', 'employee.designation'])
            ->where('asset_product_id', $id)
            ->where('deleted', AssetProductAssign::DELETED_NO)
            ->where('status', AssetProductAssign::STATUS_ACTIVE)
            ->whereIn('assign_status', [
                AssetProductAssign::ASSIGN_STATUS_ASSIGNED,
                AssetProductAssign::ASSIGN_STATUS_MAINTENANCE,
                AssetProductAssign::ASSIGN_STATUS_RETURNED,
            ])
            ->orderBy('date', 'desc')
            ->orderBy('id', 'desc')
            ->get();

        return $data;
    }

    public function assignedDetails($id){
        $data['assign_details'] = AssetProductAssign::where('id', $id)
            ->where('deleted', AssetProductAssign::DELETED_NO)
            ->where('status', AssetProductAssign::STATUS_ACTIVE)
            ->first();

        if (!$data['assign_details']) {
            throw new \Exception('Data not found');
        }
        return $data;
    }

    public function delete($id)
    {
        $product = AssetProduct::where('id', $id)
            ->where('deleted', AssetProduct::DELETED_NO)
            ->first();
        if (!$product) {
            throw new \Exception('Asset Product not found');
        }
        $product->deleted = AssetProduct::DELETED_YES;
        $product->deleted_by = auth()->user()->id;
        $product->deleted_at = now();
        $product->save();
    }

    public function statusUpdateData($id, $status)
    {
        try {
            $product = AssetProduct::where('id', $id)
                ->where('deleted', AssetProduct::DELETED_NO)
                ->first();
            if (!$product) {
                throw new \Exception('Asset Product not found');
            }
            $product->status = $status;
            $product->updated_by = auth()->user()->id;
            $product->updated_at = now();
            $product->save();
        }catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function assignProductStore($request, $id)
    {
        DB::beginTransaction();
        try {
            $product = AssetProduct::where('id', $id)
                ->where('deleted', AssetProduct::DELETED_NO)
                ->first();
            if (!$product) {
                throw new \Exception('Asset Product not found');
            }

            $product->available_qty = $product->available_qty - 1;
            $product->assigned_qty = $product->assigned_qty + 1;
            $product->updated_by = auth()->user()->id;
            $product->updated_at = now();
            $product->save();

            $assign = new AssetProductAssign();
            $assign->asset_product_id = $id;
            $assign->date = $request->date;
            $assign->sl_no = $request->sl_no;
            $assign->model = $request->model;
            $assign->employee_id = $request->employee_id;
            $assign->warranty = $request->warranty;
            $assign->remarks = $request->remarks;
            $assign->assign_status = AssetProductAssign::ASSIGN_STATUS_ASSIGNED;
            $assign->created_by = auth()->user()->id;
            $assign->created_at = now();
            $assign->updated_by = auth()->user()->id;
            $assign->updated_at = now();
            $assign->save();

        }catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
        DB::commit();
    }

    public function maintenanceProductStore($request, $id)
    {
        DB::beginTransaction();
        try {
            $product = AssetProduct::where('id', $id)
                ->where('deleted', AssetProduct::DELETED_NO)
                ->first();
            if (!$product) {
                throw new \Exception('Asset Product not found');
            }

            $type = "";
            if(isset($request->maintenance_type)){
                $type = $request->maintenance_type;
            }
            if($type == ""){
                $product->available_qty = $product->available_qty - 1;
                $product->maintenance_qty = $product->maintenance_qty + 1;
                $product->updated_by = auth()->user()->id;
                $product->updated_at = now();
                $product->save();

                $assign = new AssetProductAssign();
                $assign->asset_product_id = $id;
                $assign->date = $request->date;
                $assign->sl_no = $request->sl_no;
                $assign->model = $request->model;
                $assign->warranty = $request->warranty;
                $assign->remarks = $request->remarks;
                $assign->assign_status = AssetProductAssign::ASSIGN_STATUS_MAINTENANCE;
                $assign->created_by = auth()->user()->id;
                $assign->created_at = now();
                $assign->updated_by = auth()->user()->id;
                $assign->updated_at = now();
                $assign->save();

            }else{
                $product->assigned_qty = $product->assigned_qty - 1;
                $product->maintenance_qty = $product->maintenance_qty + 1;
                $product->updated_by = auth()->user()->id;
                $product->updated_at = now();
                $product->save();

                $assign = AssetProductAssign::where('asset_product_id', $id)
                    ->where('id', $request->asset_assign_id)
                    ->where('status', AssetProductAssign::STATUS_ACTIVE)
                    ->where('assign_status', AssetProductAssign::ASSIGN_STATUS_ASSIGNED)
                    ->first();
                if(!$assign){
                    throw new \Exception('Data not found');
                }

                $assign->date = $request->date;
                $assign->sl_no = $request->sl_no;
                $assign->model = $request->model;
                $assign->warranty = $request->warranty;
                $assign->remarks = $request->remarks;
                $assign->reason = $request->reason;
                // $assign->assign_status = AssetProductAssign::ASSIGN_STATUS_RETURNED;
                $assign->return_type = AssetProductAssign::RETURN_TYPE_FOR_MAINTENANCE;
                $assign->return_date = $request->date;
                $assign->return_reason = $request->reason;
                $assign->updated_by = auth()->user()->id;
                $assign->updated_at = now();
                $assign->save();

                $new_assign = new AssetProductAssign();
                $new_assign->asset_product_id = $id;
                $new_assign->date = $request->date;
                $new_assign->sl_no = $request->sl_no;
                $new_assign->model = $request->model;
                $new_assign->warranty = $request->warranty;
                $new_assign->remarks = $request->remarks;
                $new_assign->assign_status = AssetProductAssign::ASSIGN_STATUS_MAINTENANCE;
                $new_assign->created_by = auth()->user()->id;
                $new_assign->created_at = now();
                $new_assign->updated_by = auth()->user()->id;
                $new_assign->updated_at = now();
                $new_assign->save();
            }
            
        }catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
        DB::commit();
    }

    public function sellProductStore($request, $id)
    {
        DB::beginTransaction();
        try {
            $product = AssetProduct::where('id', $id)
                ->where('deleted', AssetProduct::DELETED_NO)
                ->first();
            if (!$product) {
                throw new \Exception('Asset Product not found');
            }

            if($request->qty > $product->available_qty){
                throw new \Exception("Sell quantity can't be larger than available quantity");
            }

            $product->available_qty = $product->available_qty - 1;
            $product->sold_qty = $product->sold_qty + 1;
            $product->updated_by = auth()->user()->id;
            $product->updated_at = now();
            $product->save();

            $assign = new AssetProductAssign();
            $assign->asset_product_id = $id;
            $assign->date = $request->date;
            $assign->qty = $request->qty;
            $assign->unit_price = $request->unit_price;
            $assign->remarks = $request->remarks;
            $assign->assign_status = AssetProductAssign::ASSIGN_STATUS_SOLD;
            $assign->created_by = auth()->user()->id;
            $assign->created_at = now();
            $assign->updated_by = auth()->user()->id;
            $assign->updated_at = now();
            $assign->save();

            if ($request->hasFile('attachment')) {
                if (count($request->file('attachment')) > 0) {
                    foreach ($request->file('attachment') as $key=>$file) {
                        $fileUploadService = new FileUploadService();
                        $file_path = $fileUploadService->store($request->attachment[$key], 'inventory/asset-product/sell-attachment');
                        $file_path = $file_path['path'];

                        $attachment = new AssetProductAssignAttachment();
                        $attachment->asset_product_assign_id = $assign->id;
                        $attachment->attachment = $file_path;
                        $attachment->save();
                    }
                }
            }

            $account = AccCoaAccount::where('id', $request->account_id)
                ->where('deleted', AccCoaAccount::DELETED_NO)
                ->first();
            if (!$account) {
                throw new \Exception("Account not found");
            }

            // Create Transaction
            $transaction = new Transaction();
            $transaction->paid_type = Transaction::PAID_TYPE_PAID;
            $transaction->transaction_type = Transaction::TRANSACTION_TYPE_DEPOSIT;
            $transaction->transaction_date = $request->date;
            $transaction->account_id = $account->id;
            $transaction->category_id = $request->category_id;
            $transaction->reference_type = Transaction::REFERENCE_TYPE_ASSET_PRODUCT_SELL;
            $transaction->reference_id = $product->id;
            $transaction->reference_description = "Asset Product Sell ".$product->id;
            $transaction->net_amount = $request->total_price;
            $transaction->total_vat_amount = 0;
            $transaction->total_amount = $request->total_price;
            $transaction->description = "Asset Product Sell ".$product->id;
            $transaction->note = $request->remarks;
            $transaction->created_at = Carbon::now();
            $transaction->created_by = auth()->user()->id;
            $transaction->updated_at = Carbon::now();
            $transaction->updated_by = auth()->user()->id;
            $transaction->save();
            
        }catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
        DB::commit();
    }

    public function disposeProductStore($request, $id)
    {
        DB::beginTransaction();
        try {
            $product = AssetProduct::where('id', $id)
                ->where('deleted', AssetProduct::DELETED_NO)
                ->first();
            if (!$product) {
                throw new \Exception('Asset Product not found');
            }

            if($request->qty > $product->available_qty){
                throw new \Exception("Sell quantity can't be larger than available quantity");
            }

            $product->available_qty = $product->available_qty - 1;
            $product->disposed_qty = $product->disposed_qty + 1;
            $product->updated_by = auth()->user()->id;
            $product->updated_at = now();
            $product->save();

            $assign = new AssetProductAssign();
            $assign->asset_product_id = $id;
            $assign->date = $request->date;
            $assign->qty = $request->qty;
            $assign->remarks = $request->remarks;
            $assign->assign_status = AssetProductAssign::ASSIGN_STATUS_DISPOSED;
            $assign->created_by = auth()->user()->id;
            $assign->created_at = now();
            $assign->updated_by = auth()->user()->id;
            $assign->updated_at = now();
            $assign->save();

            if ($request->hasFile('attachment')) {
                if (count($request->file('attachment')) > 0) {
                    foreach ($request->file('attachment') as $key=>$file) {
                        $fileUploadService = new FileUploadService();
                        $file_path = $fileUploadService->store($request->attachment[$key], 'inventory/asset-product/disposed-attachment');
                        $file_path = $file_path['path'];

                        $attachment = new AssetProductAssignAttachment();
                        $attachment->asset_product_assign_id = $assign->id;
                        $attachment->attachment = $file_path;
                        $attachment->save();
                    }
                }
            }
            
        }catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
        DB::commit();
    }

    public function returnProductStore($request, $id)
    {
        DB::beginTransaction();
        try {
            $assign = AssetProductAssign::where('id', $id)
                ->where('deleted', AssetProductAssign::DELETED_NO)
                ->first();
            if (!$assign) {
                throw new \Exception('Data not found');
            }

            $product = AssetProduct::where('id', $assign->asset_product_id)
                ->where('deleted', AssetProduct::DELETED_NO)
                ->first();
            if (!$product) {
                throw new \Exception('Asset Product not found');
            }

            $product->available_qty = $product->available_qty + 1;
            $product->assigned_qty = $product->assigned_qty - 1;
            $product->updated_by = auth()->user()->id;
            $product->updated_at = now();
            $product->save();

            $assign->return_date = $request->return_date;
            $assign->return_type = $request->return_type;
            $assign->return_reason = $request->return_reason;
            // $assign->assign_status = AssetProductAssign::ASSIGN_STATUS_RETURNED;
            $assign->updated_by = auth()->user()->id;
            $assign->updated_at = now();
            $assign->save();

        }catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
        DB::commit();
    }

    public function repairProductStore($request, $id)
    {
        DB::beginTransaction();
        try {
            $assign = AssetProductAssign::where('id', $id)
                ->where('deleted', AssetProductAssign::DELETED_NO)
                ->first();
            if (!$assign) {
                throw new \Exception('Data not found');
            }

            $product = AssetProduct::where('id', $assign->asset_product_id)
                ->where('deleted', AssetProduct::DELETED_NO)
                ->first();
            if (!$product) {
                throw new \Exception('Asset Product not found');
            }

            $product->available_qty = $product->available_qty + 1;
            $product->maintenance_qty = $product->maintenance_qty - 1;
            $product->updated_by = auth()->user()->id;
            $product->updated_at = now();
            $product->save();

            $assign->repair_date = $request->repair_date;
            $assign->repair_note = $request->repair_note;
            $assign->repaired_by = auth()->user()->id;
            $assign->repaired_at = now();
            // $assign->assign_status = AssetProductAssign::ASSIGN_STATUS_REPAIRED;
            $assign->save();

        }catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
        DB::commit();
    }

    public function printQrCode($request)
    {
        $itemIds = $request->input('item_id', []);
        $qtys = $request->input('qty', []);
        $data = [];

        foreach ($itemIds as $index => $itemId) {
            $qty = isset($qtys[$index]) ? (int) $qtys[$index] : 0;
            if ($qty <= 0) {
                continue;
            }

            $item = AssetProduct::select('id', 'name', 'code')
                ->where('id', $itemId)
                ->where('deleted', AssetProduct::DELETED_NO)
                ->where('status', AssetProduct::STATUS_ACTIVE)
                ->first();

            if (!$item) {
                continue;
            }

            for ($i = 0; $i < $qty; $i++) {
                $data[] = [
                    'id' => $item->id,
                    'name' => $item->name,
                    'code' => $item->code,
                ];
            }
        }

        return $data;
    }
}
