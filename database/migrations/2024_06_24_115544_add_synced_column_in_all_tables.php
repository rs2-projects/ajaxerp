<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        if (!Schema::hasColumn('acc_coa_accounts', 'synced')) {
            Schema::table('acc_coa_accounts', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('acc_coa_categories', 'synced')) {
            Schema::table('acc_coa_categories', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('acc_coa_sub_categories', 'synced')) {
            Schema::table('acc_coa_sub_categories', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('asset_products', 'synced')) {
            Schema::table('asset_products', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('asset_product_assigns', 'synced')) {
            Schema::table('asset_product_assigns', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('asset_product_assign_attachments', 'synced')) {
            Schema::table('asset_product_assign_attachments', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('asset_product_categories', 'synced')) {
            Schema::table('asset_product_categories', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('asset_product_purchase_orders', 'synced')) {
            Schema::table('asset_product_purchase_orders', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('asset_product_purchase_order_damage_files', 'synced')) {
            Schema::table('asset_product_purchase_order_damage_files', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('asset_product_purchase_order_details', 'synced')) {
            Schema::table('asset_product_purchase_order_details', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('asset_product_purchase_payments', 'synced')) {
            Schema::table('asset_product_purchase_payments', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('asset_product_purchase_requests', 'synced')) {
            Schema::table('asset_product_purchase_requests', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('asset_product_purchase_request_details', 'synced')) {
            Schema::table('asset_product_purchase_request_details', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('attendance_histories', 'synced')) {
            Schema::table('attendance_histories', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('attendance_history_todays', 'synced')) {
            Schema::table('attendance_history_todays', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('attendance_reports', 'synced')) {
            Schema::table('attendance_reports', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('board_colors', 'synced')) {
            Schema::table('board_colors', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('board_embosseds', 'synced')) {
            Schema::table('board_embosseds', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('board_pre_productions', 'synced')) {
            Schema::table('board_pre_productions', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('board_pre_production_calculated_prices', 'synced')) {
            Schema::table('board_pre_production_calculated_prices', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('board_pre_production_materials', 'synced')) {
            Schema::table('board_pre_production_materials', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('contractors', 'synced')) {
            Schema::table('contractors', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('contractor_emergency_contacts', 'synced')) {
            Schema::table('contractor_emergency_contacts', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('countries', 'synced')) {
            Schema::table('countries', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('customers', 'synced')) {
            Schema::table('customers', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('customer_banks', 'synced')) {
            Schema::table('customer_banks', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('customer_contacts', 'synced')) {
            Schema::table('customer_contacts', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('departments', 'synced')) {
            Schema::table('departments', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('designations', 'synced')) {
            Schema::table('designations', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('failed_jobs', 'synced')) {
            Schema::table('failed_jobs', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('finished_goods', 'synced')) {
            Schema::table('finished_goods', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('finished_goods_categories', 'synced')) {
            Schema::table('finished_goods_categories', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('finished_goods_racks', 'synced')) {
            Schema::table('finished_goods_racks', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('finished_goods_sections', 'synced')) {
            Schema::table('finished_goods_sections', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('inventory_asset_products', 'synced')) {
            Schema::table('inventory_asset_products', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('inventory_finished_goods', 'synced')) {
            Schema::table('inventory_finished_goods', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('inventory_product_materials', 'synced')) {
            Schema::table('inventory_product_materials', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('invoices', 'synced')) {
            Schema::table('invoices', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('invoice_designs', 'synced')) {
            Schema::table('invoice_designs', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('invoice_details', 'synced')) {
            Schema::table('invoice_details', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('invoice_dispatches', 'synced')) {
            Schema::table('invoice_dispatches', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('invoice_dispatch_details', 'synced')) {
            Schema::table('invoice_dispatch_details', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('invoice_dispatch_details_productions', 'synced')) {
            Schema::table('invoice_dispatch_details_productions', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('invoice_payments', 'synced')) {
            Schema::table('invoice_payments', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('machines', 'synced')) {
            Schema::table('machines', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('migrations', 'synced')) {
            Schema::table('migrations', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('password_reset_tokens', 'synced')) {
            Schema::table('password_reset_tokens', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('permissions', 'synced')) {
            Schema::table('permissions', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('personal_access_tokens', 'synced')) {
            Schema::table('personal_access_tokens', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('pre_productions', 'synced')) {
            Schema::table('pre_productions', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('pre_production_boards', 'synced')) {
            Schema::table('pre_production_boards', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('pre_production_board_deliveries', 'synced')) {
            Schema::table('pre_production_board_deliveries', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('pre_production_board_delivery_details', 'synced')) {
            Schema::table('pre_production_board_delivery_details', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('pre_production_board_delivery_details_items', 'synced')) {
            Schema::table('pre_production_board_delivery_details_items', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('pre_production_materials', 'synced')) {
            Schema::table('pre_production_materials', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('pre_production_material_deliveries', 'synced')) {
            Schema::table('pre_production_material_deliveries', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('pre_production_material_delivery_details', 'synced')) {
            Schema::table('pre_production_material_delivery_details', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('pre_production_material_delivery_details_items', 'synced')) {
            Schema::table('pre_production_material_delivery_details_items', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('pre_production_processes', 'synced')) {
            Schema::table('pre_production_processes', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('pre_production_process_boards', 'synced')) {
            Schema::table('pre_production_process_boards', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('pre_production_process_estimated_outputs', 'synced')) {
            Schema::table('pre_production_process_estimated_outputs', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('pre_production_process_machines', 'synced')) {
            Schema::table('pre_production_process_machines', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('pre_production_process_materials', 'synced')) {
            Schema::table('pre_production_process_materials', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('pre_production_process_previous_processes', 'synced')) {
            Schema::table('pre_production_process_previous_processes', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('production_dispatches', 'synced')) {
            Schema::table('production_dispatches', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('production_staff', 'synced')) {
            Schema::table('production_staff', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('product_materials', 'synced')) {
            Schema::table('product_materials', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('product_material_categories', 'synced')) {
            Schema::table('product_material_categories', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('product_material_purchases', 'synced')) {
            Schema::table('product_material_purchases', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('product_material_purchase_calculated_prices', 'synced')) {
            Schema::table('product_material_purchase_calculated_prices', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('product_material_purchase_details', 'synced')) {
            Schema::table('product_material_purchase_details', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('product_material_purchase_detail_damage_files', 'synced')) {
            Schema::table('product_material_purchase_detail_damage_files', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('product_material_purchase_payments', 'synced')) {
            Schema::table('product_material_purchase_payments', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('product_material_racks', 'synced')) {
            Schema::table('product_material_racks', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('product_material_sections', 'synced')) {
            Schema::table('product_material_sections', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('product_material_sets', 'synced')) {
            Schema::table('product_material_sets', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('product_material_set_items', 'synced')) {
            Schema::table('product_material_set_items', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('roles', 'synced')) {
            Schema::table('roles', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('role_permissions', 'synced')) {
            Schema::table('role_permissions', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('salaries', 'synced')) {
            Schema::table('salaries', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('salary_bonus_types', 'synced')) {
            Schema::table('salary_bonus_types', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('salary_details', 'synced')) {
            Schema::table('salary_details', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('salary_details_addition_deductions', 'synced')) {
            Schema::table('salary_details_addition_deductions', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('salary_details_bonuses', 'synced')) {
            Schema::table('salary_details_bonuses', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('salary_details_leaves', 'synced')) {
            Schema::table('salary_details_leaves', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('salary_settings_salary_sets', 'synced')) {
            Schema::table('salary_settings_salary_sets', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('settings_absent_penalties', 'synced')) {
            Schema::table('settings_absent_penalties', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('settings_bonus_types', 'synced')) {
            Schema::table('settings_bonus_types', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('settings_bonus_type_salary_bonuses', 'synced')) {
            Schema::table('settings_bonus_type_salary_bonuses', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('settings_geo_locations', 'synced')) {
            Schema::table('settings_geo_locations', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('settings_holidays', 'synced')) {
            Schema::table('settings_holidays', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('settings_late_penalties', 'synced')) {
            Schema::table('settings_late_penalties', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('settings_leave_types', 'synced')) {
            Schema::table('settings_leave_types', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('settings_office_times', 'synced')) {
            Schema::table('settings_office_times', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('settings_office_time_types', 'synced')) {
            Schema::table('settings_office_time_types', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('settings_overtime_types', 'synced')) {
            Schema::table('settings_overtime_types', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('settings_salary_deduction_types', 'synced')) {
            Schema::table('settings_salary_deduction_types', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('settings_salary_sets', 'synced')) {
            Schema::table('settings_salary_sets', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('settings_salary_set_attendance_locations', 'synced')) {
            Schema::table('settings_salary_set_attendance_locations', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('settings_salary_set_attendance_location_update_histories', 'synced')) {
            Schema::table('settings_salary_set_attendance_location_update_histories', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('settings_salary_set_employees', 'synced')) {
            Schema::table('settings_salary_set_employees', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('settings_salary_set_employee_update_histories', 'synced')) {
            Schema::table('settings_salary_set_employee_update_histories', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('settings_salary_set_leave_types', 'synced')) {
            Schema::table('settings_salary_set_leave_types', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('settings_salary_set_leave_type_update_histories', 'synced')) {
            Schema::table('settings_salary_set_leave_type_update_histories', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('settings_salary_set_update_histories', 'synced')) {
            Schema::table('settings_salary_set_update_histories', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('settings_salary_types', 'synced')) {
            Schema::table('settings_salary_types', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('settings_salary_type_details', 'synced')) {
            Schema::table('settings_salary_type_details', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('settings_termination_types', 'synced')) {
            Schema::table('settings_termination_types', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('states', 'synced')) {
            Schema::table('states', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('suppliers', 'synced')) {
            Schema::table('suppliers', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('supplier_asset_products', 'synced')) {
            Schema::table('supplier_asset_products', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('supplier_banks', 'synced')) {
            Schema::table('supplier_banks', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('supplier_contacts', 'synced')) {
            Schema::table('supplier_contacts', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('supplier_product_materials', 'synced')) {
            Schema::table('supplier_product_materials', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('transactions', 'synced')) {
            Schema::table('transactions', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('transaction_receipts', 'synced')) {
            Schema::table('transaction_receipts', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('transaction_vats', 'synced')) {
            Schema::table('transaction_vats', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('users', 'synced')) {
            Schema::table('users', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('user_bank_infos', 'synced')) {
            Schema::table('user_bank_infos', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('user_education_infos', 'synced')) {
            Schema::table('user_education_infos', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('user_emergency_contacts', 'synced')) {
            Schema::table('user_emergency_contacts', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('user_experience_infos', 'synced')) {
            Schema::table('user_experience_infos', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('user_leaves', 'synced')) {
            Schema::table('user_leaves', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('user_leave_details', 'synced')) {
            Schema::table('user_leave_details', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('user_resignations', 'synced')) {
            Schema::table('user_resignations', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('user_terminations', 'synced')) {
            Schema::table('user_terminations', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('warehouses', 'synced')) {
            Schema::table('warehouses', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('warehouse_sections', 'synced')) {
            Schema::table('warehouse_sections', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('warehouse_section_racks', 'synced')) {
            Schema::table('warehouse_section_racks', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
    }
};
