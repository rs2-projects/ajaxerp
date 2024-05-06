<?php

namespace App\Services\Procurement\ProductMaterial;

use App\Models\Accounting\AccCoaAccount;
use App\Models\Accounting\AccCoaSubCategory;
use App\Models\Accounting\Transaction;
use App\Models\Accounting\TransactionVat;
use App\Models\Procurements\ProductMaterialPurchase;
use App\Models\Procurements\ProductMaterialPurchaseDetails;
use App\Models\Procurements\Supplier;
use App\Models\Products\ProductMaterial;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ProductMaterialPurchaseService
{

    public function __construct()
    {
        $this->paginate_limit = config('commonData.paginate_limit');
    }

    public function indexData()
    {
        $data['months'] = config('commonData.month_names');

        return $data;
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
            case 'revised_purchase':
                return $this->getRevisedPurchaseOrders($request);
                break;
            case 'back_purchase':
                return $this->getBackPurchaseOrders($request);
                break;
            case 'has_revised_purchase':
                return $this->getHasRevisedPurchaseOrders($request);
                break;
            case 'has_backed_purchase':
                return $this->getHasBackedPurchaseOrders($request);
                break;

        }
    }

    public function detailsData($id)
    {
        $data['purchase'] = ProductMaterialPurchase::with('supplier','purchaseDetails')
            ->where('id', $id)
            ->where('deleted', 0)
            ->first();
        if (empty($data['purchase'])) {
            throw new \Exception("Invalid Purchase Order!");
        }

        return $data;
    }

    public function getAllPurchaseOrders($request)
    {
        $keyword_filtered = $request->keyword_filtered??null;
        $start_date_filtered = $request->start_date_filtered??null;
        $end_date_filtered = $request->end_date_filtered??null;


        $data['purchase_orders'] = ProductMaterialPurchase::with('supplier','purchaseDetails')
            ->where('deleted', ProductMaterialPurchase::DELETED_NO)
            ->where(function ($q) use($keyword_filtered){
                if($keyword_filtered != null){
                    $q->where('purchase_id', 'LIKE', '%'.$keyword_filtered.'%');
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

        $data['view'] = view('procurement.product-material-purchase._index_filtered', $data)->render();

        return $data;
    }

    public function getNewPurchaseOrders($request)
    {
        $keyword_filtered = $request->keyword_filtered;
        $start_date_filtered = $request->start_date_filtered??null;
        $end_date_filtered = $request->end_date_filtered??null;

        $data['purchase_orders'] = ProductMaterialPurchase::with('supplier','purchaseDetails')
            ->where('purchase_status', ProductMaterialPurchase::PURCHASE_STATUS_NEW)
            ->where('purchase_create_type', ProductMaterialPurchase::PURCHASE_CREATE_TYPE_NEW)
            ->where('deleted', ProductMaterialPurchase::DELETED_NO)
            ->where(function ($q) use($keyword_filtered){
                if($keyword_filtered != null){
                    $q->where('purchase_id', 'LIKE', '%'.$keyword_filtered.'%');
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

        $data['view'] = view('procurement.product-material-purchase._new_index_filtered', $data)->render();

        return $data;
    }

    public function getOnProcessPurchaseOrders($request)
    {
        $keyword_filtered = $request->keyword_filtered;
        $start_date_filtered = $request->start_date_filtered??null;
        $end_date_filtered = $request->end_date_filtered??null;

        $data['purchase_orders'] = ProductMaterialPurchase::with('supplier','purchaseDetails')
            ->where('purchase_status', ProductMaterialPurchase::PURCHASE_STATUS_ON_PROCESS)
            ->where('deleted', ProductMaterialPurchase::DELETED_NO)
            ->where(function ($q) use($keyword_filtered){
                if($keyword_filtered != null){
                    $q->where('purchase_id', 'LIKE', '%'.$keyword_filtered.'%');
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

        $data['view'] = view('procurement.product-material-purchase._on_process_index_filtered', $data)->render();

        return $data;
    }

    public function getDeliveredPurchaseOrders($request)
    {
        $keyword_filtered = $request->keyword_filtered;
        $start_date_filtered = $request->start_date_filtered??null;
        $end_date_filtered = $request->end_date_filtered??null;

        $data['purchase_orders'] = ProductMaterialPurchase::with('supplier','purchaseDetails')
            ->where('purchase_status', ProductMaterialPurchase::PURCHASE_STATUS_DELIVERED)
            ->where('deleted', ProductMaterialPurchase::DELETED_NO)
            ->where(function ($q) use($keyword_filtered){
                if($keyword_filtered != null){
                    $q->where('purchase_id', 'LIKE', '%'.$keyword_filtered.'%');
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

        $data['view'] = view('procurement.product-material-purchase._delivered_index_filtered', $data)->render();

        return $data;
    }

    public function getRevisedPurchaseOrders($request)
    {
        $keyword_filtered = $request->keyword_filtered;
        $start_date_filtered = $request->start_date_filtered??null;
        $end_date_filtered = $request->end_date_filtered??null;

        $data['purchase_orders'] = ProductMaterialPurchase::with('supplier','purchaseDetails')
            ->where('purchase_status', ProductMaterialPurchase::PURCHASE_STATUS_NEW)
            ->where('purchase_create_type', ProductMaterialPurchase::PURCHASE_CREATE_TYPE_REVISED)
            ->where('deleted', ProductMaterialPurchase::DELETED_NO)
            ->where(function ($q) use($keyword_filtered){
                if($keyword_filtered != null){
                    $q->where('purchase_id', 'LIKE', '%'.$keyword_filtered.'%');
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

        $data['view'] = view('procurement.product-material-purchase._revised_index_filtered', $data)->render();

        return $data;
    }

    public function getBackPurchaseOrders($request)
    {
        $keyword_filtered = $request->keyword_filtered;
        $start_date_filtered = $request->start_date_filtered??null;
        $end_date_filtered = $request->end_date_filtered??null;

        $data['purchase_orders'] = ProductMaterialPurchase::with('supplier','purchaseDetails')
            ->where('purchase_status', ProductMaterialPurchase::PURCHASE_STATUS_NEW)
            ->where('purchase_create_type', ProductMaterialPurchase::PURCHASE_CREATE_TYPE_BACKED)
            ->where('deleted', ProductMaterialPurchase::DELETED_NO)
            ->where(function ($q) use($keyword_filtered){
                if($keyword_filtered != null){
                    $q->where('purchase_id', 'LIKE', '%'.$keyword_filtered.'%');
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

        $data['view'] = view('procurement.product-material-purchase._back_index_filtered', $data)->render();

        return $data;
    }

    public function getHasRevisedPurchaseOrders($request)
    {
        $keyword_filtered = $request->keyword_filtered;
        $start_date_filtered = $request->start_date_filtered??null;
        $end_date_filtered = $request->end_date_filtered??null;

        $data['purchase_orders'] = ProductMaterialPurchase::with('supplier','purchaseDetails')
            ->where('purchase_status', ProductMaterialPurchase::PURCHASE_STATUS_REVISED_OR_BACKED)
            ->where('is_revised', ProductMaterialPurchase::IS_REVISED_YES)
            ->where('deleted', ProductMaterialPurchase::DELETED_NO)
            ->where(function ($q) use($keyword_filtered){
                if($keyword_filtered != null){
                    $q->where('purchase_id', 'LIKE', '%'.$keyword_filtered.'%');
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

        $data['view'] = view('procurement.product-material-purchase._has_revised_index_filtered', $data)->render();

        return $data;
    }

    public function getHasBackedPurchaseOrders($request)
    {
        $keyword_filtered = $request->keyword_filtered;
        $start_date_filtered = $request->start_date_filtered??null;
        $end_date_filtered = $request->end_date_filtered??null;

        $data['purchase_orders'] = ProductMaterialPurchase::with('supplier','purchaseDetails')
            ->where('purchase_status', ProductMaterialPurchase::PURCHASE_STATUS_REVISED_OR_BACKED)
            ->where('is_backed', ProductMaterialPurchase::IS_BACKED_YES)
            ->where('deleted', ProductMaterialPurchase::DELETED_NO)
            ->where(function ($q) use($keyword_filtered){
                if($keyword_filtered != null){
                    $q->where('purchase_id', 'LIKE', '%'.$keyword_filtered.'%');
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

        $data['view'] = view('procurement.product-material-purchase._has_backed_index_filtered', $data)->render();

        return $data;
    }

    public function createData()
    {
        $data['purchaseDate'] = Carbon::now();
        $data['estimatedDeliveryDate'] = Carbon::now();

        return $data;

    }

    public function store($request)
    {
        DB::beginTransaction();
        try {

            $checkBatchNumber = ProductMaterialPurchase::where('batch_number', $request->batch_number)
                ->where('deleted', ProductMaterialPurchase::DELETED_NO)
                ->first();
            if (!empty($checkBatchNumber)) {
                throw new \Exception("Batch Number already exists");
            }

            $purchase = new ProductMaterialPurchase();
            $purchase->purchase_create_type = ProductMaterialPurchase::PURCHASE_CREATE_TYPE_NEW;
            $purchase->supplier_id = $request->supplier_id;
            $purchase->batch_number = $request->batch_number;
            $purchase->purchase_date = $request->purchase_date;
            $purchase->discount_type = $request->discount_type;
            $purchase->discount_value = $request->discount_value;
            $purchase->estimated_delivery_date = $request->estimated_delivery_date;
            $purchase->php_rate = $request->php_rate;
            $purchase->payment_status = ProductMaterialPurchase::PAYMENT_STATUS_UNPAID;
            $purchase->purchase_status = ProductMaterialPurchase::PURCHASE_STATUS_NEW;
            $purchase->is_revised = ProductMaterialPurchase::IS_REVISED_NO;
            $purchase->is_backed = ProductMaterialPurchase::IS_BACKED_NO;
            $purchase->notes = $request->notes;
            $purchase->invoice_footer = $request->invoice_footer;
            $purchase->created_at = Carbon::now();
            $purchase->created_by = auth()->user()->id;
            $purchase->updated_at = Carbon::now();
            $purchase->updated_by = auth()->user()->id;
            $purchase->save();
            $purchase->purchase_id = "PO - ".(1000 + $purchase->id);
            $purchase->save();


            $subtotal_amount = 0;
            $total_vat_amount = 0;

            $has_boards = 0;
            $has_others = 0;

            if(isset($request->product_id) && is_array($request->product_id)){
                foreach ($request->product_id as $key=>$product){
                    $productMaterial = ProductMaterial::where('status', ProductMaterial::STATUS_ACTIVE)
                        ->where('deleted', ProductMaterial::DELETED_NO)
                        ->where('id', $product)
                        ->first();

                    if(empty($productMaterial)){
                        continue;
                    }
                    if ($productMaterial->type == ProductMaterial::TYPE_BOARD) {
                        $has_boards = 1;
                    } else {
                        $has_others = 1;
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
                        } else {
                            $tax_id = null;
                        }
                    } else {
                        $tax_id = null;
                    }

                    $purchaseDetails = new ProductMaterialPurchaseDetails();
                    $purchaseDetails->product_material_purchase_id = $purchase->id;
                    $purchaseDetails->product_material_id = $product;
                    $purchaseDetails->product_type = $productMaterial->type;
                    $purchaseDetails->description = $request->description[$key];
                    $purchaseDetails->color = $request->color[$key];
                    $purchaseDetails->qty = $qty;
                    $purchaseDetails->unit_price = $price;
                    $purchaseDetails->unit_price_php = $price * $request->php_rate;
                    $total_price = $qty * $price;
                    $purchaseDetails->total_price = $total_price;
                    $purchaseDetails->total_price_php = $total_price * $request->php_rate;
                    $purchaseDetails->tax_id = $tax_id;
                    $purchaseDetails->tax_rate = $tax_rate;
                    $purchaseDetails->tax_amount = $tax_amount;
                    $purchaseDetails->tax_amount_php = $tax_amount * $request->php_rate;
                    $purchaseDetails->net_total = $amount_with_tax;
                    $purchaseDetails->net_total_php = $amount_with_tax * $request->php_rate;
                    $purchaseDetails->is_perfect = ProductMaterialPurchaseDetails::IS_PERFECT_NO;
                    $purchaseDetails->has_damage = ProductMaterialPurchaseDetails::HAS_DAMAGE_NO;
                    $purchaseDetails->has_missing = ProductMaterialPurchaseDetails::HAS_MISSING_NO;
                    $purchaseDetails->created_at = Carbon::now();
                    $purchaseDetails->created_by = auth()->user()->id;
                    $purchaseDetails->updated_at = Carbon::now();
                    $purchaseDetails->updated_by = auth()->user()->id;
                    $purchaseDetails->save();

                    $subtotal_amount += $purchaseDetails->total_price;
                    $total_vat_amount += $purchaseDetails->tax_amount;

                }
            }
            $total_discount_amount = 0;
            $total_discount_amount_php = 0;
            $php_rate = $request->php_rate;

            if($purchase->discount_type == ProductMaterialPurchase::DISCOUNT_TYPE_PERCENTAGE){
                $total_amt = $subtotal_amount + $total_vat_amount;
                $total_discount_amount = ($total_amt * $purchase->discount_value) / 100;
                $total_discount_amount_php = $total_discount_amount * $php_rate;
            }else{
                $total_discount_amount = $purchase->discount_value;
                $total_discount_amount_php = $purchase->discount_value * $php_rate;
            }

            $purchase->subtotal_amount = $subtotal_amount;
            $purchase->total_vat_amount = $total_vat_amount;
            $purchase->total_discount_amount = $total_discount_amount;
            $purchase->payable_amount = $subtotal_amount + $total_vat_amount - $total_discount_amount;
            $purchase->due_amount = $subtotal_amount + $total_vat_amount - $total_discount_amount;

            $subtotal_amount_php = $subtotal_amount * $php_rate;
            $total_vat_amount_php = $total_vat_amount * $php_rate;

            $purchase->subtotal_amount_php = $subtotal_amount_php;
            $purchase->total_vat_amount_php = $total_vat_amount_php;
            $purchase->total_discount_amount_php = $total_discount_amount_php;
            $purchase->payable_amount_php = ($subtotal_amount_php + $total_vat_amount_php) - $total_discount_amount_php;
            $purchase->due_amount_php = ($subtotal_amount_php + $total_vat_amount_php) - $total_discount_amount_php;

            $purchase->has_boards = $has_boards;
            $purchase->has_others = $has_others;
            $purchase->save();


        }catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
        DB::commit();
    }

    public function editData($id)
    {
        $data['purchase'] = ProductMaterialPurchase::where('id', $id)
            ->where('deleted', 0)
            ->first();
        if (empty($data['purchase'])) {
            return redirect()->back()->with(['failed' => 'Invalid Purchase Order!']);
        }

        return $data;
    }

    public function getEditPurchaseData($request,$id)
    {
        $purchase = ProductMaterialPurchase::where('id', $id)
            ->where('deleted', 0)
            ->first();

        $supplier = Supplier::where('id', $purchase->supplier_id)
            ->where('status', 1)
            ->where('deleted', 0)
            ->first();
        $supplier->show_image_full_url = asset($supplier->show_image);
        $supplier->contact_full_name = $supplier->full_name;
        $supplier->full_address = $supplier->getFullAddressText();

        $cartItems = ProductMaterialPurchaseDetails::with('productMaterial', 'tax')
            ->where('product_material_purchase_id', $id)
            ->where('deleted', ProductMaterialPurchaseDetails::DELETED_NO)
            ->get()
            ->map(function ($item){
                if($item->tax == null) {
                    $itemTax = (object) [
                        'id' => null,
                        'name' => null,
                        'tax_rate' => 0,
                    ];
                } else {
                    $itemTax = $item->tax;
                }
                return [
                    'id' => $item->productMaterial->id,
                    'name' => $item->productMaterial->name,
                    'code' => $item->productMaterial->code,
                    'show_image' => asset($item->productMaterial->show_image),
                    'unit_type' => $item->productMaterial::UNIT_TYPES[$item->productMaterial->unit_type], // 'unit_type' => 'Unit',
                    'length' => $item->productMaterial->length,
                    'width' => $item->productMaterial->width,
                    'thickness' => $item->productMaterial->thickness,
                    'description' => $item->description,
                    'color' => $item->color,
                    'qty' => $item->qty,
                    'price' => $item->unit_price,
                    'unit_price' => $item->unit_price,
                    'total_price' => $item->total_price,
                    'tax' => $itemTax,
                    'is_perfect' => $item->is_perfect,
                    'has_damage' => $item->has_damage,
                    'damage_qty' => $item->damage_qty,
                    'damage_remarks' => $item->damage_remarks,
                    'has_missing' => $item->has_missing,
                    'missing_qty' => $item->missing_qty,
                    'missing_remarks' => $item->missing_remarks,
                ];
            });

        /*$data['purchase'] = $purchase;*/
        $data['supplier'] = $supplier;
        $data['cartItems'] = $cartItems;

        return $data;
    }

    public function update($request, $id)
    {
        DB::beginTransaction();
        try {

            $purchase = ProductMaterialPurchase::where('id', $id)
                ->where('deleted', ProductMaterialPurchase::DELETED_NO)
                ->first();

            if(empty($purchase)){
                throw new \Exception("Purchase Order Not Found");
            }

            $checkBatchNumber = ProductMaterialPurchase::where('batch_number', $request->batch_number)
                ->where('id', '!=', $id)
                ->where('deleted', ProductMaterialPurchase::DELETED_NO)
                ->first();

            if (!empty($checkBatchNumber)) {
                throw new \Exception("Batch Number already exists");
            }

            $purchase->supplier_id = $request->supplier_id;
            $purchase->php_rate = $request->php_rate;
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

            if (isset($request->product_id) && is_array($request->product_id)) {
                $product_ids = $request->product_id??[];
                $delete_not_exist_product = ProductMaterialPurchaseDetails::where('product_material_purchase_id', $purchase->id)
                    ->whereNotIn('product_material_id', $product_ids)
                    ->where('deleted', ProductMaterialPurchaseDetails::DELETED_NO)
                    ->delete();
            }

            $subtotal_amount = 0;
            $total_vat_amount = 0;

            if(isset($request->product_id) && is_array($request->product_id)){
                foreach ($request->product_id as $key=>$product){
                    $productMaterial = ProductMaterial::where('status', ProductMaterial::STATUS_ACTIVE)
                        ->where('deleted', ProductMaterial::DELETED_NO)
                        ->where('id', $product)
                        ->first();

                    if(empty($productMaterial)){
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
                        } else {
                            $tax_id = null;
                        }
                    } else {
                        $tax_id = null;
                    }

                    $purchaseDetails = ProductMaterialPurchaseDetails::where('product_material_purchase_id', $purchase->id)
                        ->where('product_material_id', $product)
                        ->where('deleted', ProductMaterialPurchaseDetails::DELETED_NO)
                        ->first();
                    if(empty($purchaseDetails)){
                        $purchaseDetails = new ProductMaterialPurchaseDetails();
                        $purchaseDetails->product_material_purchase_id = $purchase->id;
                        $purchaseDetails->product_material_id = $product;
                        $purchaseDetails->created_at = Carbon::now();
                        $purchaseDetails->created_by = auth()->user()->id;
                    }
                    $purchaseDetails->description = $request->description[$key];
                    $purchaseDetails->color = $request->color[$key];
                    $purchaseDetails->qty = $qty;
                    $purchaseDetails->unit_price = $price;
                    $purchaseDetails->unit_price_php = $price * $request->php_rate;
                    $total_price = $qty * $price;
                    $purchaseDetails->total_price = $total_price;
                    $purchaseDetails->total_price_php = $total_price * $request->php_rate;
                    $purchaseDetails->tax_id = $tax_id;
                    $purchaseDetails->tax_rate = $tax_rate;
                    $purchaseDetails->tax_amount = $tax_amount;
                    $purchaseDetails->tax_amount_php = $tax_amount * $request->php_rate;
                    $purchaseDetails->net_total = $amount_with_tax;
                    $purchaseDetails->net_total_php = $amount_with_tax * $request->php_rate;
                    /*$purchaseDetails->is_perfect = ProductMaterialPurchaseDetails::IS_PERFECT_NO;
                    $purchaseDetails->has_damage = ProductMaterialPurchaseDetails::HAS_DAMAGE_NO;
                    $purchaseDetails->has_missing = ProductMaterialPurchaseDetails::HAS_MISSING_NO;*/
                    $purchaseDetails->updated_at = Carbon::now();
                    $purchaseDetails->updated_by = auth()->user()->id;
                    $purchaseDetails->save();

                    $subtotal_amount += $purchaseDetails->total_price;
                    $total_vat_amount += $purchaseDetails->tax_amount;

                }
            }

            $total_discount_amount = 0;
            $total_discount_amount_php = 0;
            $php_rate = $request->php_rate;

            if($purchase->discount_type == ProductMaterialPurchase::DISCOUNT_TYPE_PERCENTAGE){
                $total_amt = $subtotal_amount + $total_vat_amount;
                $total_discount_amount = ($total_amt * $purchase->discount_value) / 100;
                $total_discount_amount_php = $total_discount_amount * $php_rate;
            }else{
                $total_discount_amount = $purchase->discount_value;
                $total_discount_amount_php = $purchase->discount_value * $php_rate;
            }

            $purchase->subtotal_amount = $subtotal_amount;
            $purchase->total_vat_amount = $total_vat_amount;
            $purchase->total_discount_amount = $total_discount_amount;
            $purchase->payable_amount = $subtotal_amount + $total_vat_amount - $total_discount_amount;
            $purchase->due_amount = $subtotal_amount + $total_vat_amount - $total_discount_amount;

            $subtotal_amount_php = $subtotal_amount * $php_rate;
            $total_vat_amount_php = $total_vat_amount * $php_rate;

            $purchase->subtotal_amount_php = $subtotal_amount_php;
            $purchase->total_vat_amount_php = $total_vat_amount_php;
            $purchase->total_discount_amount_php = $total_discount_amount_php;
            $purchase->payable_amount_php = ($subtotal_amount_php + $total_vat_amount_php) - $total_discount_amount_php;
            $purchase->due_amount_php = ($subtotal_amount_php + $total_vat_amount_php) - $total_discount_amount_php;
            $purchase->save();


        }catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
        DB::commit();
    }

    public function createRevisedOrderData($id)
    {
        $data['purchase'] = ProductMaterialPurchase::where('id', $id)
            ->where('deleted', 0)
            ->first();
        if (empty($data['purchase'])) {
            return redirect()->back()->with(['failed' => 'Invalid Purchase Order!']);
        }

        return $data;
    }

    public function storeRevisedOrderData($request, $id)
    {

        DB::beginTransaction();
        try {

            $parentPurchase = ProductMaterialPurchase::where('id', $id)
                ->where('deleted', ProductMaterialPurchase::DELETED_NO)
                ->first();
            if (empty($parentPurchase)) {
                throw new \Exception("Purchase Order Not Found");
            }

            $checkBatchNumber = ProductMaterialPurchase::where('batch_number', $request->batch_number)
                ->where('deleted', ProductMaterialPurchase::DELETED_NO)
                ->first();
            if (!empty($checkBatchNumber)) {
                throw new \Exception("Batch Number already exists");
            }

            $purchase = new ProductMaterialPurchase();
            $purchase->purchase_create_type = ProductMaterialPurchase::PURCHASE_CREATE_TYPE_REVISED;
            $purchase->php_rate = $request->php_rate;
            $purchase->purchase_create_prev_id = $parentPurchase->id;
            $purchase->supplier_id = $request->supplier_id;
            $purchase->batch_number = $request->batch_number;
            $purchase->purchase_date = $request->purchase_date;
            $purchase->discount_type = $request->discount_type;
            $purchase->discount_value = $request->discount_value;
            $purchase->estimated_delivery_date = $request->estimated_delivery_date;
            $purchase->payment_status = ProductMaterialPurchase::PAYMENT_STATUS_UNPAID;
            $purchase->purchase_status = ProductMaterialPurchase::PURCHASE_STATUS_NEW;
            $purchase->is_revised = ProductMaterialPurchase::IS_REVISED_NO;
            $purchase->is_backed = ProductMaterialPurchase::IS_BACKED_NO;
            $purchase->notes = $request->notes;
            $purchase->invoice_footer = $request->invoice_footer;
            $purchase->created_at = Carbon::now();
            $purchase->created_by = auth()->user()->id;
            $purchase->updated_at = Carbon::now();
            $purchase->updated_by = auth()->user()->id;
            $purchase->save();
            $purchase->purchase_id = "RPO - ".(1000 + $purchase->id);
            $purchase->save();


            $subtotal_amount = 0;
            $total_vat_amount = 0;

            if(isset($request->product_id) && is_array($request->product_id)){
                foreach ($request->product_id as $key=>$product){
                    $productMaterial = ProductMaterial::where('status', ProductMaterial::STATUS_ACTIVE)
                        ->where('deleted', ProductMaterial::DELETED_NO)
                        ->where('id', $product)
                        ->first();

                    if(empty($productMaterial)){
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
                        } else {
                            $tax_id = null;
                        }
                    } else {
                        $tax_id = null;
                    }

                    $purchaseDetails = new ProductMaterialPurchaseDetails();
                    $purchaseDetails->product_material_purchase_id = $purchase->id;
                    $purchaseDetails->product_material_id = $product;
                    $purchaseDetails->description = $request->description[$key];
                    $purchaseDetails->color = $request->color[$key];
                    $purchaseDetails->qty = $qty;
                    $purchaseDetails->unit_price = $price;
                    $purchaseDetails->unit_price_php = $price * $request->php_rate;
                    $total_price = $qty * $price;
                    $purchaseDetails->total_price = $total_price;
                    $purchaseDetails->total_price_php = $total_price * $request->php_rate;
                    $purchaseDetails->tax_id = $tax_id;
                    $purchaseDetails->tax_rate = $tax_rate;
                    $purchaseDetails->tax_amount = $tax_amount;
                    $purchaseDetails->tax_amount_php = $tax_amount * $request->php_rate;
                    $purchaseDetails->net_total = $amount_with_tax;
                    $purchaseDetails->net_total_php = $amount_with_tax * $request->php_rate;
                    $purchaseDetails->is_perfect = ProductMaterialPurchaseDetails::IS_PERFECT_NO;
                    $purchaseDetails->has_damage = ProductMaterialPurchaseDetails::HAS_DAMAGE_NO;
                    $purchaseDetails->has_missing = ProductMaterialPurchaseDetails::HAS_MISSING_NO;
                    $purchaseDetails->created_at = Carbon::now();
                    $purchaseDetails->created_by = auth()->user()->id;
                    $purchaseDetails->updated_at = Carbon::now();
                    $purchaseDetails->updated_by = auth()->user()->id;
                    $purchaseDetails->save();

                    $subtotal_amount += $purchaseDetails->total_price;
                    $total_vat_amount += $purchaseDetails->tax_amount;

                }
            }

            $total_discount_amount = 0;
            $total_discount_amount_php = 0;
            $php_rate = $request->php_rate;

            if($purchase->discount_type == ProductMaterialPurchase::DISCOUNT_TYPE_PERCENTAGE){
                $total_amt = $subtotal_amount + $total_vat_amount;
                $total_discount_amount = ($total_amt * $purchase->discount_value) / 100;
                $total_discount_amount_php = $total_discount_amount * $php_rate;
            }else{
                $total_discount_amount = $purchase->discount_value;
                $total_discount_amount_php = $purchase->discount_value * $php_rate;
            }

            $purchase->subtotal_amount = $subtotal_amount;
            $purchase->total_vat_amount = $total_vat_amount;
            $purchase->total_discount_amount = $total_discount_amount;
            $purchase->payable_amount = $subtotal_amount + $total_vat_amount - $total_discount_amount;
            $purchase->due_amount = $subtotal_amount + $total_vat_amount - $total_discount_amount;
            
            $subtotal_amount_php = $subtotal_amount * $php_rate;
            $total_vat_amount_php = $total_vat_amount * $php_rate;

            $purchase->subtotal_amount_php = $subtotal_amount_php;
            $purchase->total_vat_amount_php = $total_vat_amount_php;
            $purchase->total_discount_amount_php = $total_discount_amount_php;
            $purchase->payable_amount_php = ($subtotal_amount_php + $total_vat_amount_php) - $total_discount_amount_php;
            $purchase->due_amount_php = ($subtotal_amount_php + $total_vat_amount_php) - $total_discount_amount_php;
            $purchase->save();

            $parentPurchase->purchase_status = $parentPurchase::PURCHASE_STATUS_REVISED_OR_BACKED;
            $parentPurchase->is_revised = $parentPurchase::IS_REVISED_YES;
            $parentPurchase->revised_by = auth()->user()->id;
            $parentPurchase->revised_at = Carbon::now();
            $parentPurchase->updated_at = Carbon::now();
            $parentPurchase->updated_by = auth()->user()->id;
            $parentPurchase->save();


        }catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
        DB::commit();
    }

    public function createBackOrderData($id)
    {
        $data['purchase'] = ProductMaterialPurchase::where('id', $id)
            ->where('deleted', 0)
            ->first();
        if (empty($data['purchase'])) {
            return redirect()->back()->with(['failed' => 'Invalid Purchase Order!']);
        }

        return $data;
    }

    public function storeBackOrderData($request, $id)
    {

        DB::beginTransaction();
        try {

            $parentPurchase = ProductMaterialPurchase::where('id', $id)
                ->where('deleted', ProductMaterialPurchase::DELETED_NO)
                ->first();
            if (empty($parentPurchase)) {
                throw new \Exception("Purchase Order Not Found");
            }

            $checkBatchNumber = ProductMaterialPurchase::where('batch_number', $request->batch_number)
                ->where('deleted', ProductMaterialPurchase::DELETED_NO)
                ->first();
            if (!empty($checkBatchNumber)) {
                throw new \Exception("Batch Number already exists");
            }

            $purchase = new ProductMaterialPurchase();
            $purchase->purchase_create_type = ProductMaterialPurchase::PURCHASE_CREATE_TYPE_BACKED;
            $purchase->php_rate = $request->php_rate;
            $purchase->purchase_create_prev_id = $parentPurchase->id;
            $purchase->supplier_id = $request->supplier_id;
            $purchase->batch_number = $request->batch_number;
            $purchase->purchase_date = $request->purchase_date;
            $purchase->discount_type = $request->discount_type;
            $purchase->discount_value = $request->discount_value;
            $purchase->estimated_delivery_date = $request->estimated_delivery_date;
            $purchase->payment_status = ProductMaterialPurchase::PAYMENT_STATUS_UNPAID;
            $purchase->purchase_status = ProductMaterialPurchase::PURCHASE_STATUS_NEW;
            $purchase->is_revised = ProductMaterialPurchase::IS_REVISED_NO;
            $purchase->is_backed = ProductMaterialPurchase::IS_BACKED_NO;
            $purchase->notes = $request->notes;
            $purchase->invoice_footer = $request->invoice_footer;
            $purchase->created_at = Carbon::now();
            $purchase->created_by = auth()->user()->id;
            $purchase->updated_at = Carbon::now();
            $purchase->updated_by = auth()->user()->id;
            $purchase->save();
            $purchase->purchase_id = "BPO - ".(1000 + $purchase->id);
            $purchase->save();


            $subtotal_amount = 0;
            $total_vat_amount = 0;

            if(isset($request->product_id) && is_array($request->product_id)){
                foreach ($request->product_id as $key=>$product){
                    $productMaterial = ProductMaterial::where('status', ProductMaterial::STATUS_ACTIVE)
                        ->where('deleted', ProductMaterial::DELETED_NO)
                        ->where('id', $product)
                        ->first();

                    if(empty($productMaterial)){
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
                        } else {
                            $tax_id = null;
                        }
                    } else {
                        $tax_id = null;
                    }

                    $purchaseDetails = new ProductMaterialPurchaseDetails();
                    $purchaseDetails->product_material_purchase_id = $purchase->id;
                    $purchaseDetails->product_material_id = $product;
                    $purchaseDetails->description = $request->description[$key];
                    $purchaseDetails->color = $request->color[$key];
                    $purchaseDetails->qty = $qty;
                    $purchaseDetails->unit_price = $price;
                    $purchaseDetails->unit_price_php = $price * $request->php_rate;
                    $total_price = $qty * $price;
                    $purchaseDetails->total_price = $total_price;
                    $purchaseDetails->total_price_php = $total_price * $request->php_rate;
                    $purchaseDetails->tax_id = $tax_id;
                    $purchaseDetails->tax_rate = $tax_rate;
                    $purchaseDetails->tax_amount = $tax_amount;
                    $purchaseDetails->tax_amount_php = $tax_amount * $request->php_rate;
                    $purchaseDetails->net_total = $amount_with_tax;
                    $purchaseDetails->net_total_php = $amount_with_tax * $request->php_rate;
                    $purchaseDetails->is_perfect = ProductMaterialPurchaseDetails::IS_PERFECT_NO;
                    $purchaseDetails->has_damage = ProductMaterialPurchaseDetails::HAS_DAMAGE_NO;
                    $purchaseDetails->has_missing = ProductMaterialPurchaseDetails::HAS_MISSING_NO;
                    $purchaseDetails->created_at = Carbon::now();
                    $purchaseDetails->created_by = auth()->user()->id;
                    $purchaseDetails->updated_at = Carbon::now();
                    $purchaseDetails->updated_by = auth()->user()->id;
                    $purchaseDetails->save();

                    $subtotal_amount += $purchaseDetails->total_price;
                    $total_vat_amount += $purchaseDetails->tax_amount;

                }
            }
            $total_discount_amount = 0;
            $total_discount_amount_php = 0;
            $php_rate = $request->php_rate;

            if($purchase->discount_type == ProductMaterialPurchase::DISCOUNT_TYPE_PERCENTAGE){
                $total_amt = $subtotal_amount + $total_vat_amount;
                $total_discount_amount = ($total_amt * $purchase->discount_value) / 100;
                $total_discount_amount_php = $total_discount_amount * $php_rate;
            }else{
                $total_discount_amount = $purchase->discount_value;
                $total_discount_amount_php = $purchase->discount_value * $php_rate;
            }

            $purchase->subtotal_amount = $subtotal_amount;
            $purchase->total_vat_amount = $total_vat_amount;
            $purchase->total_discount_amount = $total_discount_amount;
            $purchase->payable_amount = $subtotal_amount + $total_vat_amount - $total_discount_amount;
            $purchase->due_amount = $subtotal_amount + $total_vat_amount - $total_discount_amount;
            
            $subtotal_amount_php = $subtotal_amount * $php_rate;
            $total_vat_amount_php = $total_vat_amount * $php_rate;

            $purchase->subtotal_amount_php = $subtotal_amount_php;
            $purchase->total_vat_amount_php = $total_vat_amount_php;
            $purchase->total_discount_amount_php = $total_discount_amount_php;
            $purchase->payable_amount_php = ($subtotal_amount_php + $total_vat_amount_php) - $total_discount_amount_php;
            $purchase->due_amount_php = ($subtotal_amount_php + $total_vat_amount_php) - $total_discount_amount_php;
            $purchase->save();

            $parentPurchase->purchase_status = $parentPurchase::PURCHASE_STATUS_REVISED_OR_BACKED;
            $parentPurchase->is_backed = $parentPurchase::IS_BACKED_YES;
            $parentPurchase->backed_by = auth()->user()->id;
            $parentPurchase->backed_at = Carbon::now();
            $parentPurchase->updated_at = Carbon::now();
            $parentPurchase->updated_by = auth()->user()->id;
            $parentPurchase->save();


        }catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
        DB::commit();
    }

    public function deleteData($id)
    {
        try {

            $purchase = ProductMaterialPurchase::where('id', $id)
                ->where('deleted', ProductMaterialPurchase::DELETED_NO)
                ->first();
            if(empty($purchase)){
                throw new \Exception("Purchase Order Not Found");
            }

            $purchase->deleted = ProductMaterialPurchase::DELETED_YES;
            $purchase->deleted_at = Carbon::now();
            $purchase->deleted_by = auth()->user()->id;
            $purchase->save();

            $purchaseDetails = ProductMaterialPurchaseDetails::where('product_material_purchase_id', $id)
                ->get();

            foreach ($purchaseDetails as $purchaseDetail){
                $purchaseDetail->deleted = ProductMaterialPurchaseDetails::DELETED_YES;
                $purchaseDetail->deleted_at = Carbon::now();
                $purchaseDetail->deleted_by = auth()->user()->id;
                $purchaseDetail->save();
            }

        }catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function statusUpdate($id, $status)
    {
        DB::beginTransaction();
        try {
            $purchase = ProductMaterialPurchase::where('id', $id)
                ->where('deleted', ProductMaterialPurchase::DELETED_NO)
                ->first();
            if(empty($purchase)){
                throw new \Exception("Purchase Order Not Found");
            }

            $purchase->purchase_status = $status;
            $purchase->save();

            if ($status == $purchase::PURCHASE_STATUS_ON_PROCESS){
                $transaction = Transaction::where('reference_type', Transaction::REFERENCE_TYPE_PRODUCT_MATERIAL_PURCHASE)
                    ->where('reference_id', $id)
                    ->where('deleted', Transaction::DELETED_NO)
                    ->first();
                if(empty($transaction)){
                    $account = AccCoaAccount::where('slug', 'purchase-products')
                        ->where('deleted', AccCoaAccount::DELETED_NO)
                        ->first();
                    $purchaseAccountCategory = AccCoaAccount::where('slug', 'accounts-payable')
                        ->where('deleted', AccCoaAccount::DELETED_NO)
                        ->first();
                    $transaction = new Transaction();
                    $transaction->paid_type = Transaction::PAID_TYPE_UNPAID;
                    $transaction->transaction_type = Transaction::TRANSACTION_TYPE_WITHDRAW;
                    $transaction->transaction_date = $purchase->purchase_date;
                    $transaction->account_id = $account->id;
                    $transaction->category_id = $purchaseAccountCategory->id;
                    $transaction->reference_type = Transaction::REFERENCE_TYPE_PRODUCT_MATERIAL_PURCHASE;
                    $transaction->reference_id = $id;
                    $transaction->reference_description = "Product Material Purchase ".$purchase->purchase_id;
                    $transaction->net_amount = $purchase->subtotal_amount_php;
                    $transaction->total_vat_amount = $purchase->total_vat_amount_php;
                    $transaction->total_amount = $purchase->payable_amount_php;
                    $transaction->description = "Product Material Purchase ".$purchase->purchase_id;
                    $transaction->note = "Product Material Purchase ".$purchase->purchase_id;
                    $transaction->created_at = Carbon::now();
                    $transaction->created_by = auth()->user()->id;
                    $transaction->updated_at = Carbon::now();
                    $transaction->updated_by = auth()->user()->id;
                    $transaction->save();

                    $purchase_details = ProductMaterialPurchaseDetails::where('deleted', ProductMaterialPurchaseDetails::DELETED_NO)
                        ->where('product_material_purchase_id', $purchase->id)
                        ->where('status', ProductMaterialPurchaseDetails::STATUS_ACTIVE)
                        ->select('tax_id',
                                DB::raw('SUM(total_price_php) as total_price_sum'),
                                DB::raw('SUM(tax_amount_php) as tax_amount_sum'),
                                DB::raw('MAX(tax_rate) as tax_rate'))
                        ->groupBy('tax_id')
                        ->get();


                    foreach ($purchase_details as $details){
                        if($details->tax_id){
                            $trns_vat = new TransactionVat();
                            $trns_vat->transaction_id = $transaction->id;
                            $trns_vat->tax_id = $details->tax_id;
                            $trns_vat->main_amount = $details->total_price_sum;
                            $trns_vat->vat_percent = $details->tax_rate;
                            $trns_vat->vat_amount = $details->tax_amount_sum;
                            $trns_vat->created_at = Carbon::now();
                            $trns_vat->created_by = auth()->user()->id;
                            $trns_vat->updated_at = Carbon::now();
                            $trns_vat->updated_by = auth()->user()->id;
                            $trns_vat->save();
                        }
                    }
                }
            }

        }catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }

        DB::commit();
    }

    public function getAllProductMaterials($request)
    {
        if(isset($request->q) && ($request->q != '') && ($request->q != null)) {
            $search_keyword = $request->q;
        } else {
            $search_keyword = null;
        }
        $data['product_materials'] = ProductMaterial::with('tax')
            ->when($search_keyword, function ($q) use($search_keyword){
                return $q->where('name', 'LIKE', '%'.$search_keyword.'%');
            })
            ->where('status', ProductMaterial::STATUS_ACTIVE)
            ->where('deleted', ProductMaterial::DELETED_NO)
            ->get()
            ->map(function ($item) {
                if($item->tax == null) {
                    $itemTax = (object) [
                        'id' => null,
                        'name' => null,
                        'tax_rate' => 0,
                    ];
                } else {
                    $itemTax = $item->tax;
                }
                return [
                    'id' => $item->id,
                    'name' => $item->name,
                    'code' => $item->code,
                    'show_image' => asset($item->show_image),
                    'tax' => $itemTax,
                    'unit_type' => $item::UNIT_TYPES[$item->unit_type],
                    'description' => $item->description,
                    'color' => $item->color,
                    'length' => $item->length,
                    'width' => $item->width,
                    'thickness' => $item->thickness,
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

        $data['suppliers'] = Supplier::with('country', 'state')
            ->where('status', Supplier::STATUS_ACTIVE)
            ->where('deleted', Supplier::DELETED_NO)
            ->when($search_keyword, function ($q) use($search_keyword){
                $q->where(function ($j) use ($search_keyword) {
                        $j->where('business_name', 'LIKE', '%'.$search_keyword.'%')
                        ->orWhere('phone', 'LIKE', '%'.$search_keyword.'%');
                });
            })
            ->get()
            ->map(function ($supplier) {
                $supplier->show_image_full_url = asset($supplier->show_image);
                $supplier->contact_full_name = $supplier->full_name;
                $supplier->full_address = $supplier->getFullAddressText();
                return $supplier;
            });

        return $data;
    }

    public function printBarcodeData($id, $type){
        $data['material'] = ProductMaterialPurchase::where('id', $id)
            ->where('status', ProductMaterialPurchase::STATUS_ACTIVE)
            ->where('deleted', ProductMaterialPurchase::DELETED_NO)
            ->with('purchaseDetails', 'purchaseDetails.productMaterial')
            ->first();

        $data['type'] = $type;
        return $data;
    }
}
