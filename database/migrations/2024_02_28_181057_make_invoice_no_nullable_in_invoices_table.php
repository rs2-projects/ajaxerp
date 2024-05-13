<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            DB::select("ALTER TABLE `invoices` CHANGE `invoice_no` `invoice_no` VARCHAR(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL COMMENT 'Invoice Number should be unique and auto generated';");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            DB::select("ALTER TABLE `invoices` CHANGE `invoice_no` `invoice_no` VARCHAR(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Invoice Number should be unique and auto generated';");
        });
    }
};
