<?php

namespace App\Services\Procurement\Assets\PurchaseOrder;

use App\Models\Accounting\AccCoaAccount;
use App\Models\Accounting\AccCoaSubCategory;
use App\Models\Accounting\Transaction;
use App\Models\Accounting\TransactionReceipt;
use App\Models\Procurements\AssetProductPurchaseOrder;
use App\Models\Procurements\AssetProductPurchasePayment;
use App\Services\Common\FileUploadService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PurchaseOrderPaymentService
{
    public function makePaymentData($id)
    {
        try {
            $data['purchase'] = AssetProductPurchaseOrder::where('id', $id)
                ->where('deleted', AssetProductPurchaseOrder::DELETED_NO)
                ->first();

            if(!$data['purchase']){
                throw new \Exception("Purchase not found");
            }

            if ($data['purchase']->payment_status == AssetProductPurchaseOrder::PAYMENT_STATUS_PAID) {
                throw new \Exception("Payment already made");
            }

            $data['payment_methods'] = AssetProductPurchasePayment::PAYMENT_METHODS;

            $data['accounts_sub_categories'] = AccCoaSubCategory::with('accounts')
                ->where('deleted', AccCoaSubCategory::DELETED_NO)
                ->where('status', AccCoaSubCategory::STATUS_ACTIVE)
                ->where('is_account_type', AccCoaSubCategory::IS_ACCOUNT_TYPE_YES)
                ->get();

            return $data;

        }catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function makePaymentSubmit($request,$id)
    {
        DB::beginTransaction();
        try {
            $purchase = AssetProductPurchaseOrder::where('id', $id)
                ->where('deleted', AssetProductPurchaseOrder::DELETED_NO)
                ->first();
            if (!$purchase) {
                throw new \Exception("Purchase not found");
            }

            if ($purchase->payment_status == AssetProductPurchaseOrder::PAYMENT_STATUS_PAID) {
                throw new \Exception("Payment already made");
            }

            $account = AccCoaAccount::where('id', $request->account_id)
                ->where('deleted', AccCoaAccount::DELETED_NO)
                ->first();
            if (!$account) {
                throw new \Exception("Account not found");
            }

            // payment amount validation
            if ($request->amount <= 0) {
                throw new \Exception("Invalid amount");
            }

            if ($request->amount > $purchase->due_amount) {
                throw new \Exception("Payment amount can't be greater than due amount");
            }
            $purchaseAccountCategory = AccCoaAccount::where('slug', 'accounts-payable')
                ->where('deleted', AccCoaAccount::DELETED_NO)
                ->first();
            // Create Transaction
            $transaction = new Transaction();
            $transaction->paid_type = Transaction::PAID_TYPE_PAID;
            $transaction->transaction_type = Transaction::TRANSACTION_TYPE_WITHDRAW;
            $transaction->transaction_date = $request->date;
            $transaction->account_id = $account->id;
            $transaction->category_id = $purchaseAccountCategory->id;
            $transaction->reference_type = Transaction::REFERENCE_TYPE_ASSET_PRODUCT_PURCHASE_PAYMENT;
            $transaction->reference_id = null;
            $transaction->reference_description = "Asset Product Purchase Payment ".$purchase->purchase_order_id;
            $transaction->net_amount = $request->amount;
            $transaction->total_vat_amount = 0;
            $transaction->total_amount = $request->amount;
            $transaction->description = "Asset Product Purchase Payment ".$purchase->purchase_order_id;
            $transaction->note = $request->note;
            $transaction->created_at = Carbon::now();
            $transaction->created_by = auth()->user()->id;
            $transaction->updated_at = Carbon::now();
            $transaction->updated_by = auth()->user()->id;
            $transaction->save();

            $purchase->paid_amount = $purchase->paid_amount + $request->amount;
            $purchase->due_amount = $purchase->payable_amount - $purchase->paid_amount;
            $purchase->payment_status = AssetProductPurchaseOrder::PAYMENT_STATUS_PARTIAL_PAID;

            if ($purchase->purchse_status == $purchase::PURCHASE_STATUS_NEW){
                $purchase->purchase_status = $purchase::PURCHASE_STATUS_ON_PROCESS;
            }

            $purchase->updated_at = Carbon::now();
            $purchase->updated_by = auth()->user()->id;
            $purchase->save();

            if ($purchase->payable_amount == $purchase->paid_amount) {
                $purchase->payment_status = AssetProductPurchaseOrder::PAYMENT_STATUS_PAID;
                $purchase->updated_at = Carbon::now();
                $purchase->updated_by = auth()->user()->id;
                $purchase->save();
            }

            // create purchase payment
            $purchase_payment = new AssetProductPurchasePayment();
            $purchase_payment->asset_product_purchase_order_id = $purchase->id;
            $purchase_payment->transaction_id = $transaction->id;
            $purchase_payment->account_id = $account->id;
            $purchase_payment->payment_method = $request->payment_method;
            $purchase_payment->amount = $request->amount;
            $purchase_payment->payment_date = $request->date;
            $purchase_payment->note = $request->note;
            $purchase_payment->created_at = Carbon::now();
            $purchase_payment->created_by = auth()->user()->id;
            $purchase_payment->updated_at = Carbon::now();
            $purchase_payment->updated_by = auth()->user()->id;
            $purchase_payment->save();

            $transaction->reference_id = $purchase_payment->id;
            $transaction->save();

            // receipt upload
            if ($request->hasFile('receipt')) {
                if (count($request->file('receipt')) > 0) {
                    foreach ($request->file('receipt') as $key=>$file) {
                        $fileUploadService = new FileUploadService();
                        $file_path = $fileUploadService->store($request->receipt[$key], 'transaction/purchase-payment-receipt');
                        $file_path = $file_path['path'];

                        $transaction_receipt = new TransactionReceipt();
                        $transaction_receipt->transaction_id = $transaction->id;
                        $transaction_receipt->receipt = $file_path;
                        $transaction_receipt->status = TransactionReceipt::STATUS_ACTIVE;
                        $transaction_receipt->save();
                    }
                }
            }
        }catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
        DB::commit();
    }
}
