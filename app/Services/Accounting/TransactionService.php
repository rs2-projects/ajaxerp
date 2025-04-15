<?php

namespace App\Services\Accounting;

use App\Models\Accounting\AccCoaAccount;
use App\Models\Accounting\AccCoaCategory;
use App\Models\Accounting\AccCoaSubCategory;
use App\Models\Accounting\Transaction;
use App\Models\Accounting\TransactionVat;
use App\Models\Procurements\ProductMaterialPurchase;
use App\Models\Procurements\ProductMaterialPurchaseDetails;
use App\Models\Procurements\ProductMaterialPurchasePayment;
use App\Models\Sales\Invoice;
use App\Models\Sales\InvoicePayment;
use App\Traits\Accounting\AccountBalanceTrait;
use App\Traits\VatTaxTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TransactionService
{
    use VatTaxTrait;
    use AccountBalanceTrait;
    private int $paginate_limit;

    public function __construct(){
        $this->paginate_limit = config('commonData.paginate_limit');
    }

    public function indexData()
    {
        $data = [];
        $data['accounts'] = AccCoaAccount::where('status', AccCoaAccount::STATUS_ACTIVE)
            ->where('deleted', AccCoaAccount::DELETED_NO)
            ->whereHas('subCategory', function ($q) {
                $q->where('is_account_type', AccCoaSubCategory::IS_ACCOUNT_TYPE_YES);
            })
            ->get();

        $data['account_sub_categories'] = AccCoaSubCategory::where('status', AccCoaSubCategory::STATUS_ACTIVE)
            ->where('deleted', AccCoaSubCategory::DELETED_NO)
            ->where('is_account_type', AccCoaSubCategory::IS_ACCOUNT_TYPE_YES)
            ->get();

        $data['expense_sub_categories'] = AccCoaSubCategory::where('status', AccCoaSubCategory::STATUS_ACTIVE)
            ->where('deleted', AccCoaSubCategory::DELETED_NO)
            ->where('is_account_type', AccCoaSubCategory::IS_ACCOUNT_TYPE_NO)
            ->whereHas('category', function ($q) {
                $q->where('type', '!=', AccCoaCategory::TYPE_INCOME);
            })
            ->get();

        $data['vat_taxes'] = $this->getVatTaxList();

        return $data;
    }

    public function indexFilteredData($request)
    {
        $data['transactions'] = Transaction::with('account','category')
            ->where('paid_type', Transaction::PAID_TYPE_PAID)
            ->where('status', Transaction::STATUS_ACTIVE)
            ->where('deleted', Transaction::DELETED_NO)
            ->where(function ($q) use ($request) {
                if(($request->account_id != '') && ($request->account_id != 'all')) {
                    $q->where('account_id', $request->account_id);
                }
            })
            ->orderBy('transaction_date', 'DESC')
            ->orderBy('id', 'DESC')
            ->paginate($this->paginate_limit);
        return $data;
    }

    public function reviewTransaction($id, $request)
    {
        $transaction = Transaction::where('id', $id)
            ->where('status', 1)
            ->where('deleted', 0)
            ->first();
        if (empty($transaction)) {
            throw new \Exception("Invalid Expense!", 404);
        }

        if($request->review == Transaction::IS_REVIEWED_YES) {
            $transaction->is_reviewed = Transaction::IS_REVIEWED_YES;
            $transaction->reviewed_at = Carbon::now();
            $transaction->reviewed_by = auth()->id();
        } else {
            $transaction->is_reviewed = Transaction::IS_REVIEWED_NO;
        }

        $transaction->save();
    }

    // delete invoice transaction
    public function deleteInvoicePayment($id)
    {
        DB::beginTransaction();
        try {
            
            $transaction = Transaction::where('id', $id)
                ->where('reference_type', Transaction::REFERENCE_TYPE_INVOICE_PAYMENT)
                ->where('status', Transaction::STATUS_ACTIVE)
                ->where('deleted', Transaction::DELETED_NO)
                ->first();

            if (empty($transaction)) {
                throw new \Exception('Invalid Transaction!');
            }

            $invoice = Invoice::where('id', $transaction->invoicePayment->invoice_id??null)
                ->where('status', Invoice::STATUS_ACTIVE)
                ->where('deleted', Invoice::DELETED_NO)
                ->first();
                
            if (empty($invoice)) {
                throw new \Exception('Invalid Invoice!');
            }

            $new_paid_amount = $invoice->paid_amount - $transaction->total_amount;
            $new_due_amount = $invoice->payable_amount - $new_paid_amount;
            if ($new_paid_amount != 0) {
                $invoice->payment_status = Invoice::PAYMENT_STATUS_PARTIAL_PAID;
            } else {
                $invoice->payment_status = Invoice::PAYMENT_STATUS_UNPAID;
            }

            $invoice->paid_amount = $new_paid_amount;
            $invoice->due_amount = $new_due_amount;
            $invoice->save();

            $deductPreviousAccountBalance = $this->deductAccountBalanceById($transaction->account_id, $transaction->total_amount);
            
            $invoicePayment = InvoicePayment::where('id', $transaction->reference_id)->first();

            if (empty($invoicePayment)) {
                throw new \Exception('Invalid Invoice Payment!');
            }

            $invoicePayment->status = InvoicePayment::STATUS_INACTIVE;
            $invoicePayment->deleted = InvoicePayment::DELETE_YES;
            $invoicePayment->deleted_at = Carbon::now();
            $invoicePayment->deleted_by = auth()->id();
            $invoicePayment->save();
        
            $transaction->status = $transaction::STATUS_INACTIVE;
            $transaction->deleted = $transaction::DELETED_YES;
            $transaction->deleted_at = Carbon::now();
            $transaction->deleted_by = auth()->id();
            $transaction->save();

        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
        DB::commit();
       
    }

    // delete product material purchase transaction
    public function deleteMaterialPurchasePayment($id)
    {
        DB::beginTransaction();
        try {
            
            $transaction = Transaction::where('id', $id)
                ->where('reference_type', Transaction::REFERENCE_TYPE_PRODUCT_MATERIAL_PURCHASE_PAYMENT)
                ->where('status', Transaction::STATUS_ACTIVE)
                ->where('deleted', Transaction::DELETED_NO)
                ->first();

            if (empty($transaction)) {
                throw new \Exception('Invalid Transaction!');
            }

            $purchase = ProductMaterialPurchase::where('id', $transaction->materialPurchasePayment->product_material_purchase_id??null)
                ->where('status', ProductMaterialPurchase::STATUS_ACTIVE)
                ->where('deleted', ProductMaterialPurchase::DELETED_NO)
                ->first();

            if (empty($purchase)) {
                throw new \Exception('Invalid Purchase!');
            }

            $purchasePayment = ProductMaterialPurchasePayment::where('id', $transaction->reference_id)->first();
            
            if (empty($purchasePayment)) {
                throw new \Exception('Invalid Purchase Payment!');
            }

            if($purchase->purchase_status == ProductMaterialPurchase::PURCHASE_STATUS_ON_PROCESS){
                $purchase->purchase_status = ProductMaterialPurchase::PURCHASE_STATUS_NEW;
            }elseif($purchase->purchase_status == ProductMaterialPurchase::PURCHASE_STATUS_DELIVERED){

                $purchase->purchase_status = ProductMaterialPurchase::PURCHASE_STATUS_ON_PROCESS;
                $purchase->has_damage = ProductMaterialPurchase::HAS_DAMAGE_NO;
                $purchase->has_missing = ProductMaterialPurchase::HAS_MISSING_NO;
                $purchase->price_calculated = ProductMaterialPurchase::PRICE_CALCULATED_NO;

                if($purchase->purchaseDetails->isNotEmpty()){
                    foreach($purchase->purchaseDetails as $details){
                        // TODO: Delete calculated price, InventoryProductMaterial
                        $puchase_qty = $details->qty - $details->damage_qty - $details->missing_qty;

                        $productMaterial = $details->productMaterial;
                        $productMaterial->total_purchased_qty = $productMaterial->total_purchased_qty - $puchase_qty;
                        $productMaterial->available_qty = $productMaterial->available_qty - $puchase_qty;
                        $productMaterial->save();

                        $details->is_perfect = ProductMaterialPurchaseDetails::IS_PERFECT_NO;
                        $details->has_damage = ProductMaterialPurchaseDetails::IS_PERFECT_NO;
                        $details->has_missing = ProductMaterialPurchaseDetails::HAS_DAMAGE_NO;
                        $details->save();
                    }
                }
            }


            $new_paid_amount = $purchase->paid_amount - $purchasePayment->amount;
            $new_due_amount = $purchase->payable_amount - $new_paid_amount;

            $new_paid_amount_php = $purchase->paid_amount_php - $purchasePayment->amount_php;
            $new_due_amount_php = $purchase->payable_amount_php - $new_paid_amount_php;

            if ($new_paid_amount != 0) {
                $purchase->payment_status = ProductMaterialPurchase::PAYMENT_STATUS_PARTIAL_PAID;
            } else {
                $purchase->payment_status = ProductMaterialPurchase::PAYMENT_STATUS_UNPAID;
            }

            $purchase->paid_amount = $new_paid_amount;
            $purchase->due_amount = $new_due_amount;
            $purchase->paid_amount_php = $new_paid_amount_php;
            $purchase->due_amount_php = $new_due_amount_php;
            $purchase->save();

            $addPreviousAccountBalance = $this->addAccountBalanceById($transaction->account_id, $transaction->total_amount);
            
            $purchasePayment->status = ProductMaterialPurchasePayment::STATUS_INACTIVE;
            $purchasePayment->deleted = ProductMaterialPurchasePayment::DELETE_YES;
            $purchasePayment->deleted_at = Carbon::now();
            $purchasePayment->deleted_by = auth()->id();
            $purchasePayment->save();

        
            $transaction->status = $transaction::STATUS_INACTIVE;
            $transaction->deleted = $transaction::DELETED_YES;
            $transaction->deleted_at = Carbon::now();
            $transaction->deleted_by = auth()->id();
            $transaction->save();

        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
        DB::commit();
    }
}
