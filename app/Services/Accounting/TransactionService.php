<?php

namespace App\Services\Accounting;

use App\Models\Accounting\AccCoaAccount;
use App\Models\Accounting\AccCoaCategory;
use App\Models\Accounting\AccCoaSubCategory;
use App\Models\Accounting\Transaction;
use App\Traits\VatTaxTrait;
use Carbon\Carbon;

class TransactionService
{
    use VatTaxTrait;
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
}
