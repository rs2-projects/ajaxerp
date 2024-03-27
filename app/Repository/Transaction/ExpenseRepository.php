<?php

namespace App\Repository\Transaction;

use App\Models\Accounting\AccCoaAccount;
use App\Models\Accounting\Transaction;
use App\Models\Accounting\TransactionReceipt;
use App\Models\Accounting\TransactionVat;
use App\Services\Common\ImageUploadService;
use App\Traits\Accounting\AccountBalanceTrait;
use Carbon\Carbon;

class ExpenseRepository
{
    use AccountBalanceTrait;
    private ImageUploadService $imageService;

    public function __construct()
    {
        $this->imageService = new ImageUploadService();
    }

    public function storeRepository($data)
    {
        $date = $data['date'];
        $account_id = $data['account'];
        $category_id = $data['category'];
        $amount = $data['amount'];
        $vat_tax_id = $data['vat_tax'];
        $description = $data['description'];

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

        $transaction = new Transaction();
        $transaction->paid_type = Transaction::PAID_TYPE_PAID;
        $transaction->transaction_type = Transaction::TRANSACTION_TYPE_WITHDRAW;
        $transaction->transaction_date = $date;
        $transaction->account_id = $account_id;
        $transaction->category_id = $category_id;
        $transaction->reference_type = Transaction::REFERENCE_TYPE_EXPENSE;
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

        $this->deductAccountBalance($account, $total_amount);
        $this->addAccountBalance($category, $net_amount);

        if ($vatAccount != null) {
            $vatTrx = new TransactionVat();
            $vatTrx->transaction_id = $transaction->id;
            $vatTrx->tax_id = $vatAccount->id;
            $vatTrx->main_amount = $net_amount;
            $vatTrx->vat_percent = $vat_percent;
            $vatTrx->vat_amount = $total_vat_amount;
            $vatTrx->status = TransactionVat::STATUS_ACTIVE;
            $vatTrx->created_at = Carbon::now();
            $vatTrx->created_by = auth()->id();
            $vatTrx->updated_at = Carbon::now();
            $vatTrx->updated_by = auth()->id();
            $vatTrx->save();

            $this->addAccountBalance($vatAccount, $total_vat_amount);
        }

        if (isset($data['receipts']) && is_array($data['receipts']) && (count($data['receipts']) > 0)) {
            foreach ($data['receipts'] as $receiptIndex => $image) {
                if ($image != '') {
                    $uploadedImage = $this->imageService->store($image, 'receipts');

                    $receipt = new TransactionReceipt();
                    $receipt->transaction_id = $transaction->id;
                    $receipt->receipt = $uploadedImage['path'];
                    $receipt->status = TransactionReceipt::STATUS_ACTIVE;
                    $receipt->save();

                }
            }
        }
    }
}
