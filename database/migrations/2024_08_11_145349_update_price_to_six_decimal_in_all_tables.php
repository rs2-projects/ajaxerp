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
        Schema::table('product_material_purchase_calculated_prices', function (Blueprint $table) {
            $table->unsignedDecimal('price', 16, 6)->default(0)->change();
            $table->unsignedDecimal('exchange_rate', 16, 6)->default(0)->change();
            $table->unsignedDecimal('price_usd', 16, 6)->default(0)->change();
            $table->unsignedDecimal('price_fob', 16, 6)->default(0)->change();
            $table->unsignedDecimal('cbm', 16, 6)->default(0)->change();
            $table->unsignedDecimal('total_pieces_per_container', 16, 6)->default(0)->change();
            $table->unsignedDecimal('freight_cost_usd', 16, 6)->default(0)->change();
            $table->unsignedDecimal('exchange_rate_after_import', 16, 6)->default(0)->change();
            $table->unsignedDecimal('freight_cost', 16, 6)->default(0)->change();
            $table->unsignedDecimal('total_taxes_import_duties', 16, 6)->default(0)->change();
            $table->unsignedDecimal('taxes_import_duties', 16, 6)->default(0)->change();
            $table->unsignedDecimal('total_transport_cost_to_wh', 16, 6)->default(0)->change();
            $table->unsignedDecimal('transport_cost_to_wh', 16, 6)->default(0)->change();
            $table->unsignedDecimal('total_unloading_cost', 16, 6)->default(0)->change();
            $table->unsignedDecimal('unloading_cost', 16, 6)->default(0)->change();
            $table->unsignedDecimal('handling_cost', 16, 6)->default(0)->change();
            $table->unsignedDecimal('price_excluding_vat', 16, 6)->default(0)->change();
            $table->unsignedDecimal('vat_percent', 16, 6)->default(0)->change();
            $table->unsignedDecimal('vat', 16, 6)->default(0)->change();
            $table->unsignedDecimal('final_price', 16, 6)->default(0)->change();
            $table->unsignedDecimal('total_final_price', 16, 6)->default(0)->change();
        });

        Schema::table('acc_coa_accounts', function (Blueprint $table) {
            $table->unsignedDecimal('tax_rate', 16, 6)->default(0)->change();
            $table->unsignedDecimal('opening_balance', 16, 6)->default(0)->change();
            $table->unsignedDecimal('available_balance', 16, 6)->default(0)->change();
        });

        Schema::table('asset_product_purchase_orders', function (Blueprint $table) {
            $table->unsignedDecimal('php_rate', 16, 6)->default(0)->change();
            $table->unsignedDecimal('subtotal_amount', 16, 6)->default(0)->change();
            $table->unsignedDecimal('subtotal_amount_php', 16, 6)->default(0)->change();
            $table->unsignedDecimal('total_vat_amount', 16, 6)->default(0)->change();
            $table->unsignedDecimal('total_vat_amount_php', 16, 6)->default(0)->change();
            $table->unsignedDecimal('discount_value', 16, 6)->default(0)->change();
            $table->unsignedDecimal('total_discount_amount', 16, 6)->default(0)->change();
            $table->unsignedDecimal('total_discount_amount_php', 16, 6)->default(0)->change();
            $table->unsignedDecimal('payable_amount', 16, 6)->default(0)->change();
            $table->unsignedDecimal('payable_amount_php', 16, 6)->default(0)->change();
            $table->unsignedDecimal('paid_amount', 16, 6)->default(0)->change();
            $table->unsignedDecimal('paid_amount_php', 16, 6)->default(0)->change();
            $table->unsignedDecimal('due_amount', 16, 6)->default(0)->change();
            $table->unsignedDecimal('due_amount_php', 16, 6)->default(0)->change();
        });

        Schema::table('asset_product_purchase_order_details', function (Blueprint $table) {
            $table->unsignedDecimal('unit_price', 16, 6)->default(0)->change();
            $table->unsignedDecimal('unit_price_php', 16, 6)->default(0)->change();
            $table->unsignedDecimal('total_price', 16, 6)->default(0)->change();
            $table->unsignedDecimal('total_price_php', 16, 6)->default(0)->change();
            $table->unsignedDecimal('tax_rate', 16, 6)->default(0)->change();
            $table->unsignedDecimal('tax_amount', 16, 6)->default(0)->change();
            $table->unsignedDecimal('tax_amount_php', 16, 6)->default(0)->change();
            $table->unsignedDecimal('net_total', 16, 6)->default(0)->change();
            $table->unsignedDecimal('net_total_php', 16, 6)->default(0)->change();
        });

        Schema::table('asset_product_purchase_payments', function (Blueprint $table) {
            $table->unsignedDecimal('amount', 16, 6)->default(0)->change();
            $table->unsignedDecimal('amount_php', 16, 6)->default(0)->change();
        });

        Schema::table('board_pre_production_calculated_prices', function (Blueprint $table) {
            $table->unsignedDecimal('landed_cost_excluding_vat', 16, 6)->default(0)->change();
            $table->unsignedDecimal('machine_cost', 16, 6)->default(0)->change();
            $table->unsignedDecimal('paper_up_cost', 16, 6)->default(0)->change();
            $table->unsignedDecimal('plate_up_cost', 16, 6)->default(0)->change();
            $table->unsignedDecimal('paper_down_cost', 16, 6)->default(0)->change();
            $table->unsignedDecimal('plate_down_cost', 16, 6)->default(0)->change();
            $table->unsignedDecimal('vat_percent', 16, 6)->default(0)->change();
            $table->unsignedDecimal('retail_percent', 16, 6)->default(0)->change();
            $table->unsignedDecimal('discount_percent', 16, 6)->default(0)->change();
            $table->unsignedDecimal('total_production_cost_excluding_vat', 16, 6)->default(0)->change();
            $table->unsignedDecimal('retail_price', 16, 6)->default(0)->change();
            $table->unsignedDecimal('price_excluding_vat', 16, 6)->default(0)->change();
            $table->unsignedDecimal('vat', 16, 6)->default(0)->change();
            $table->unsignedDecimal('discount_wholesale', 16, 6)->default(0)->change();
        });

        Schema::table('invoices', function (Blueprint $table) {
            $table->unsignedDecimal('subtotal_amount', 16, 6)->default(0)->change();
            $table->unsignedDecimal('vat_amount', 16, 6)->default(0)->change();
            $table->unsignedDecimal('total_amount', 16, 6)->default(0)->change();
            $table->unsignedDecimal('discount_value', 16, 6)->default(0)->change();
            $table->unsignedDecimal('discount_amount', 16, 6)->default(0)->change();
            $table->unsignedDecimal('payable_amount', 16, 6)->default(0)->change();
            $table->unsignedDecimal('paid_amount', 16, 6)->default(0)->change();
            $table->unsignedDecimal('due_amount', 16, 6)->default(0)->change();
        });

        Schema::table('invoice_details', function (Blueprint $table) {
            $table->unsignedDecimal('unit_price', 16, 6)->default(0)->change();
            $table->unsignedDecimal('total', 16, 6)->default(0)->change();
            $table->unsignedDecimal('tax_rate', 16, 6)->default(0)->change();
            $table->unsignedDecimal('tax_amount', 16, 6)->default(0)->change();
            $table->unsignedDecimal('net_total', 16, 6)->default(0)->change();
        });

        Schema::table('invoice_details', function (Blueprint $table) {
            $table->unsignedDecimal('unit_price', 16, 6)->default(0)->change();
            $table->unsignedDecimal('total', 16, 6)->default(0)->change();
            $table->unsignedDecimal('tax_rate', 16, 6)->default(0)->change();
            $table->unsignedDecimal('tax_amount', 16, 6)->default(0)->change();
            $table->unsignedDecimal('net_total', 16, 6)->default(0)->change();
        });

        Schema::table('invoice_payments', function (Blueprint $table) {
            $table->unsignedDecimal('amount', 16, 6)->default(0)->change();
        });

        Schema::table('machines', function (Blueprint $table) {
            $table->unsignedDecimal('production_cost', 16, 6)->default(0)->change();
        });

        Schema::table('product_materials', function (Blueprint $table) {
            $table->unsignedDecimal('rp_cost', 16, 6)->default(0)->change();
            $table->unsignedDecimal('srp_markup_percent', 16, 6)->default(0)->change();
            $table->unsignedDecimal('wholesale_discount_percent', 16, 6)->default(0)->change();
            $table->unsignedDecimal('rp_srp', 16, 6)->default(0)->change();
            $table->unsignedDecimal('srp_with_discount', 16, 6)->default(0)->change();
            $table->unsignedDecimal('wholesale', 16, 6)->default(0)->change();
        });

        Schema::table('product_material_purchases', function (Blueprint $table) {
            $table->unsignedDecimal('php_rate', 16, 6)->default(0)->change();
            $table->unsignedDecimal('subtotal_amount_php', 16, 6)->default(0)->change();
            $table->unsignedDecimal('total_vat_amount_php', 16, 6)->default(0)->change();
            $table->unsignedDecimal('total_discount_amount_php', 16, 6)->default(0)->change();
            $table->unsignedDecimal('payable_amount_php', 16, 6)->default(0)->change();
            $table->unsignedDecimal('paid_amount_php', 16, 6)->default(0)->change();
            $table->unsignedDecimal('due_amount_php', 16, 6)->default(0)->change();
            $table->unsignedDecimal('subtotal_amount', 16, 6)->default(0)->change();
            $table->unsignedDecimal('total_vat_amount', 16, 6)->default(0)->change();
            $table->unsignedDecimal('discount_value', 16, 6)->default(0)->change();
            $table->unsignedDecimal('total_discount_amount', 16, 6)->default(0)->change();
            $table->unsignedDecimal('payable_amount', 16, 6)->default(0)->change();
            $table->unsignedDecimal('paid_amount', 16, 6)->default(0)->change();
            $table->unsignedDecimal('due_amount', 16, 6)->default(0)->change();
        });

        Schema::table('product_material_purchase_details', function (Blueprint $table) {
            $table->unsignedDecimal('unit_price_php', 16, 6)->default(0)->change();
            $table->unsignedDecimal('total_price_php', 16, 6)->default(0)->change();
            $table->unsignedDecimal('tax_amount_php', 16, 6)->default(0)->change();
            $table->unsignedDecimal('net_total_php', 16, 6)->default(0)->change();
            $table->unsignedDecimal('unit_price', 16, 6)->default(0)->change();
            $table->unsignedDecimal('total_price', 16, 6)->default(0)->change();
            $table->unsignedDecimal('tax_rate', 16, 6)->default(0)->change();
            $table->unsignedDecimal('tax_amount', 16, 6)->default(0)->change();
            $table->unsignedDecimal('net_total', 16, 6)->default(0)->change();
        });

        Schema::table('product_material_purchase_payments', function (Blueprint $table) {
            $table->unsignedDecimal('amount_php', 16, 6)->default(0)->change();
            $table->unsignedDecimal('amount', 16, 6)->default(0)->change();
        });

        Schema::table('product_material_sets', function (Blueprint $table) {
            $table->unsignedDecimal('rp_cost', 16, 6)->default(0)->change();
            $table->unsignedDecimal('srp_markup_percent', 16, 6)->default(0)->change();
            $table->unsignedDecimal('wholesale_discount_percent', 16, 6)->default(0)->change();
            $table->unsignedDecimal('rp_srp', 16, 6)->default(0)->change();
            $table->unsignedDecimal('srp_with_discount', 16, 6)->default(0)->change();
            $table->unsignedDecimal('wholesale', 16, 6)->default(0)->change();
        });

        Schema::table('product_material_set_items', function (Blueprint $table) {
            $table->unsignedDecimal('rp_cost', 16, 6)->default(0)->change();
            $table->unsignedDecimal('rp_srp', 16, 6)->default(0)->change();
            $table->unsignedDecimal('srp_with_discount', 16, 6)->default(0)->change();
            $table->unsignedDecimal('wholesale', 16, 6)->default(0)->change();
        });

        Schema::table('salaries', function (Blueprint $table) {
            $table->unsignedDecimal('total_salary_amount', 16, 6)->default(0)->change();
            $table->unsignedDecimal('total_bonus_amount', 16, 6)->default(0)->change();
            $table->unsignedDecimal('total_deduction_amount', 16, 6)->default(0)->change();
            $table->unsignedDecimal('total_amount_to_pay', 16, 6)->default(0)->change();
            $table->unsignedDecimal('total_amount_paid', 16, 6)->default(0)->change();
        });

        Schema::table('salary_bonus_types', function (Blueprint $table) {
            $table->unsignedDecimal('total_bonus_amount', 16, 6)->default(0)->change();
            $table->unsignedDecimal('total_deduction_amount', 16, 6)->default(0)->change();
            $table->unsignedDecimal('total_amount_to_pay', 16, 6)->default(0)->change();
            $table->unsignedDecimal('total_amount_paid', 16, 6)->default(0)->change();
        });

        Schema::table('salary_details', function (Blueprint $table) {
            $table->unsignedDecimal('monthly_basic_salary', 16, 6)->default(0)->change();
            $table->unsignedDecimal('daily_basic_salary', 16, 6)->default(0)->change();
            $table->unsignedDecimal('net_basic_salary', 16, 6)->default(0)->change();
            $table->unsignedDecimal('monthly_total_added_salary', 16, 6)->default(0)->change();
            $table->unsignedDecimal('total_added_salary', 16, 6)->default(0)->change();
            $table->unsignedDecimal('monthly_total_deducted_salary', 16, 6)->default(0)->change();
            $table->unsignedDecimal('total_deducted_salary', 16, 6)->default(0)->change();
            $table->unsignedDecimal('monthly_salary', 16, 6)->default(0)->change();
            $table->unsignedDecimal('daily_salary', 16, 6)->default(0)->change();
            $table->unsignedDecimal('current_period_salary', 16, 6)->default(0)->change();
            $table->unsignedDecimal('absent_day_rate', 16, 6)->default(0)->change();
            $table->unsignedDecimal('absent_day_amount_per_day', 16, 6)->default(0)->change();
            $table->unsignedDecimal('absent_day_amount', 16, 6)->default(0)->change();
            $table->unsignedDecimal('extra_leave_amount', 16, 6)->default(0)->change();
            $table->unsignedDecimal('normal_day_overtime_rate_per_hour', 16, 6)->default(0)->change();
            $table->unsignedDecimal('normal_day_overtime_rate_per_minute', 16, 6)->default(0)->change();
            $table->unsignedDecimal('normal_day_overtime_amount', 16, 6)->default(0)->change();
            $table->unsignedDecimal('special_day_overtime_rate_per_hour', 16, 6)->default(0)->change();
            $table->unsignedDecimal('special_day_overtime_rate_per_minute', 16, 6)->default(0)->change();
            $table->unsignedDecimal('special_day_overtime_amount', 16, 6)->default(0)->change();
            $table->unsignedDecimal('late_rate_per_hour', 16, 6)->default(0)->change();
            $table->unsignedDecimal('late_rate_per_minute', 16, 6)->default(0)->change();
            $table->unsignedDecimal('late_amount', 16, 6)->default(0)->change();
            $table->unsignedDecimal('early_departure_rate_per_hour', 16, 6)->default(0)->change();
            $table->unsignedDecimal('early_departure_rate_per_minute', 16, 6)->default(0)->change();
            $table->unsignedDecimal('early_departure_amount', 16, 6)->default(0)->change();
            $table->unsignedDecimal('total_bonus_amount', 16, 6)->default(0)->change();
            $table->unsignedDecimal('deduction_rate_type', 16, 6)->default(0)->change();
            $table->unsignedDecimal('deduction_salary_type', 16, 6)->default(0)->change();
            $table->unsignedDecimal('deduction_rate', 16, 6)->default(0)->change();
            $table->unsignedDecimal('deduction_amount', 16, 6)->default(0)->change();
            $table->unsignedDecimal('custom_add_amount', 16, 6)->default(0)->change();
            $table->unsignedDecimal('custom_deduct_amount', 16, 6)->default(0)->change();
            $table->unsignedDecimal('net_payable_salary', 16, 6)->default(0)->change();
            $table->unsignedDecimal('paid_salary', 16, 6)->default(0)->change();
        });

        Schema::table('salary_details_addition_deductions', function (Blueprint $table) {
            $table->unsignedDecimal('rate', 16, 6)->default(0)->change();
            $table->unsignedDecimal('amount', 16, 6)->default(0)->change();
        });

        Schema::table('salary_details_bonuses', function (Blueprint $table) {
            $table->unsignedDecimal('bonus_rate', 16, 6)->default(0)->change();
            $table->unsignedDecimal('bonus_amount', 16, 6)->default(0)->change();
        });

        Schema::table('salary_details_leaves', function (Blueprint $table) {
            $table->unsignedDecimal('rate', 16, 6)->default(0)->change();
            $table->unsignedDecimal('amount', 16, 6)->default(0)->change();
        });

        Schema::table('salary_settings_salary_sets', function (Blueprint $table) {
            $table->unsignedDecimal('total_salary_amount', 16, 6)->default(0)->change();
            $table->unsignedDecimal('total_bonus_amount', 16, 6)->default(0)->change();
            $table->unsignedDecimal('total_deduction_amount', 16, 6)->default(0)->change();
            $table->unsignedDecimal('total_amount_to_pay', 16, 6)->default(0)->change();
            $table->unsignedDecimal('total_amount_paid', 16, 6)->default(0)->change();
        });

        Schema::table('settings_absent_penalties', function (Blueprint $table) {
            $table->unsignedDecimal('rate', 16, 6)->default(0)->change();
        });

        Schema::table('settings_bonus_type_salary_bonuses', function (Blueprint $table) {
            $table->unsignedDecimal('rate', 16, 6)->default(0)->change();
        });

        Schema::table('settings_late_penalties', function (Blueprint $table) {
            $table->unsignedDecimal('rate', 16, 6)->default(0)->change();
        });

        Schema::table('settings_leave_types', function (Blueprint $table) {
            $table->unsignedDecimal('rate', 16, 6)->default(0)->change();
        });

        Schema::table('settings_overtime_types', function (Blueprint $table) {
            $table->unsignedDecimal('rate', 16, 6)->default(0)->change();
            $table->unsignedDecimal('special_rate', 16, 6)->default(0)->change();
        });

        Schema::table('settings_salary_deduction_types', function (Blueprint $table) {
            $table->unsignedDecimal('rate', 16, 6)->default(0)->change();
        });

        Schema::table('settings_salary_set_employees', function (Blueprint $table) {
            $table->unsignedDecimal('basic_salary', 16, 6)->default(0)->change();
        });

        Schema::table('settings_salary_set_employee_update_histories', function (Blueprint $table) {
            $table->unsignedDecimal('basic_salary', 16, 6)->default(0)->change();
        });

        Schema::table('settings_salary_set_employee_update_histories', function (Blueprint $table) {
            $table->unsignedDecimal('basic_salary', 16, 6)->default(0)->change();
        });

        Schema::table('settings_salary_type_details', function (Blueprint $table) {
            $table->unsignedDecimal('value', 16, 6)->default(0)->change();
        });

        Schema::table('settings_salary_type_details', function (Blueprint $table) {
            $table->unsignedDecimal('value', 16, 6)->default(0)->change();
        });

        // completed upto transactions
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        
    }
};
