<?php

namespace App\Traits;

use App\Models\Accounting\AccCoaAccount;
use App\Models\Accounting\AccCoaSubCategory;

trait VatTaxTrait
{
    public function getVatTaxList()
    {
        $vat_taxes = [];
        $vatSubCat = AccCoaSubCategory::where('is_sales_tax', AccCoaSubCategory::IS_SALES_TAX_YES)
            ->where('status', AccCoaSubCategory::STATUS_ACTIVE)
            ->where('deleted', AccCoaSubCategory::DELETED_NO)
            ->first();
        if (!empty($vatSubCat)) {
            $vat_taxes = AccCoaAccount::where('acc_coa_sub_category_id', $vatSubCat->id)
                ->where('status', AccCoaAccount::STATUS_ACTIVE)
                ->where('deleted', AccCoaAccount::DELETED_NO)
                ->get();
        }
        return $vat_taxes;
    }
}
