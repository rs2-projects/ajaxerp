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
        Schema::table('customer_banks', function (Blueprint $table) {
            DB::select("ALTER TABLE `customer_banks` CHANGE `bank_name` `bank_name` VARCHAR(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL, CHANGE `account_name` `account_name` VARCHAR(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL, CHANGE `account_no` `account_no` VARCHAR(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL;
");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customer_banks', function (Blueprint $table) {
            //
        });
    }
};
