<?php

namespace App\Traits\Accounting;

use App\Models\Accounting\AccCoaAccount;

trait AccountBalanceTrait
{
    public function addAccountBalance($account_id, $amount)
    {
        $account = AccCoaAccount::where('id', $account_id)
            ->where('status', AccCoaAccount::STATUS_ACTIVE)
            ->where('deleted', AccCoaAccount::DELETED_NO)
            ->first();
    }
}
