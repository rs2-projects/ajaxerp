<?php

namespace App\Services\Procurement\Assets\PurchaseOrder;

use App\Models\Accounting\AccCoaAccount;
use App\Models\Accounting\AccCoaSubCategory;
use App\Models\Accounting\Transaction;
use App\Models\Procurements\AssetProductPurchaseOrder;
use App\Models\Procurements\AssetProductPurchaseOrderDetails;
use App\Models\Procurements\AssetProductPurchaseRequestDetails;
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
                    if($tax_id != null){
                        $tax = AccCoaAccount::where('status', AccCoaAccount::STATUS_ACTIVE)
                            ->where('deleted', AccCoaAccount::DELETED_NO)
                            ->where('id', $tax_id)
                            ->first();
                        if(!empty($tax)){
                            $tax_rate = $tax->tax_rate;
                            $tax_amount = $amount_without_tax * $tax_rate / 100;
                            $amount_with_tax = $amount_without_tax + $tax_amount;
                        }
                    }

                    $purchaseDetails = new AssetProductPurchaseOrderDetails();
                    $purchaseDetails->asset_product_purchase_order_id = $purchase->id;
                    $purchaseDetails->asset_product_id = $product;
                    $purchaseDetails->asset_product_purchase_request_id = $request->asset_product_purchase_request_id[$key]??null;
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
}
