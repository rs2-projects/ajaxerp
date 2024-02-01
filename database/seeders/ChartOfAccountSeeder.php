<?php

namespace Database\Seeders;

use App\Models\Accounting\AccCoaAccount;
use App\Models\Accounting\AccCoaCategory;
use App\Models\Accounting\AccCoaSubCategory;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ChartOfAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    const TYPE_ASSETS_TEXT = 'assets';
    const TYPE_LIABILITIES_CREDIT_CARDS_TEXT = 'liabilities_and_credit_cards';
    const TYPE_INCOME_TEXT = 'income';
    const TYPE_EXPENSES_TEXT = 'expenses';
    const TYPE_EQUITY_TEXT = 'equity';
    const TYPES_TEXT = [
        self::TYPE_ASSETS_TEXT => 0,
        self::TYPE_LIABILITIES_CREDIT_CARDS_TEXT => 1,
        self::TYPE_INCOME_TEXT => 2,
        self::TYPE_EXPENSES_TEXT => 3,
        self::TYPE_EQUITY_TEXT => 4,
    ];

    const IS_ACCOUNT_TYPE_NO_TEXT = 'non_accounts';
    const IS_ACCOUNT_TYPE_YES_TEXT = 'accounts';
    const IS_ACCOUNT_TYPES_TEXT = [
        self::IS_ACCOUNT_TYPE_NO_TEXT => 0,
        self::IS_ACCOUNT_TYPE_YES_TEXT => 1,
    ];

    public function run(): void
    {
        DB::beginTransaction();
        try {

            $chart_of_accounts = config('coaData.chart_of_accounts');

            foreach ($chart_of_accounts as $category_type => $coas) {

                $category = AccCoaCategory::create([
                    'name' => $coas['name'],
                    'type' => self::TYPES_TEXT[$category_type],
                    'description' => $coas['description'],
                    'created_at' => Carbon::now(),
                    'created_by' => 1, // 1 is admin
                    'updated_at' => Carbon::now(),
                    'updated_by' => 1, // 1 is admin
                ]);
                if (count($coas['sub_categories']) > 0) {
                    foreach ($coas['sub_categories'] as $coa_sub) {

                        $sub_category = AccCoaSubCategory::create([
                            'acc_coa_category_id' => $category->id,
                            'name' => $coa_sub['name'],
                            'slug' => $coa_sub['slug'] ?? null,
                            'is_account_type' => self::IS_ACCOUNT_TYPES_TEXT[$coa_sub['type']],
                            'description' => $coa_sub['description'],
                            'can_create_account' => $coa_sub['can_create_account'] ?? 1,
                            'is_sales_tax' => $coa_sub['is_sales_tax'] ?? 0,
                            'created_at' => Carbon::now(),
                            'created_by' => 1, // 1 is admin
                            'updated_at' => Carbon::now(),
                            'updated_by' => 1, // 1 is admin
                        ]);

                        if (count($coa_sub['accounts']) > 0) {
                            foreach ($coa_sub['accounts'] as $coa_accounts) {
                                $account = AccCoaAccount::create([
                                    'acc_coa_category_id' => $category->id,
                                    'acc_coa_sub_category_id' => $sub_category->id,
                                    'name' => $coa_accounts['name'],
                                    'slug' => $coa_accounts['slug'] ?? null,
                                    'account_no' => null,
                                    'opening_balance' => 0,
                                    'available_balance' => 0,
                                    'description' => $coa_accounts['description'],
                                    'can_edit' => $coa_accounts['can_edit'] ?? 1,
                                    'is_default' => $coa_accounts['is_default'] ?? 0,
                                    'created_at' => Carbon::now(),
                                    'created_by' => 1, // 1 is admin
                                    'updated_at' => Carbon::now(),
                                    'updated_by' => 1, // 1 is admin
                                ]);
                            }
                        }
                    }
                }
            }
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::info("Chart Of Accounts Create is error. ::".$exception->getMessage());
        }
        DB::commit();

    }
}
