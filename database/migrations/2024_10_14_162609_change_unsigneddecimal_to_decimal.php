<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('acc_coa_accounts', function (Blueprint $table) {
            $table->decimal('tax_rate', 16, 6)->default(0)->change();
            $table->decimal('opening_balance', 16, 6)->default(0)->change();
            $table->decimal('available_balance', 16, 6)->default(0)->change();
        });

        Schema::table('asset_product_purchase_orders', function (Blueprint $table) {
            $table->decimal('php_rate', 16, 6)->default(0)->change();
            $table->decimal('subtotal_amount', 16, 6)->default(0)->change();
            $table->decimal('subtotal_amount_php', 16, 6)->default(0)->change();
            $table->decimal('total_vat_amount', 16, 6)->default(0)->change();
            $table->decimal('total_vat_amount_php', 16, 6)->default(0)->change();
            $table->decimal('discount_value', 16, 6)->default(0)->change();
            $table->decimal('total_discount_amount', 16, 6)->default(0)->change();
            $table->decimal('total_discount_amount_php', 16, 6)->default(0)->change();
            $table->decimal('payable_amount', 16, 6)->default(0)->change();
            $table->decimal('payable_amount_php', 16, 6)->default(0)->change();
            $table->decimal('paid_amount', 16, 6)->default(0)->change();
            $table->decimal('paid_amount_php', 16, 6)->default(0)->change();
            $table->decimal('due_amount', 16, 6)->default(0)->change();
            $table->decimal('due_amount_php', 16, 6)->default(0)->change();
        });

        Schema::table('asset_product_purchase_order_details', function (Blueprint $table) {
            $table->decimal('unit_price', 16, 6)->default(0)->change();
            $table->decimal('unit_price_php', 16, 6)->default(0)->change();
            $table->decimal('total_price', 16, 6)->default(0)->change();
            $table->decimal('total_price_php', 16, 6)->default(0)->change();
            $table->decimal('tax_rate', 16, 6)->default(0)->change();
            $table->decimal('tax_amount', 16, 6)->default(0)->change();
            $table->decimal('tax_amount_php', 16, 6)->default(0)->change();
            $table->decimal('net_total', 16, 6)->default(0)->change();
            $table->decimal('net_total_php', 16, 6)->default(0)->change();
        });

        Schema::table('asset_product_purchase_payments', function (Blueprint $table) {
            $table->decimal('amount', 16, 6)->default(0)->change();
            $table->decimal('amount_php', 16, 6)->default(0)->change();
        });

        Schema::table('invoices', function (Blueprint $table) {
            $table->decimal('subtotal_amount', 16, 6)->default(0)->change();
            $table->decimal('vat_amount', 16, 6)->default(0)->change();
            $table->decimal('total_amount', 16, 6)->default(0)->change();
            $table->decimal('discount_value', 16, 6)->default(0)->change();
            $table->decimal('discount_amount', 16, 6)->default(0)->change();
            $table->decimal('payable_amount', 16, 6)->default(0)->change();
            $table->decimal('paid_amount', 16, 6)->default(0)->change();
            $table->decimal('due_amount', 16, 6)->default(0)->change();
        });

        Schema::table('invoice_details', function (Blueprint $table) {
            $table->decimal('tax_rate', 16, 6)->default(0)->change();
            $table->decimal('tax_amount', 16, 6)->default(0)->change();
            $table->decimal('net_total', 16, 6)->default(0)->change();
        });

        Schema::table('invoice_payments', function (Blueprint $table) {
            $table->decimal('amount', 16, 6)->default(0)->change();
        });

        Schema::table('machines', function (Blueprint $table) {
            $table->decimal('production_cost', 16, 6)->default(0)->change();
        });

        Schema::table('product_materials', function (Blueprint $table) {
            $table->decimal('rp_cost', 16, 6)->default(0)->change();
            $table->decimal('srp_markup_percent', 16, 6)->default(0)->change();
            $table->decimal('wholesale_discount_percent', 16, 6)->default(0)->change();
            $table->decimal('rp_srp', 16, 6)->default(0)->change();
            $table->decimal('srp_with_discount', 16, 6)->default(0)->change();
            $table->decimal('wholesale', 16, 6)->default(0)->change();
        });

        Schema::table('product_material_purchases', function (Blueprint $table) {
            $table->decimal('php_rate', 16, 6)->default(0)->change();
            $table->decimal('subtotal_amount_php', 16, 6)->default(0)->change();
            $table->decimal('total_vat_amount_php', 16, 6)->default(0)->change();
            $table->decimal('total_discount_amount_php', 16, 6)->default(0)->change();
            $table->decimal('payable_amount_php', 16, 6)->default(0)->change();
            $table->decimal('paid_amount_php', 16, 6)->default(0)->change();
            $table->decimal('due_amount_php', 16, 6)->default(0)->change();
            $table->decimal('subtotal_amount', 16, 6)->default(0)->change();
            $table->decimal('total_vat_amount', 16, 6)->default(0)->change();
            $table->decimal('discount_value', 16, 6)->default(0)->change();
            $table->decimal('total_discount_amount', 16, 6)->default(0)->change();
            $table->decimal('payable_amount', 16, 6)->default(0)->change();
            $table->decimal('paid_amount', 16, 6)->default(0)->change();
            $table->decimal('due_amount', 16, 6)->default(0)->change();
        });
        
        Schema::table('product_material_purchase_details', function (Blueprint $table) {
            $table->decimal('unit_price_php', 16, 6)->default(0)->change();
            $table->decimal('total_price_php', 16, 6)->default(0)->change();
            $table->decimal('tax_amount_php', 16, 6)->default(0)->change();
            $table->decimal('net_total_php', 16, 6)->default(0)->change();
            $table->decimal('unit_price', 16, 6)->default(0)->change();
            $table->decimal('total_price', 16, 6)->default(0)->change();
            $table->decimal('tax_rate', 16, 6)->default(0)->change();
            $table->decimal('tax_amount', 16, 6)->default(0)->change();
            $table->decimal('net_total', 16, 6)->default(0)->change();
        });

        Schema::table('product_material_purchase_payments', function (Blueprint $table) {
            $table->decimal('amount_php', 16, 6)->default(0)->change();
            $table->decimal('amount', 16, 6)->default(0)->change();
        });

        Schema::table('product_material_sets', function (Blueprint $table) {
            $table->decimal('rp_cost', 16, 6)->default(0)->change();
            $table->decimal('srp_markup_percent', 16, 6)->default(0)->change();
            $table->decimal('wholesale_discount_percent', 16, 6)->default(0)->change();
            $table->decimal('rp_srp', 16, 6)->default(0)->change();
            $table->decimal('srp_with_discount', 16, 6)->default(0)->change();
            $table->decimal('wholesale', 16, 6)->default(0)->change();
        });

        Schema::table('product_material_set_items', function (Blueprint $table) {
            $table->decimal('rp_cost', 16, 6)->default(0)->change();
            $table->decimal('rp_srp', 16, 6)->default(0)->change();
            $table->decimal('srp_with_discount', 16, 6)->default(0)->change();
            $table->decimal('wholesale', 16, 6)->default(0)->change();
        });

        Schema::table('salaries', function (Blueprint $table) {
            $table->decimal('total_salary_amount', 16, 6)->default(0)->change();
            $table->decimal('total_bonus_amount', 16, 6)->default(0)->change();
            $table->decimal('total_deduction_amount', 16, 6)->default(0)->change();
            $table->decimal('total_amount_to_pay', 16, 6)->default(0)->change();
            $table->decimal('total_amount_paid', 16, 6)->default(0)->change();
        });

        Schema::table('salary_bonus_types', function (Blueprint $table) {
            $table->decimal('total_bonus_amount', 16, 6)->default(0)->change();
        });

        Schema::table('salary_details', function (Blueprint $table) {
            $table->decimal('monthly_basic_salary', 16, 6)->default(0)->change();
            $table->decimal('daily_basic_salary', 16, 6)->default(0)->change();
            $table->decimal('net_basic_salary', 16, 6)->default(0)->change();
            $table->decimal('monthly_total_added_salary', 16, 6)->default(0)->change();
            $table->decimal('total_added_salary', 16, 6)->default(0)->change();
            $table->decimal('monthly_total_deducted_salary', 16, 6)->default(0)->change();
            $table->decimal('total_deducted_salary', 16, 6)->default(0)->change();
            $table->decimal('monthly_salary', 16, 6)->default(0)->change();
            $table->decimal('daily_salary', 16, 6)->default(0)->change();
            $table->decimal('current_period_salary', 16, 6)->default(0)->change();
            $table->decimal('absent_day_rate', 16, 6)->default(0)->change();
            $table->decimal('absent_day_amount_per_day', 16, 6)->default(0)->change();
            $table->decimal('absent_day_amount', 16, 6)->default(0)->change();
            $table->decimal('extra_leave_amount', 16, 6)->default(0)->change();
            $table->decimal('normal_day_overtime_rate_per_hour', 16, 6)->default(0)->change();
            $table->decimal('normal_day_overtime_rate_per_minute', 16, 6)->default(0)->change();
            $table->decimal('normal_day_overtime_amount', 16, 6)->default(0)->change();
            $table->decimal('special_day_overtime_rate_per_hour', 16, 6)->default(0)->change();
            $table->decimal('special_day_overtime_rate_per_minute', 16, 6)->default(0)->change();
            $table->decimal('special_day_overtime_amount', 16, 6)->default(0)->change();
            $table->decimal('late_rate_per_hour', 16, 6)->default(0)->change();
            $table->decimal('late_rate_per_minute', 16, 6)->default(0)->change();
            $table->decimal('late_amount', 16, 6)->default(0)->change();
            $table->decimal('early_departure_rate_per_hour', 16, 6)->default(0)->change();
            $table->decimal('early_departure_rate_per_minute', 16, 6)->default(0)->change();
            $table->decimal('early_departure_amount', 16, 6)->default(0)->change();
            $table->decimal('total_bonus_amount', 16, 6)->default(0)->change();
            $table->decimal('deduction_rate_type', 16, 6)->default(0)->change();
            $table->decimal('deduction_salary_type', 16, 6)->default(0)->change();
            $table->decimal('deduction_rate', 16, 6)->default(0)->change();
            $table->decimal('deduction_amount', 16, 6)->default(0)->change();
            $table->decimal('custom_add_amount', 16, 6)->default(0)->change();
            $table->decimal('custom_deduct_amount', 16, 6)->default(0)->change();
            $table->decimal('net_payable_salary', 16, 6)->default(0)->change();
            $table->decimal('paid_salary', 16, 6)->default(0)->change();
        });

        Schema::table('salary_details_addition_deductions', function (Blueprint $table) {
            $table->decimal('rate', 16, 6)->default(0)->change();
            $table->decimal('amount', 16, 6)->default(0)->change();
        });

        Schema::table('salary_details_bonuses', function (Blueprint $table) {
            $table->decimal('bonus_rate', 16, 6)->default(0)->change();
            $table->decimal('bonus_amount', 16, 6)->default(0)->change();
        });

        Schema::table('salary_details_leaves', function (Blueprint $table) {
            $table->decimal('rate', 16, 6)->default(0)->change();
            $table->decimal('amount', 16, 6)->default(0)->change();
        });

        Schema::table('salary_settings_salary_sets', function (Blueprint $table) {
            $table->decimal('total_salary_amount', 16, 6)->default(0)->change();
            $table->decimal('total_bonus_amount', 16, 6)->default(0)->change();
            $table->decimal('total_deduction_amount', 16, 6)->default(0)->change();
            $table->decimal('total_amount_to_pay', 16, 6)->default(0)->change();
            $table->decimal('total_amount_paid', 16, 6)->default(0)->change();
        });

        Schema::table('settings_absent_penalties', function (Blueprint $table) {
            $table->decimal('rate', 16, 6)->default(0)->change();
        });

        Schema::table('settings_bonus_type_salary_bonuses', function (Blueprint $table) {
            $table->decimal('rate', 16, 6)->default(0)->change();
        });

        Schema::table('settings_late_penalties', function (Blueprint $table) {
            $table->decimal('rate', 16, 6)->default(0)->change();
        });

        Schema::table('settings_leave_types', function (Blueprint $table) {
            $table->decimal('rate', 16, 6)->default(0)->change();
        });

        Schema::table('settings_overtime_types', function (Blueprint $table) {
            $table->decimal('rate', 16, 6)->default(0)->change();
            $table->decimal('special_rate', 16, 6)->default(0)->change();
        });

        Schema::table('settings_salary_deduction_types', function (Blueprint $table) {
            $table->decimal('rate', 16, 6)->default(0)->change();
        });

        Schema::table('settings_salary_set_employees', function (Blueprint $table) {
            $table->decimal('basic_salary', 16, 6)->default(0)->change();
        });

        Schema::table('settings_salary_set_employee_update_histories', function (Blueprint $table) {
            $table->decimal('basic_salary', 16, 6)->default(0)->change();
        });

        Schema::table('settings_salary_set_employee_update_histories', function (Blueprint $table) {
            $table->decimal('basic_salary', 16, 6)->default(0)->change();
        });

        Schema::table('settings_salary_type_details', function (Blueprint $table) {
            $table->decimal('value', 16, 6)->default(0)->change();
        });

        Schema::table('settings_salary_type_details', function (Blueprint $table) {
            $table->decimal('value', 16, 6)->default(0)->change();
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->decimal('total_cost_price', 16, 6)->default(0)->change();
            $table->decimal('net_amount', 16, 6)->default(0)->change();
            $table->decimal('total_vat_amount', 16, 6)->default(0)->change();
            $table->decimal('total_amount', 16, 6)->default(0)->change();
        });

        Schema::table('transaction_vats', function (Blueprint $table) {
            $table->decimal('main_amount', 16, 6)->default(0)->change();
            $table->decimal('vat_percent', 16, 6)->default(0)->change();
            $table->decimal('vat_amount', 16, 6)->default(0)->change();
        });

        Schema::table('user_lifecycles', function (Blueprint $table) {
            $table->decimal('basic_salary', 16, 6)->default(0)->change();
        });

        Schema::table('board_embosseds', function (Blueprint $table) {
            $table->decimal('production_cost', 16, 6)->default(0)->change();
        });

        Schema::table('contractors', function (Blueprint $table) {
            $table->decimal('contract_value', 24, 6)->default(0)->change();
        });

        Schema::table('product_material_categories', function (Blueprint $table) {
            $table->decimal('srp_markup_percent', 24, 6)->default(0)->change();
            $table->decimal('wholesale_discount_percent', 24, 6)->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        
    }
};
