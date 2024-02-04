<?php

namespace App\Services\Settings;

use App\Models\Accounting\AccCoaAccount;
use App\Models\Accounting\AccCoaSubCategory;
use Carbon\Carbon;

class VatTaxTypeSettingsService
{
    public function __construct()
    {
        $this->paginate_limit = config('commonData.paginate_limit');
    }

    public function indexFilteredData($request)
    {
        $subCat = AccCoaSubCategory::where('is_sales_tax', AccCoaSubCategory::IS_SALES_TAX_YES)
            ->where('status', AccCoaSubCategory::STATUS_ACTIVE)
            ->where('deleted', AccCoaSubCategory::DELETED_NO)
            ->first();
        if (empty($subCat)) {
            throw new \Exception("Can\'t find sales tax. Please contact with admin!");
        }
        $data['vats'] = AccCoaAccount::where('acc_coa_sub_category_id', $subCat->id)
            ->where('deleted', AccCoaAccount::DELETED_NO)
            ->orderBy('id', 'desc')
            ->paginate($this->paginate_limit);

        return $data;
    }

    public function storeData($request)
    {
        try {
            $subCat = AccCoaSubCategory::where('is_sales_tax', AccCoaSubCategory::IS_SALES_TAX_YES)
                ->where('status', AccCoaSubCategory::STATUS_ACTIVE)
                ->where('deleted', AccCoaSubCategory::DELETED_NO)
                ->first();
            if (empty($subCat)) {
                throw new \Exception("Can\'t find sales tax. Please contact with admin!");
            }

            $vat = new AccCoaAccount();
            $vat->acc_coa_category_id = $subCat->acc_coa_category_id;
            $vat->acc_coa_sub_category_id = $subCat->id;
            $vat->name = $request->tax_name;
            $vat->account_no = $request->tax_number ?? null;
            $vat->tax_rate = $request->tax_rate;
            $vat->opening_balance = 0;
            $vat->available_balance = 0;
            $vat->description = $request->description;
            $vat->is_default = AccCoaAccount::IS_DEFAULT_NO;
            $vat->can_edit = AccCoaAccount::CAN_EDIT_YES;
            $vat->created_at = Carbon::now();
            $vat->created_by = auth()->id();
            $vat->updated_at = Carbon::now();
            $vat->updated_by = auth()->id();
            $vat->save();

        }catch (\Exception $exception) {
            throw $exception;
        }

        return $vat;
    }

    public function editData($id)
    {

        $data['item'] = AccCoaAccount::where('id', $id)
            ->where('deleted', AccCoaAccount::DELETED_NO)
            ->first();
        if (empty($data['item'])) {
            throw new \Exception("Can\'t find vat. Please contact with admin!");
        }

        return $data;

    }

    public function updateData($request, $id)
    {
        try {
            $vat = AccCoaAccount::where('id', $id)
                ->where('deleted', AccCoaAccount::DELETED_NO)
                ->first();
            if (empty($vat)) {
                throw new \Exception("Can\'t find vat. Please contact with admin!");
            }

            $vat->name = $request->tax_name;
            $vat->account_no = $request->tax_number ?? null;
            $vat->tax_rate = $request->tax_rate;
            $vat->description = $request->description;
            $vat->updated_at = Carbon::now();
            $vat->updated_by = auth()->id();
            $vat->save();

        }catch (\Exception $exception) {
            throw $exception;
        }

        return $vat;
    }

    public function deleteDate($id)
    {
        try {
            $vat = AccCoaAccount::where('id', $id)
                ->where('deleted', AccCoaAccount::DELETED_NO)
                ->first();
            if (empty($vat)) {
                throw new \Exception("Can\'t find vat. Please contact with admin!");
            }

            $vat->deleted = AccCoaAccount::DELETED_YES;
            $vat->deleted_at = Carbon::now();
            $vat->deleted_by = auth()->id();
            $vat->save();

        }catch (\Exception $exception) {
            throw $exception;
        }

        return $vat;
    }
}
