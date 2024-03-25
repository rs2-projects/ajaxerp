<?php

namespace App\Repository\Transaction;

use App\Models\Accounting\AccCoaAccount;
use App\Models\Accounting\Transaction;
use App\Models\Accounting\TransactionVat;
use Carbon\Carbon;

class ExpenseRepository
{
    public function storeRepository($request)
    {
        $date = $request->date;
        $account_id = $request->account;
        $category_id = $request->category;
        $amount = $request->amount;
        $vat_tax_id = $request->vat_tax;
        $description = $request->description;

        //find and check account
        $account = AccCoaAccount::where('status', AccCoaAccount::STATUS_ACTIVE)
            ->where('deleted', AccCoaAccount::DELETED_NO)
            ->where('id', $account_id)
            ->first();
        if(empty($account)) {
            throw new \Exception("Invalid Account!");
        }
        //find and check category
        $category = AccCoaAccount::where('status', AccCoaAccount::STATUS_ACTIVE)
            ->where('deleted', AccCoaAccount::DELETED_NO)
            ->where('id', $account_id)
            ->first();
        if (empty($category)) {
            throw new \Exception("Invalid Category!");
        }
        //find and check
        if($vat_tax_id != '') {
            $vatAccount = AccCoaAccount::where('status', AccCoaAccount::STATUS_ACTIVE)
                ->where('deleted', AccCoaAccount::DELETED_NO)
                ->where('id', $vat_tax_id)
                ->first();
            if (empty($vatAccount)) {
                throw new \Exception("Invalid Vat Tax ID!");
            }
        } else {
            $vatAccount = null;
        }
        $total_amount = $amount;
        $net_amount = $amount;
        $total_vat_amount = 0;
        if ($vatAccount != null) {
            $vat_percent = $vatAccount->tax_rate;
            $net_amount = ($amount * 100) / (100 + $vat_percent);
            $total_vat_amount = ($amount * $vat_percent) / (100 + $vat_percent);
        }

//        $receipts_files = receipts
        $transaction = new Transaction();
        $transaction->paid_type = Transaction::PAID_TYPE_PAID;
        $transaction->transaction_type = Transaction::TRANSACTION_TYPE_WITHDRAW;
        $transaction->transaction_date = $date;
        $transaction->account_id = $account_id;
        $transaction->category_id = $category_id;
        $transaction->total_cost_price = 0;
        $transaction->net_amount = $net_amount;
        $transaction->total_vat_amount = $total_vat_amount;
        $transaction->total_amount = $total_amount;
        $transaction->description = $description;
        $transaction->status = Transaction::STATUS_ACTIVE;
        $transaction->created_at = Carbon::now();
        $transaction->created_by = auth()->id();
        $transaction->updated_at = Carbon::now();
        $transaction->updated_by = auth()->id();
        $transaction->save();

        if ($vatAccount != null) {
            $vatTrx = new TransactionVat();
            $vatTrx->transaction_id = $transaction->id;
            $vatTrx->tax_id = $vatAccount->id;
            $vatTrx->main_amount = $total_amount;
            $vatTrx->vat_percent = $vat_percent;
            $vatTrx->status = TransactionVat::STATUS_ACTIVE;
            $vatTrx->created_at = Carbon::now();
            $vatTrx->created_by = auth()->id();
            $vatTrx->updated_at = Carbon::now();
            $vatTrx->updated_by = auth()->id();
            $vatTrx->save();
        }

        if (isset($request->receipts) && is_array($request->receipts) && (count($request->receipts) > 0)) {
            foreach ($request->receipts as $receiptIndex => $image) {

            }
        }

    }
}
