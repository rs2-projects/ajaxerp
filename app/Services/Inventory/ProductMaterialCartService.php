<?php

namespace App\Services\Inventory;

use App\Models\Accounting\AccCoaAccount;
use App\Models\Procurements\ProductMaterialPurchase;
use App\Models\Procurements\ProductMaterialPurchaseDetails;
use App\Models\Procurements\SupplierProductMaterial;
use App\Models\Products\ProductMaterial;
use App\Models\Products\ProductMaterialCategory;
use App\Services\Common\CartService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ProductMaterialCartService
{
    private $paginate_limit;
    private CartService $cartService;

    public function __construct()
    {
        $this->paginate_limit = config('commonData.paginate_limit');
        $this->cartService = new CartService('product_material');
    }

    public function addToCart($request) {
        
        $product_material = ProductMaterial::where('id', $request->id)->first();
        if(empty($product_material)) {
            return response()->json([
                'status' => 404, 
                'message' => 'Invalid Product material!'
            ]);
        }

        $supplierProductMaterial = SupplierProductMaterial::where('product_material_id', $product_material->id)->first();
        
        if(empty($supplierProductMaterial)) {
            
            return response()->json([
                'status' => 404, 
                'message' => 'Supplier not found for this product material!'
            ]);
        }
        
        $data = $this->cartService->addToCart(
            item_id: $product_material->id,
            name: $product_material->name,
            image: $product_material->show_image,
            price: $product_material->price,
            qty: 1,
            extra: [
                'code' => $product_material->code,
                'supplier_id' => $supplierProductMaterial->supplier_id
            ]
        )->getCartContents();

        return response()->json([
            'status' => 200,
            'message' => 'Product added to cart successfully',
            'data' => $data
        ]);
        return $data;
    }

    public function getCartContents() {
        return $this->cartService->getCartContents();
    }

    public function updateCartQty($request) {
        return $this->cartService->updateCartQty($request->id, $request->qty);
    }

    public function removeCartItem($request) {
        return $this->cartService->removeCartItem($request->id);
    }

    public function submitCart($request) {
        DB::beginTransaction();
        try {

            $cartContents = $this->cartService->getCartContents();
            if(count($cartContents['items']) == 0) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Cart is empty!'
                ]);
            }
            
            $supplierWiseItems = $this->getSupplierWiseItems($cartContents['items']);

            foreach($supplierWiseItems as $supplier_id => $items) {
                // Create Purchase Order
                $purchaseOrder = $this->createPurchaseOrder($supplier_id, $items, $request);
            }

            $this->cartService->clearCart();

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 404,
                'message' => $e->getMessage()
            ]);
        }
        DB::commit();

        session()->flash('success', 'Purchase Order Created Successfully!');
        return response()->json([
            'status' => 200,
            'message' => 'Purchase Order Created Successfully!',
            'redirect' => route('procurement.product-material-purchase.index')
        ]);

    }

    public function getSupplierWiseItems($cartItems) {
        $supplierWiseItems = [];

        foreach($cartItems as $item) {
            $supplier_id = $item['extra']['supplier_id'];
            if(!isset($supplierWiseItems[$supplier_id])) {
                $supplierWiseItems[$supplier_id] = [];
            }
            $supplierWiseItems[$supplier_id][] = $item;
        }

        return $supplierWiseItems;
    }

    public function createPurchaseOrder($supplier_id, $items, $request) {
        try {
            // Create Purchase Order
            $php_rate = $request->php_rate;
            $batchNumber = (new ProductMaterialPurchase())->generateBatchNumber();
            $purchase = new ProductMaterialPurchase();
            $purchase->purchase_create_type = ProductMaterialPurchase::PURCHASE_CREATE_TYPE_NEW;
            $purchase->supplier_id = $supplier_id;
            $purchase->batch_number = $batchNumber;
            $purchase->purchase_date = Carbon::now()->format('Y-m-d');
            $purchase->discount_type = ProductMaterialPurchase::DISCOUNT_TYPE_PERCENTAGE;
            $purchase->discount_value = 0;
            $purchase->estimated_delivery_date = Carbon::now()->format('Y-m-d');
            $purchase->php_rate = $php_rate;
            $purchase->payment_status = ProductMaterialPurchase::PAYMENT_STATUS_UNPAID;
            $purchase->purchase_status = ProductMaterialPurchase::PURCHASE_STATUS_NEW;
            $purchase->is_revised = ProductMaterialPurchase::IS_REVISED_NO;
            $purchase->is_backed = ProductMaterialPurchase::IS_BACKED_NO;
            $purchase->notes = null;
            $purchase->invoice_footer = null;
            $purchase->created_at = Carbon::now();
            $purchase->created_by = auth()->user()->id;
            $purchase->updated_at = Carbon::now();
            $purchase->updated_by = auth()->user()->id;
            $purchase->save();
            $purchase->purchase_id = "PO - ".(1000 + $purchase->id);
            $purchase->save();

            // Create Purchase Order Items
            $subtotal_amount = 0;
            $total_vat_amount = 0;
            $has_boards = 0;
            $has_others = 0;

            foreach($items as $item) {
                $productMaterial = ProductMaterial::where('status', ProductMaterial::STATUS_ACTIVE)
                    ->where('deleted', ProductMaterial::DELETED_NO)
                    ->where('id', $item['id'])
                    ->first();

                if(empty($productMaterial)){
                    continue;
                }

                if ($productMaterial->type == ProductMaterial::TYPE_BOARD) {
                    $has_boards = 1;
                }elseif ($productMaterial->type == ProductMaterial::TYPE_PAPER) {
                    $has_boards = 1;
                } else {
                    // $has_others = 1;
                    $material_category = ProductMaterialCategory::where('status', ProductMaterialCategory::STATUS_ACTIVE)
                        ->where('deleted', ProductMaterialCategory::DELETED_NO)
                        ->where('id', $productMaterial->product_material_category_id)
                        ->first();
                    
                    if($material_category->calculator_type == ProductMaterialCategory::CALCULATOR_TYPE_BOARDS){
                        $has_boards = 1;
                    }else{
                        $has_others = 1;
                    }
                }

                $qty = $item['qty'];
                $price = $item['price'] ?? 0;
                $tax_id = null;

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
                        $amount_with_tax = $amount_without_tax;
                    }
                } else {
                    $tax_id = null;
                    $amount_with_tax = $amount_without_tax;
                }

                $purchaseDetails = new ProductMaterialPurchaseDetails();
                $purchaseDetails->product_material_purchase_id = $purchase->id;
                $purchaseDetails->product_material_id = $productMaterial->id;
                $purchaseDetails->product_type = $productMaterial->type;
                $purchaseDetails->description = $productMaterial->description;
                $purchaseDetails->color = $productMaterial->color;
                $purchaseDetails->qty = $qty;
                $purchaseDetails->unit_price = $price;
                $purchaseDetails->unit_price_php = $price * $php_rate;

                $total_price = $qty * $price;
                
                $purchaseDetails->total_price = $total_price;
                $purchaseDetails->total_price_php = $total_price * $php_rate;
                $purchaseDetails->tax_id = $tax_id;
                $purchaseDetails->tax_rate = $tax_rate;
                $purchaseDetails->tax_amount = $tax_amount;
                $purchaseDetails->tax_amount_php = $tax_amount * $php_rate;
                $purchaseDetails->net_total = $amount_with_tax;
                $purchaseDetails->net_total_php = $amount_with_tax * $php_rate;
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

            $total_discount_amount = 0;
            $total_discount_amount_php = 0;

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
            
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    
}
