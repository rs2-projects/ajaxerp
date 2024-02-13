<?php

namespace App\Services\Procurement\ProductMaterial;

use App\Models\Accounting\AccCoaSubCategory;
use App\Models\Accounting\Transaction;
use App\Models\Procurements\ProductMaterialPurchase;
use App\Models\Procurements\ProductMaterialPurchasePayment;
use Illuminate\Support\Facades\DB;

class PurchaseMakePaymentService
{
    public function makePaymentData($id)
    {
        try {
            $data['purchase'] = ProductMaterialPurchase::where('id', $id)
                ->where('deleted', ProductMaterialPurchase::DELETED_NO)
                ->first();

            if(!$data['purchase']){
                throw new \Exception("Purchase not found");
            }

            if ($data['purchase']->payment_status == ProductMaterialPurchase::PAYMENT_STATUS_PAID) {
                throw new \Exception("Payment already made");
            }

            $data['payment_methods'] = ProductMaterialPurchasePayment::PAYMENT_METHODS;


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
            $purchase = ProductMaterialPurchase::where('id', $id)
                ->where('deleted', ProductMaterialPurchase::DELETED_NO)
                ->first();
            if (!$purchase) {
                throw new \Exception("Purchase not found");
            }

            if ($purchase->payment_status == ProductMaterialPurchase::PAYMENT_STATUS_PAID) {
                throw new \Exception("Payment already made");
            }

            // Create Transaction
            $transaction = new Transaction();


        }catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
        DB::commit();
    }
}
