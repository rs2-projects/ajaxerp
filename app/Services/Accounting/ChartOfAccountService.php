<?php

namespace App\Services\Accounting;

use App\Helpers\MakeSlugHelper;
use App\Models\Accounting\AccCoaAccount;
use App\Models\Accounting\AccCoaCategory;
use App\Models\Accounting\AccCoaSubCategory;
use Carbon\Carbon;

class ChartOfAccountService
{
    public function __construct(){
        $this->paginate_limit = config('commonData.paginate_limit');
    }

    public function indexData()
    {
        $data['coa_categories'] = AccCoaCategory::with('subcategories')
            ->where('deleted', AccCoaCategory::DELETED_NO)
            ->where('status', AccCoaCategory::STATUS_ACTIVE)
            ->orderBy('name', 'asc')
            ->get();

        return $data;
    }

    public function indexFilteredData($request)
    {
        $data['coa_categories'] = AccCoaCategory::with('subcategories')
            ->where('deleted', AccCoaCategory::DELETED_NO)
            ->where('status', AccCoaCategory::STATUS_ACTIVE)
            ->orderBy('name', 'asc')
            ->get();

        return $data;
    }

    public function storeAccount($request)
    {
        try {
            $coa_sub_category = AccCoaSubCategory::where('id', $request->acc_coa_sub_category_id)
               ->where('deleted', AccCoaSubCategory::DELETED_NO)
                ->first();
            if (empty($coa_sub_category)) {
                throw new \Exception('Invalid sub category');
            }

            $slug = MakeSlugHelper::makeAccCoaAccountSlug($request->account_name);

            $coa_account = new AccCoaAccount();
            $coa_account->acc_coa_category_id = $coa_sub_category->acc_coa_category_id;
            $coa_account->acc_coa_sub_category_id = $coa_sub_category->id;
            $coa_account->name = $request->account_name;
            $coa_account->slug = $slug;
            $coa_account->account_no = $request->account_no;
            $coa_account->opening_balance = 0;
            $coa_account->available_balance = 0;
            $coa_account->description = $request->description;
            $coa_account->is_default = AccCoaAccount::IS_DEFAULT_NO;
            $coa_account->can_edit = AccCoaAccount::CAN_EDIT_YES;
            $coa_account->created_at = Carbon::now();
            $coa_account->created_by = auth()->user()->id;
            $coa_account->updated_at = Carbon::now();
            $coa_account->updated_by = auth()->user()->id;
            $coa_account->save();


        }catch (\Exception $e){
            throw new \Exception($e->getMessage());
        }
    }

    public function editAccountData($id)
    {
        $data['coa_account'] = AccCoaAccount::where('id', $id)
            ->where('deleted', AccCoaAccount::DELETED_NO)
            ->first();
        if (empty($data['coa_account'])) {
            throw new \Exception('Invalid account');
        }

        $data['coa_categories'] = AccCoaCategory::where('deleted', AccCoaCategory::DELETED_NO)
            ->where('status', AccCoaCategory::STATUS_ACTIVE)
            ->orderBy('name', 'asc')
            ->get();

        return $data;
    }

    public function updateAccount($request, $id)
    {
        try {
            $coa_account = AccCoaAccount::where('id', $id)
                ->where('deleted', AccCoaAccount::DELETED_NO)
                ->first();
            if (empty($coa_account)) {
                throw new \Exception('Invalid account');
            }

            $coa_sub_category = AccCoaSubCategory::where('id', $request->acc_coa_sub_category_id)
                ->where('deleted', AccCoaSubCategory::DELETED_NO)
                ->first();
            if (empty($coa_sub_category)) {
                throw new \Exception('Invalid sub category');
            }

            $coa_account->acc_coa_category_id = $coa_sub_category->acc_coa_category_id;
            $coa_account->acc_coa_sub_category_id = $coa_sub_category->id;
            $coa_account->name = $request->account_name;
            $coa_account->account_no = $request->account_no;
            $coa_account->description = $request->description;
            $coa_account->updated_at = Carbon::now();
            $coa_account->updated_by = auth()->user()->id;
            $coa_account->save();

        }catch (\Exception $e){
            throw new \Exception($e->getMessage());
        }
    }
}
