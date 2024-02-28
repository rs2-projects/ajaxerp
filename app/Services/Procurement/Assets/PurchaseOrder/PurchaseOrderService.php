<?php

namespace App\Services\Procurement\Assets\PurchaseOrder;

use App\Models\Accounting\AccCoaAccount;
use App\Models\Accounting\AccCoaSubCategory;
use App\Models\Accounting\Transaction;
use App\Models\Inventory\InventoryAssetProduct;
use App\Models\Procurements\AssetProductPurchaseOrder;
use App\Models\Procurements\AssetProductPurchaseOrderDamageFile;
use App\Models\Procurements\AssetProductPurchaseOrderDetails;
use App\Models\Procurements\AssetProductPurchaseRequestDetails;
use App\Models\Procurements\Supplier;
use App\Models\Products\AssetProduct;
use App\Services\Common\FileUploadService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PurchaseOrderService
{
    public function __construct()
    {
        $this->paginate_limit = config('commonData.paginate_limit');
    }

    public function indexFilteredData($request)
    {
        $purchase_status = $request->status_filtered;

        switch ($purchase_status){
            case 'all_purchase':
                return $this->getAllPurchaseOrders($request);
                break;
            case 'new_purchase':
                return $this->getNewPurchaseOrders($request);
                break;
            case 'on_process_purchase':
                return $this->getOnProcessPurchaseOrders($request);
                break;
            case 'delivered_purchase':
                return $this->getDeliveredPurchaseOrders($request);
                break;
            case 'cancelled_purchase':
                return $this->getCancelledPurchaseOrders($request);
                break;
        }
    }

    public function getAllPurchaseOrders($request)
    {
        $keyword_filtered = $request->keyword_filtered??null;
        $start_date_filtered = $request->start_date_filtered??null;
        $end_date_filtered = $request->end_date_filtered??null;


        $data['purchase_orders'] = AssetProductPurchaseOrder::with('supplier','purchaseDetails')
            ->where('deleted', AssetProductPurchaseOrder::DELETED_NO)
            ->where(function ($q) use($keyword_filtered){
                if($keyword_filtered != null){
                    $q->where('purchase_order_id', 'LIKE', '%'.$keyword_filtered.'%');
                }
            })
            ->where(function ($q) use($start_date_filtered,$end_date_filtered){
                if($start_date_filtered != null){
                    $q->whereDate('purchase_date', '>=', $start_date_filtered);
                }
                if($end_date_filtered != null){
                    $q->whereDate('purchase_date', '<=', $end_date_filtered);
                }
            })
            ->orderBy('purchase_status', 'ASC')
            ->orderBy('payment_status', 'ASC')
            ->orderBy('id', 'DESC')
            ->paginate($this->paginate_limit);

        $data['view'] = view('procurement.asset-purchase-order._index_filtered', $data)->render();

        return $data;
    }

    public function getNewPurchaseOrders($request)
    {
        $keyword_filtered = $request->keyword_filtered;
        $start_date_filtered = $request->start_date_filtered??null;
        $end_date_filtered = $request->end_date_filtered??null;

        $data['purchase_orders'] = AssetProductPurchaseOrder::with('supplier','purchaseDetails')
            ->where('purchase_status', AssetProductPurchaseOrder::PURCHASE_STATUS_NEW)
            ->where('deleted', AssetProductPurchaseOrder::DELETED_NO)
            ->where(function ($q) use($keyword_filtered){
                if($keyword_filtered != null){
                    $q->where('purchase_order_id', 'LIKE', '%'.$keyword_filtered.'%');
                }
            })
            ->where(function ($q) use($start_date_filtered,$end_date_filtered){
                if($start_date_filtered != null){
                    $q->whereDate('purchase_date', '>=', $start_date_filtered);
                }
                if($end_date_filtered != null){
                    $q->whereDate('purchase_date', '<=', $end_date_filtered);
                }
            })
            ->orderBy('payment_status', 'ASC')
            ->orderBy('id', 'DESC')
            ->paginate($this->paginate_limit);

        $data['view'] = view('procurement.asset-purchase-order._new_index_filtered', $data)->render();

        return $data;
    }

    public function getOnProcessPurchaseOrders($request)
    {
        $keyword_filtered = $request->keyword_filtered;
        $start_date_filtered = $request->start_date_filtered??null;
        $end_date_filtered = $request->end_date_filtered??null;

        $data['purchase_orders'] = AssetProductPurchaseOrder::with('supplier','purchaseDetails')
            ->where('purchase_status', AssetProductPurchaseOrder::PURCHASE_STATUS_ON_PROCESS)
            ->where('deleted', AssetProductPurchaseOrder::DELETED_NO)
            ->where(function ($q) use($keyword_filtered){
                if($keyword_filtered != null){
                    $q->where('purchase_order_id', 'LIKE', '%'.$keyword_filtered.'%');
                }
            })
            ->where(function ($q) use($start_date_filtered,$end_date_filtered){
                if($start_date_filtered != null){
                    $q->whereDate('purchase_date', '>=', $start_date_filtered);
                }
                if($end_date_filtered != null){
                    $q->whereDate('purchase_date', '<=', $end_date_filtered);
                }
            })
            ->orderBy('id', 'DESC')
            ->paginate($this->paginate_limit);

        $data['view'] = view('procurement.asset-purchase-order._on_process_index_filtered', $data)->render();

        return $data;
    }

    public function getDeliveredPurchaseOrders($request)
    {
        $keyword_filtered = $request->keyword_filtered;
        $start_date_filtered = $request->start_date_filtered??null;
        $end_date_filtered = $request->end_date_filtered??null;

        $data['purchase_orders'] = AssetProductPurchaseOrder::with('supplier','purchaseDetails')
            ->where('purchase_status', AssetProductPurchaseOrder::PURCHASE_STATUS_DELIVERED)
            ->where('deleted', AssetProductPurchaseOrder::DELETED_NO)
            ->where(function ($q) use($keyword_filtered){
                if($keyword_filtered != null){
                    $q->where('purchase_order_id', 'LIKE', '%'.$keyword_filtered.'%');
                }
            })
            ->where(function ($q) use($start_date_filtered,$end_date_filtered){
                if($start_date_filtered != null){
                    $q->whereDate('purchase_date', '>=', $start_date_filtered);
                }
                if($end_date_filtered != null){
                    $q->whereDate('purchase_date', '<=', $end_date_filtered);
                }
            })
            ->orderBy('id', 'DESC')
            ->paginate($this->paginate_limit);

        $data['view'] = view('procurement.asset-purchase-order._delivered_index_filtered', $data)->render();

        return $data;
    }

    public function getCancelledPurchaseOrders($request)
    {
        $keyword_filtered = $request->keyword_filtered;
        $start_date_filtered = $request->start_date_filtered??null;
        $end_date_filtered = $request->end_date_filtered??null;

        $data['purchase_orders'] = AssetProductPurchaseOrder::with('supplier','purchaseDetails')
            ->where('purchase_status', AssetProductPurchaseOrder::PURCHASE_STATUS_CANCELLED)
            ->where('deleted', AssetProductPurchaseOrder::DELETED_NO)
            ->where(function ($q) use($keyword_filtered){
                if($keyword_filtered != null){
                    $q->where('purchase_order_id', 'LIKE', '%'.$keyword_filtered.'%');
                }
            })
            ->where(function ($q) use($start_date_filtered,$end_date_filtered){
                if($start_date_filtered != null){
                    $q->whereDate('purchase_date', '>=', $start_date_filtered);
                }
                if($end_date_filtered != null){
                    $q->whereDate('purchase_date', '<=', $end_date_filtered);
                }
            })
            ->orderBy('id', 'DESC')
            ->paginate($this->paginate_limit);

        $data['view'] = view('procurement.asset-purchase-order._cancelled_po_index_filtered', $data)->render();

        return $data;
    }

    public function createData()
    {
        $data['purchaseDate'] = Carbon::now();
        $data['estimatedDeliveryDate'] = Carbon::now();
        return $data;
    }

    public function getSelectedPurchaseData($details_ids)
    {
        $cartItems = AssetProductPurchaseRequestDetails::whereIn('id', $details_ids)
            ->where('deleted', AssetProductPurchaseRequestDetails::DELETED_NO)
            ->where('status', AssetProductPurchaseRequestDetails::STATUS_ACTIVE)
            ->get()
            ->map(function ($item){
                $itemTax = (object) [
                    'id' => null,
                    'name' => null,
                    'tax_rate' => 0,
                ];
                $details_id = $item->id;
                return [
                    'id' => $item->asset_product->id,
                    'name' => $item->asset_product->name,
                    'show_image' => asset($item->asset_product->show_image),
                    'description' => $item->asset_product->description,
                    'qty' => 1,
                    'price' => 0,
                    'tax' => $itemTax,
                    'details_id' => $details_id,
                    'category_name' => $item->asset_category->name,
                ];
            });

        $data['cartItems'] = $cartItems;
        return $data;
    }

    public function store($request)
    {
        DB::beginTransaction();
        try {
            $checkBatchNumber = AssetProductPurchaseOrder::where('batch_number', $request->batch_number)
                ->where('deleted', AssetProductPurchaseOrder::DELETED_NO)
                ->first();
            if (!empty($checkBatchNumber)) {
                throw new \Exception("Batch Number already exists");
            }

            $purchase = new AssetProductPurchaseOrder();
            $purchase->asset_product_purchase_request_id = $request->asset_product_purchase_request_id??null;
            $purchase->supplier_id = $request->supplier_id;
            $purchase->purchase_order_id = '';
            $purchase->batch_number = $request->batch_number;
            $purchase->purchase_date = $request->purchase_date;
            $purchase->discount_type = $request->discount_type;
            $purchase->discount_value = $request->discount_value;
            $purchase->estimated_delivery_date = $request->estimated_delivery_date;
            $purchase->notes = $request->notes;
            $purchase->invoice_footer = $request->invoice_footer;
            $purchase->created_at = Carbon::now();
            $purchase->created_by = auth()->user()->id;
            $purchase->updated_at = Carbon::now();
            $purchase->updated_by = auth()->user()->id;
            $purchase->save();
            $purchase->purchase_order_id = "PO-".(1000 + $purchase->id);
            $purchase->save();

            $total_discount_amount = 0;
            $subtotal_amount = 0;
            $total_vat_amount = 0;

            if(isset($request->product_id) && is_array($request->product_id) && count($request->product_id) > 0){
                foreach ($request->product_id as $key=>$product){
                    $asset_product = AssetProduct::where('status', AssetProduct::STATUS_ACTIVE)
                        ->where('deleted', AssetProduct::DELETED_NO)
                        ->where('id', $product)
                        ->first();

                    if(empty($asset_product)){
                        continue;
                    }

                    $qty = $request->qty[$key];
                    $price = $request->price[$key];
                    $tax_id = $request->tax[$key];

                    $amount_without_tax = $qty * $price;
                    $amount_with_tax = 0;
                    $tax_rate = 0;
                    $tax_amount = 0;
                    if(($tax_id != null) && ($tax_id != '') && ($tax_id != 0)) {
                        $tax = AccCoaAccount::where('status', AccCoaAccount::STATUS_ACTIVE)
                            ->where('deleted', AccCoaAccount::DELETED_NO)
                            ->where('id', $tax_id)
                            ->first();
                        if(!empty($tax)){
                            $tax_rate = $tax->tax_rate;
                            $tax_amount = $amount_without_tax * $tax_rate / 100;
                            $amount_with_tax = $amount_without_tax + $tax_amount;
                        } else {
                            $tax_id = null;
                        }
                    }else{
                        $amount_with_tax = $amount_without_tax;
                        $tax_id = null;
                    }

                    $purchaseDetails = new AssetProductPurchaseOrderDetails();
                    $purchaseDetails->asset_product_purchase_order_id = $purchase->id;
                    $purchaseDetails->asset_product_id = $product;
                    $purchaseDetails->asset_product_purchase_request_id = $request->asset_product_purchase_request_id??null;
                    $purchaseDetails->asset_product_purchase_request_detail_id = $request->asset_product_purchase_request_detail_id[$key]??null;
                    $purchaseDetails->description = $request->description[$key];
                    $purchaseDetails->warranty = $request->warranty[$key];
                    $purchaseDetails->qty = $qty;
                    $purchaseDetails->unit_price = $price;
                    $purchaseDetails->total_price = $qty * $price;
                    $purchaseDetails->tax_id = $tax_id;
                    $purchaseDetails->tax_rate = $tax_rate;
                    $purchaseDetails->tax_amount = $tax_amount;
                    $purchaseDetails->net_total = $amount_with_tax;
                    $purchaseDetails->created_at = Carbon::now();
                    $purchaseDetails->created_by = auth()->user()->id;
                    $purchaseDetails->updated_at = Carbon::now();
                    $purchaseDetails->updated_by = auth()->user()->id;
                    $purchaseDetails->save();

                    $subtotal_amount += $purchaseDetails->total_price;
                    $total_vat_amount += $purchaseDetails->tax_amount;

                }
            }else{
                throw new \Exception("Please select at least 1 product!");
            }

            if($purchase->discount_type == AssetProductPurchaseOrder::DISCOUNT_TYPE_PERCENTAGE){
                $total_discount_amount = ($subtotal_amount * $purchase->discount_value) / 100;
            }else{
                $total_discount_amount = $purchase->discount_value;
            }

            $purchase->subtotal_amount = $subtotal_amount;
            $purchase->total_vat_amount = $total_vat_amount;
            $purchase->total_discount_amount = $total_discount_amount;
            $purchase->payable_amount = $subtotal_amount + $total_vat_amount - $total_discount_amount;
            $purchase->due_amount = $subtotal_amount + $total_vat_amount - $total_discount_amount;
            $purchase->save();


        }catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
        DB::commit();
    }

    //edit
    public function editData($id)
    {
        $data['purchase'] = AssetProductPurchaseOrder::where('id', $id)
            ->where('deleted', AssetProductPurchaseOrder::DELETED_NO)
            ->first();
        if (empty($data['purchase'])) {
            return redirect()->back()->with(['failed' => 'Invalid Purchase Order!']);
        }

        return $data;
    }

    public function getEditPurchaseData($request,$id)
    {
        $purchase = AssetProductPurchaseOrder::where('id', $id)
            ->where('deleted', 0)
            ->first();

        $supplier = Supplier::where('id', $purchase->supplier_id)
            ->where('status', 1)
            ->where('deleted', 0)
            ->first();
        $supplier->show_image_full_url = asset($supplier->show_image);
        $supplier->contact_full_name = $supplier->full_name;

        $cartItems = AssetProductPurchaseOrderDetails::where('asset_product_purchase_order_id', $id)
            ->where('deleted', AssetProductPurchaseOrderDetails::DELETED_NO)
            ->where('status', AssetProductPurchaseOrderDetails::STATUS_ACTIVE)
            ->get()
            ->map(function ($item){
                if($item->tax_id == null) {
                    $itemTax = (object) [
                        'id' => null,
                        'name' => null,
                        'tax_rate' => 0,
                    ];
                } else {
                    $itemTax = AccCoaAccount::find($item->tax_id);
                }
                return [
                    'id' => $item->assetProduct->id,
                    'name' => $item->assetProduct->name,
                    'show_image' => asset($item->assetProduct->show_image),
                    'description' => $item->assetProduct->description,
                    'qty' => $item->qty,
                    'warranty' => $item->warranty,
                    'price' => $item->unit_price,
                    'total_price' => $item->total_price,
                    'tax' => $itemTax,
                    'category_name' => $item->assetProduct->category->name,
                ];
            });

        $data['supplier'] = $supplier;
        $data['cartItems'] = $cartItems;

        return $data;
    }

    public function update($request, $id)
    {
        DB::beginTransaction();
        try {
            $purchase = AssetProductPurchaseOrder::where('id', $id)
                ->where('deleted', AssetProductPurchaseOrder::DELETED_NO)
                ->first();
            if(empty($purchase)){
                throw new \Exception("Purchase Order Not Found");
            }

            $checkBatchNumber = AssetProductPurchaseOrder::where('batch_number', $request->batch_number)
                ->where('id', '!=', $id)
                ->where('deleted', AssetProductPurchaseOrder::DELETED_NO)
                ->first();

            if (!empty($checkBatchNumber)) {
                throw new \Exception("Batch Number already exists");
            }

            $purchase->supplier_id = $request->supplier_id;
            $purchase->batch_number = $request->batch_number;
            $purchase->purchase_date = $request->purchase_date;
            $purchase->estimated_delivery_date = $request->estimated_delivery_date;
            $purchase->discount_type = $request->discount_type;
            $purchase->discount_value = $request->discount_value;
            $purchase->notes = $request->notes;
            $purchase->invoice_footer = $request->invoice_footer;
            $purchase->updated_at = Carbon::now();
            $purchase->updated_by = auth()->user()->id;
            $purchase->save();

            // check if not exist then delete first
            if (isset($request->product_id) && is_array($request->product_id) && count($request->product_id) > 0) {
                $product_ids = $request->product_id??[];
                $delete_not_existed_product = AssetProductPurchaseOrderDetails::where('asset_product_purchase_order_id', $purchase->id)
                    ->whereNotIn('asset_product_id', $product_ids)
                    ->where('deleted', AssetProductPurchaseOrderDetails::DELETED_NO)
                    ->delete();

                $subtotal_amount = 0;
                $total_vat_amount = 0;

                foreach ($request->product_id as $key=>$product){
                    $asset_product = AssetProduct::where('status', AssetProduct::STATUS_ACTIVE)
                        ->where('deleted', AssetProduct::DELETED_NO)
                        ->where('id', $product)
                        ->first();

                    if(empty($asset_product)){
                        continue;
                    }

                    $qty = $request->qty[$key];
                    $price = $request->price[$key];
                    $tax_id = $request->tax[$key];

                    $amount_without_tax = $qty * $price;
                    $amount_with_tax = 0;
                    $tax_rate = 0;
                    $tax_amount = 0;
                    if(($tax_id != null) && ($tax_id != '') && ($tax_id != 0)) {
                        $tax = AccCoaAccount::where('status', AccCoaAccount::STATUS_ACTIVE)
                            ->where('deleted', AccCoaAccount::DELETED_NO)
                            ->where('id', $tax_id)
                            ->first();
                        if(!empty($tax)){
                            $tax_rate = $tax->tax_rate;
                            $amount_with_tax = $amount_without_tax + ($amount_without_tax * $tax_rate / 100);
                            $tax_amount = $amount_without_tax * $tax_rate / 100;
                        }else {
                            $tax_id = null;
                        }
                    }else{
                        $amount_with_tax = $amount_without_tax;
                        $tax_id = null;
                    }

                    $purchaseDetails = AssetProductPurchaseOrderDetails::where('asset_product_purchase_order_id', $purchase->id)
                        ->where('asset_product_id', $product)
                        ->where('deleted', AssetProductPurchaseOrderDetails::DELETED_NO)
                        ->first();
                    if(empty($purchaseDetails)){
                        $purchaseDetails = new AssetProductPurchaseOrderDetails();
                        $purchaseDetails->asset_product_purchase_order_id = $purchase->id;
                        $purchaseDetails->asset_product_id = $product;
                        $purchaseDetails->created_at = Carbon::now();
                        $purchaseDetails->created_by = auth()->user()->id;
                    }
                    $purchaseDetails->description = $request->description[$key];
                    $purchaseDetails->warranty = $request->warranty[$key];
                    $purchaseDetails->qty = $qty;
                    $purchaseDetails->unit_price = $price;
                    $purchaseDetails->total_price = $qty * $price;
                    $purchaseDetails->tax_id = $tax_id??null;
                    $purchaseDetails->tax_rate = $tax_rate;
                    $purchaseDetails->tax_amount = $tax_amount;
                    $purchaseDetails->net_total = $amount_with_tax;
                    $purchaseDetails->updated_at = Carbon::now();
                    $purchaseDetails->updated_by = auth()->user()->id;
                    $purchaseDetails->save();

                    $subtotal_amount += $purchaseDetails->total_price;
                    $total_vat_amount += $purchaseDetails->tax_amount;

                }
            }

            $total_discount_amount = 0;
            if($purchase->discount_type == AssetProductPurchaseOrder::DISCOUNT_TYPE_PERCENTAGE){
                $total_discount_amount = ($subtotal_amount * $purchase->discount_value) / 100;
            }else{
                $total_discount_amount = $purchase->discount_value;
            }

            $purchase->subtotal_amount = $subtotal_amount;
            $purchase->total_vat_amount = $total_vat_amount;
            $purchase->total_discount_amount = $total_discount_amount;
            $purchase->payable_amount = $subtotal_amount + $total_vat_amount - $total_discount_amount;
            $purchase->due_amount = $subtotal_amount + $total_vat_amount - $total_discount_amount;
            $purchase->save();

        }catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
        DB::commit();
    }


    public function deleteData($id)
    {
        try {
            $purchase = AssetProductPurchaseOrder::where('id', $id)
                ->where('deleted', AssetProductPurchaseOrder::DELETED_NO)
                ->first();
            if(empty($purchase)){
                throw new \Exception("Purchase Order Not Found");
            }

            $purchase->deleted = AssetProductPurchaseOrder::DELETED_YES;
            $purchase->deleted_at = Carbon::now();
            $purchase->deleted_by = auth()->user()->id;
            $purchase->save();

            $purchaseDetails = AssetProductPurchaseOrderDetails::where('asset_product_purchase_order_id', $id)
                ->get();

            foreach ($purchaseDetails as $purchaseDetail){
                $purchaseDetail->deleted = AssetProductPurchaseOrderDetails::DELETED_YES;
                $purchaseDetail->deleted_at = Carbon::now();
                $purchaseDetail->deleted_by = auth()->user()->id;
                $purchaseDetail->save();
            }

        }catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function cancelData($id){
        try {
            $purchase = AssetProductPurchaseOrder::where('id', $id)
                ->where('deleted', AssetProductPurchaseOrder::DELETED_NO)
                ->first();
            if(empty($purchase)){
                throw new \Exception("Purchase Order Not Found");
            }

            $purchase->purchase_status = 3; //cancel
            $purchase->save();
        }catch (\Exception $e){
            throw new \Exception($e->getMessage());
        }
    }

    public function statusUpdate($id, $status)
    {
        DB::beginTransaction();
        try {
            $purchase = AssetProductPurchaseOrder::where('id', $id)
                ->where('deleted', AssetProductPurchaseOrder::DELETED_NO)
                ->first();
            if(empty($purchase)){
                throw new \Exception("Purchase Order Not Found");
            }

            $purchase->purchase_status = $status;
            $purchase->save();

            if ($status == $purchase::PURCHASE_STATUS_ON_PROCESS){
                $transaction = Transaction::where('reference_type', Transaction::REFERENCE_TYPE_ASSET_PRODUCT_PURCHASE)
                    ->where('reference_id', $id)
                    ->where('deleted', Transaction::DELETED_NO)
                    ->first();
                if(empty($transaction)){
                    $account = AccCoaAccount::where('slug', 'purchase-products')
                        ->where('deleted', AccCoaAccount::DELETED_NO)
                        ->first();

                    $transaction = new Transaction();
                    $transaction->paid_type = Transaction::PAID_TYPE_UNPAID;
                    $transaction->transaction_type = Transaction::TRANSACTION_TYPE_WITHDRAW;
                    $transaction->transaction_date = $purchase->purchase_date;
                    $transaction->account_id = $account->id;
                    $transaction->category_id = $account->acc_coa_category_id;
                    $transaction->reference_type = Transaction::REFERENCE_TYPE_ASSET_PRODUCT_PURCHASE;
                    $transaction->reference_id = $id;
                    $transaction->reference_description = "Asset Product Purchase ".$purchase->purchase_order_id;
                    $transaction->net_amount = $purchase->payable_amount;
                    $transaction->total_vat_amount = 0;
                    $transaction->total_amount = $purchase->payable_amount;
                    $transaction->description = "Asset Product Purchase ".$purchase->purchase_order_id;
                    $transaction->note = "Asset Product Purchase ".$purchase->purchase_order_id;
                    $transaction->created_at = Carbon::now();
                    $transaction->created_by = auth()->user()->id;
                    $transaction->updated_at = Carbon::now();
                    $transaction->updated_by = auth()->user()->id;
                    $transaction->save();
                }
            }

        }catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }

        DB::commit();
    }

    public function getAllAssetProducts($request)
    {
        if(isset($request->q) && ($request->q != '') && ($request->q != null)) {
            $search_keyword = $request->q;
        } else {
            $search_keyword = null;
        }
        $data['asset_products'] = AssetProduct::where('deleted', AssetProduct::DELETED_NO)
            ->where(function ($q) use($search_keyword){
                if($search_keyword != null){
                    $q->where('name', 'LIKE', '%'.$search_keyword.'%');
                }
            })
            ->where('status', AssetProduct::STATUS_ACTIVE)
            ->get()
            ->map(function ($item) {
                $itemTax = (object) [
                    'id' => null,
                    'name' => null,
                    'tax_rate' => 0,
                ];
                return [
                    'id' => $item->id,
                    'name' => $item->name,
                    'show_image' => asset($item->show_image),
                    'description' => $item->description,
                    'tax' => $itemTax,
                    'category_name' => $item->category->name,
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

    // investigate

    public function investigateData($purchase_id)
    {
        try {

            $data['purchase'] = AssetProductPurchaseOrder::with('purchaseDetails')
                ->where('id', $purchase_id)
                ->where('deleted', AssetProductPurchaseOrder::DELETED_NO)
                ->first();

            if (!$data['purchase']) {
                throw new \Exception('Purchase Order Not Found');
            }

            return $data;

        }catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function investigateStore($request, $id)
    {
        DB::beginTransaction();
        try {
            $purchase = AssetProductPurchaseOrder::where('id', $id)
                ->where('deleted', AssetProductPurchaseOrder::DELETED_NO)
                ->first();

            if (!$purchase) {
                throw new \Exception('Purchase Order Not Found');
            }
            if (is_array($request->purchase_detail_id) && count($request->purchase_detail_id) > 0) {
                foreach ($request->purchase_detail_id as $key => $value) {

                    $purchaseDetail = AssetProductPurchaseOrderDetails::where('id', $value)
                        ->where('deleted', AssetProductPurchaseOrderDetails::DELETED_NO)
                        ->first();

                    if (!$purchaseDetail) {
                        throw new \Exception('Purchase Details Not Found');
                    }

                    if (!isset($request->is_perfect[$key]) && !isset($request->has_damage[$key]) && !isset($request->has_missing[$key])) {
                        throw new \Exception('Please select at least one option for '. $purchaseDetail->assetProduct->name);
                    }

                    $assetProduct = AssetProduct::where('id', $purchaseDetail->asset_product_id)
                        ->where('deleted', AssetProduct::DELETED_NO)
                        ->first();

                    if (isset($request->is_perfect[$key]) && ($request->is_perfect[$key])) {
                        $requestDamageQty = 0;
                        $requestMissingQty = 0;
                    }else{
                        if (isset($request->has_damage[$key]) && ($request->has_damage[$key])) {
                            $requestDamageQty = $request->damage_qty[$key];
                            if($requestDamageQty <= 0){
                                throw new \Exception('Damage Quantity must be greater than 0 for '. $purchaseDetail->assetProduct->name);
                            }
                        }else{
                            $requestDamageQty = 0;
                        }
                        if (isset($request->has_missing[$key]) && ($request->has_missing[$key])) {
                            $requestMissingQty = $request->missing_qty[$key];
                            if($requestMissingQty <= 0){
                                throw new \Exception('Missing Quantity must be larger than 0 for '. $purchaseDetail->assetProduct->name);
                            }
                        }else{
                            $requestMissingQty = 0;
                        }
                    }

                    $totalDamageMissingQty = $requestDamageQty + $requestMissingQty;

                    if ($totalDamageMissingQty > $purchaseDetail->qty) {
                        throw new \Exception('Damage and Missing Quantity can not be larger than Purchased Quantity');
                    }
                    if ($purchaseDetail->is_perfect == $purchaseDetail::IS_PERFECT_NO &&
                        $purchaseDetail->has_damage == $purchaseDetail::HAS_DAMAGE_NO &&
                        $purchaseDetail->has_missing == $purchaseDetail::HAS_MISSING_NO)
                    {
                        $productAvailableQty = $assetProduct->available_qty + ($purchaseDetail->qty - $requestDamageQty - $requestMissingQty);
                        $purchaseDetailAvailableQty = $purchaseDetail->available_qty + ($purchaseDetail->qty - $requestDamageQty - $requestMissingQty);

                        // inventory product material store
                        $inventoryAssetProductQty = $purchaseDetail->qty - $requestDamageQty - $requestMissingQty;
                        $inventoryAssetProduct = new InventoryAssetProduct();
                        $inventoryAssetProduct->asset_product_category_id = $assetProduct->asset_product_category_id;
                        $inventoryAssetProduct->asset_product_id = $assetProduct->id;
                        $inventoryAssetProduct->type = $inventoryAssetProduct::TYPE_IN;
                        $inventoryAssetProduct->reference_type = $inventoryAssetProduct::REFERENCE_TYPE_ASSET_PRODUCT_PURCHASE;
                        $inventoryAssetProduct->reference_id = $purchaseDetail->id;
                        $inventoryAssetProduct->created_by = auth()->user()->id;
                        $inventoryAssetProduct->created_at = Carbon::now();
                    } else {
                        $productAvailableQty = $assetProduct->available_qty - ($purchaseDetail->qty - $purchaseDetail->damage_qty - $purchaseDetail->missing_qty)
                            + ($purchaseDetail->qty - $requestDamageQty - $requestMissingQty);

                        $purchaseDetailAvailableQty = $purchaseDetail->available_qty - ($purchaseDetail->qty - $purchaseDetail->damage_qty - $purchaseDetail->missing_qty)
                            + ($purchaseDetail->qty - $requestDamageQty - $requestMissingQty);

                        // inventory product material table update
                        $inventoryAssetProduct = InventoryAssetProduct::where('asset_product_id', $purchaseDetail->asset_product_id)
                            ->where('reference_id', $purchaseDetail->id)
                            ->where('type', InventoryAssetProduct::TYPE_IN)
                            ->where('deleted', InventoryAssetProduct::DELETED_NO)
                            ->first();

                        $inventoryAssetProductQty = $inventoryAssetProduct->quantity - ($purchaseDetail->qty - $purchaseDetail->damage_qty - $purchaseDetail->missing_qty)
                            + ($purchaseDetail->qty - $requestDamageQty - $requestMissingQty);
                    }

                    if (isset($request->is_perfect[$key]) && ($request->is_perfect[$key])) {
                        $purchaseDetail->is_perfect = 1;
                        //item perfect do the rest of function
                        $purchaseDetail->has_damage = $purchaseDetail::HAS_DAMAGE_NO;
                        $purchaseDetail->damage_qty = 0;
                        $purchaseDetail->damage_remarks = $request->damage_remarks[$key];

                        $purchaseDetail->has_missing = $purchaseDetail::HAS_MISSING_NO;
                        $purchaseDetail->missing_qty = 0;
                        $purchaseDetail->missing_remarks = $request->missing_remarks[$key];
                    } else {
                        $purchaseDetail->is_perfect = 0;
                        //check if has damage and do the rest of functions
                        if (isset($request->has_damage[$key]) && ($request->has_damage[$key])) {
                            $purchaseDetail->has_damage = $purchaseDetail::HAS_DAMAGE_YES;
                            $purchaseDetail->damage_qty = $request->damage_qty[$key];
                            $purchaseDetail->damage_remarks = $request->damage_remarks[$key];
                        } else {
                            $purchaseDetail->has_damage = $purchaseDetail::HAS_DAMAGE_NO;
                            $purchaseDetail->damage_qty = 0;
                            $purchaseDetail->damage_remarks = $request->damage_remarks[$key];
                        }
                        //check if has missing and do the rest of functions

                        if (isset($request->has_missing[$key]) && ($request->has_missing[$key])) {
                            $purchaseDetail->has_missing = $purchaseDetail::HAS_MISSING_YES;
                            $purchaseDetail->missing_qty = $request->missing_qty[$key];
                            $purchaseDetail->missing_remarks = $request->missing_remarks[$key];

                            $has_missing = 1;
                        } else {
                            $purchaseDetail->has_missing = $purchaseDetail::HAS_MISSING_NO;
                            $purchaseDetail->missing_qty = 0;
                            $purchaseDetail->missing_remarks = $request->missing_remarks[$key];
                            $has_missing = 0;
                        }

                    }

                    //TODO:: need to discuss
                    //$purchaseDetail->available_qty = $purchaseDetailAvailableQty;
                    $purchaseDetail->updated_by = auth()->user()->id;
                    $purchaseDetail->updated_at = Carbon::now();
                    $purchaseDetail->save();

                    $assetProduct->total_purchased_qty = $productAvailableQty;
                    $assetProduct->available_qty = $productAvailableQty;
                    $assetProduct->updated_by = auth()->user()->id;
                    $assetProduct->updated_at = Carbon::now();
                    $assetProduct->save();

                    $inventoryAssetProduct->quantity = $inventoryAssetProductQty;
                    $inventoryAssetProduct->updated_at = Carbon::now();
                    $inventoryAssetProduct->updated_by = auth()->user()->id;
                    $inventoryAssetProduct->save();

                    // delete previous files
                    $unlinkAndDelete = AssetProductPurchaseOrderDamageFile::where('asset_product_purchase_order_detail_id', $value)
                        ->get();
                    if(count($unlinkAndDelete) > 0){
                        foreach($unlinkAndDelete as $unlink){
                            if($unlink->file_path !='' && file_exists(getExactFilePath($unlink->file_path))) {
                                unlink(getExactFilePath($unlink->file_path));
                            }
                            $unlink->delete();
                        }
                    }

                    if(isset($request->file_type_damage) && is_array($request->file_type_damage)) {
                        if(isset($request->file_type_damage[$key]) && is_array($request->file_type_damage[$key])) {
                            foreach($request->file_type_damage[$key] as $fileKey=>$damageFile){
                                if($request->hasFile('file_type_damage.'.$key.'.'.$fileKey)){
                                    $file = $request->file('file_type_damage.'.$key.'.'.$fileKey);
                                    $imageUploadService = new FileUploadService();
                                    $image_path = $imageUploadService->store($file, 'asset-purchase/investigation/');

                                    $damageFileStore = new AssetProductPurchaseOrderDamageFile();
                                    $damageFileStore->asset_product_purchase_order_id = $purchase->id;
                                    $damageFileStore->asset_product_purchase_order_detail_id = $purchaseDetail->id;
                                    $damageFileStore->file_type = AssetProductPurchaseOrderDamageFile::FILE_TYPE_DAMAGE;
                                    $damageFileStore->file_path = $image_path['path']??null;
                                    $damageFileStore->created_by = auth()->user()->id;
                                    $damageFileStore->created_at = Carbon::now();
                                    $damageFileStore->updated_by = auth()->user()->id;
                                    $damageFileStore->updated_at = Carbon::now();
                                    $damageFileStore->save();
                                }
                            }
                        }
                    }

                    if(isset($request->file_type_missing) && is_array($request->file_type_missing)) {
                        if(isset($request->file_type_missing[$key]) && is_array($request->file_type_missing[$key])) {
                            foreach($request->file_type_missing[$key] as $fileKey=>$missingFile){
                                if($request->hasFile('file_type_missing.'.$key.'.'.$fileKey)){
                                    $file = $request->file('file_type_missing.'.$key.'.'.$fileKey);
                                    $imageUploadService = new FileUploadService();
                                    $image_path = $imageUploadService->store($file, 'asset-purchase/investigation/');

                                    $missingFileStore = new AssetProductPurchaseOrderDamageFile();
                                    $missingFileStore->asset_product_purchase_order_id = $purchase->id;
                                    $missingFileStore->asset_product_purchase_order_detail_id = $purchaseDetail->id;
                                    $missingFileStore->file_type = AssetProductPurchaseOrderDamageFile::FILE_TYPE_MISSING;
                                    $missingFileStore->file_path = $image_path['path']??null;
                                    $missingFileStore->created_by = auth()->user()->id;
                                    $missingFileStore->created_at = Carbon::now();
                                    $missingFileStore->updated_by = auth()->user()->id;
                                    $missingFileStore->updated_at = Carbon::now();
                                    $missingFileStore->save();

                                }
                            }
                        }
                    }
                }
            }

            $purchase->purchase_status = $purchase::PURCHASE_STATUS_DELIVERED;
            $purchase->updated_by = auth()->user()->id;
            $purchase->updated_at = Carbon::now();
            $purchase->save();

            // check if any purchase details are has missing
            $checkPurchaseDetailHasMissing = AssetProductPurchaseOrderDetails::where('asset_product_purchase_order_id', $purchase->id)
                ->where('has_missing', AssetProductPurchaseOrderDetails::HAS_MISSING_YES)
                ->where('deleted', AssetProductPurchaseOrderDetails::DELETED_NO)
                ->get();
            if (count($checkPurchaseDetailHasMissing) > 0) {
                $purchase->has_missing = $purchase::HAS_MISSING_YES;
                $purchase->updated_by = auth()->user()->id;
                $purchase->updated_at = Carbon::now();
                $purchase->save();
            }else{
                $purchase->has_missing = $purchase::HAS_MISSING_NO;
                $purchase->updated_by = auth()->user()->id;
                $purchase->updated_at = Carbon::now();
                $purchase->save();
            }

            // check if any purchase details are has damage
            $checkPurchaseDetailHasDamage = AssetProductPurchaseOrderDetails::where('asset_product_purchase_order_id', $purchase->id)
                ->where('has_damage', AssetProductPurchaseOrderDetails::HAS_DAMAGE_YES)
                ->where('deleted', AssetProductPurchaseOrderDetails::DELETED_NO)
                ->get();
            if (count($checkPurchaseDetailHasDamage) > 0) {
                $purchase->has_damage = $purchase::HAS_DAMAGE_YES;
                $purchase->updated_by = auth()->user()->id;
                $purchase->updated_at = Carbon::now();
                $purchase->save();
            }else{
                $purchase->has_damage = $purchase::HAS_DAMAGE_NO;
                $purchase->updated_by = auth()->user()->id;
                $purchase->updated_at = Carbon::now();
                $purchase->save();
            }
        }catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
        DB::commit();
        return $purchase;
    }
}
