<?php

namespace App\Services\Procurement\ProductMaterial;

use App\Models\Accounting\AccCoaAccount;
use App\Models\Accounting\AccCoaSubCategory;
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
        }
    }

    public function getAllPurchaseOrders($request)
    {
        $data['purchase_orders'] = ProductMaterialPurchase::with('supplier','purchaseDetails')
            ->where('deleted', ProductMaterialPurchase::DELETED_NO)
            ->orderBy('id', 'DESC')
            ->paginate($this->paginate_limit);

        $data['view'] = view('procurement.product-material-purchase._index_filtered', $data)->render();

        return $data;
    }

    public function getNewPurchaseOrders($request)
    {
        $data['purchase_orders'] = ProductMaterialPurchase::with('supplier','purchaseDetails')
            ->where('purchase_status', ProductMaterialPurchase::PURCHASE_STATUS_NEW)
            ->where('deleted', ProductMaterialPurchase::DELETED_NO)
            ->orderBy('id', 'DESC')
            ->paginate($this->paginate_limit);

        $data['view'] = view('procurement.product-material-purchase._new_index_filtered', $data)->render();

        return $data;
    }

    public function getOnProcessPurchaseOrders($request)
    {
        $data['purchase_orders'] = ProductMaterialPurchase::with('supplier','purchaseDetails')
            ->where('purchase_status', ProductMaterialPurchase::PURCHASE_STATUS_ON_PROCESS)
            ->where('deleted', ProductMaterialPurchase::DELETED_NO)
            ->orderBy('id', 'DESC')
            ->paginate($this->paginate_limit);

        $data['view'] = view('procurement.product-material-purchase._on_process_index_filtered', $data)->render();

        return $data;
    }

    public function getDeliveredPurchaseOrders($request)
    {
        $data['purchase_orders'] = ProductMaterialPurchase::with('supplier','purchaseDetails')
            ->where('purchase_status', ProductMaterialPurchase::PURCHASE_STATUS_DELIVERED)
            ->where('deleted', ProductMaterialPurchase::DELETED_NO)
            ->orderBy('id', 'DESC')
            ->paginate($this->paginate_limit);

        $data['view'] = view('procurement.product-material-purchase._delivered_index_filtered', $data)->render();

        return $data;
    }

    public function getRevisedPurchaseOrders($request)
    {
        $data['purchase_orders'] = ProductMaterialPurchase::with('supplier','purchaseDetails')
            ->where('is_revised', ProductMaterialPurchase::IS_REVISED_YES)
            ->where('deleted', ProductMaterialPurchase::DELETED_NO)
            ->orderBy('id', 'DESC')
            ->paginate($this->paginate_limit);

        $data['view'] = view('procurement.product-material-purchase._revised_index_filtered', $data)->render();

        return $data;
    }

    public function getBackPurchaseOrders($request)
    {
        $data['purchase_orders'] = ProductMaterialPurchase::with('supplier','purchaseDetails')
            ->where('is_backed', ProductMaterialPurchase::IS_BACKED_YES)
            ->where('deleted', ProductMaterialPurchase::DELETED_NO)
            ->orderBy('id', 'DESC')
            ->paginate($this->paginate_limit);

        $data['view'] = view('procurement.product-material-purchase._back_index_filtered', $data)->render();

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

            $purchase = new ProductMaterialPurchase();
            $purchase->purchase_create_type = ProductMaterialPurchase::PURCHASE_CREATE_TYPE_NEW;
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
            $purchase->purchase_id = "PO - ".(1000 + $purchase->id);
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
                    if($tax_id != null){
                        $tax = AccCoaAccount::where('status', AccCoaAccount::STATUS_ACTIVE)
                            ->where('deleted', AccCoaAccount::DELETED_NO)
                            ->where('id', $tax_id)
                            ->first();
                        if(!empty($tax)){
                            $tax_rate = $tax->tax_rate;
                            $amount_with_tax = $amount_without_tax + ($amount_without_tax * $tax_rate / 100);
                            $tax_amount = $amount_without_tax * $tax_rate / 100;
                        }
                    }

                    $purchaseDetails = new ProductMaterialPurchaseDetails();
                    $purchaseDetails->product_material_purchase_id = $purchase->id;
                    $purchaseDetails->product_material_id = $product;
                    $purchaseDetails->description = $request->description[$key];
                    $purchaseDetails->color = $request->color[$key];
                    $purchaseDetails->qty = $qty;
                    $purchaseDetails->unit_price = $price;
                    $purchaseDetails->total_price = $qty * $price;
                    $purchaseDetails->tax_id = $tax_id;
                    $purchaseDetails->tax_rate = $tax_rate;
                    $purchaseDetails->tax_amount = $tax_amount;
                    $purchaseDetails->net_total = $amount_with_tax;
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
            if($purchase->discount_type == ProductMaterialPurchase::DISCOUNT_TYPE_PERCENTAGE){
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
                    if($tax_id != null){
                        $tax = AccCoaAccount::where('status', AccCoaAccount::STATUS_ACTIVE)
                            ->where('deleted', AccCoaAccount::DELETED_NO)
                            ->where('id', $tax_id)
                            ->first();
                        if(!empty($tax)){
                            $tax_rate = $tax->tax_rate;
                            $amount_with_tax = $amount_without_tax + ($amount_without_tax * $tax_rate / 100);
                            $tax_amount = $amount_without_tax * $tax_rate / 100;
                        }
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
                    $purchaseDetails->total_price = $qty * $price;
                    $purchaseDetails->tax_id = $tax_id;
                    $purchaseDetails->tax_rate = $tax_rate;
                    $purchaseDetails->tax_amount = $tax_amount;
                    $purchaseDetails->net_total = $amount_with_tax;
                    $purchaseDetails->is_perfect = ProductMaterialPurchaseDetails::IS_PERFECT_NO;
                    $purchaseDetails->has_damage = ProductMaterialPurchaseDetails::HAS_DAMAGE_NO;
                    $purchaseDetails->has_missing = ProductMaterialPurchaseDetails::HAS_MISSING_NO;
                    $purchaseDetails->updated_at = Carbon::now();
                    $purchaseDetails->updated_by = auth()->user()->id;
                    $purchaseDetails->save();

                    $subtotal_amount += $purchaseDetails->total_price;
                    $total_vat_amount += $purchaseDetails->tax_amount;

                }
            }
            $total_discount_amount = 0;
            if($purchase->discount_type == ProductMaterialPurchase::DISCOUNT_TYPE_PERCENTAGE){
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
        try {
            $purchase = ProductMaterialPurchase::where('id', $id)
                ->where('deleted', ProductMaterialPurchase::DELETED_NO)
                ->first();
            if(empty($purchase)){
                throw new \Exception("Purchase Order Not Found");
            }

            $purchase->purchase_status = $status;
            $purchase->save();

        }catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
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
                $supplier->show_image_full_url = asset($supplier->show_image);
                $supplier->contact_full_name = $supplier->full_name;
                return $supplier;
            });

        return $data;
    }
}
