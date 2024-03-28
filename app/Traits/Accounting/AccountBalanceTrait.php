<?php

namespace App\Traits\Accounting;

use App\Models\Accounting\AccCoaAccount;

trait AccountBalanceTrait
{
    public function addAccountBalance($account, $amount)
    {
        $updated_balance = $account->available_balance + $amount;
        $account->available_balance = $updated_balance;
        $account->save();
        return $updated_balance;
    }

    public function addAccountBalanceById($account_id, $amount)
    {
        $account = AccCoaAccount::where('id', $account_id)
            ->where('status', AccCoaAccount::STATUS_ACTIVE)
            ->where('deleted', AccCoaAccount::DELETED_NO)
            ->first();
        if (empty($account)) {
            throw new \Exception("Invalid Account!");
        }

        $updated_balance = $account->available_balance + $amount;
        $account->available_balance = $updated_balance;
        $account->save();
        return $updated_balance;
    }


    public function deductAccountBalance($account, $amount)
    {
        $updated_balance = $account->available_balance - $amount;
        $account->available_balance = $updated_balance;
        $account->save();
        return $updated_balance;
    }

    public function deductAccountBalanceById($account_id, $amount)
    {
        $account = AccCoaAccount::where('id', $account_id)
            ->where('status', AccCoaAccount::STATUS_ACTIVE)
            ->where('deleted', AccCoaAccount::DELETED_NO)
            ->first();
        if (empty($account)) {
            throw new \Exception("Invalid Account!");
        }

        $updated_balance = $account->available_balance - $amount;
        $account->available_balance = $updated_balance;
        $account->save();
        return $updated_balance;
    }
}
