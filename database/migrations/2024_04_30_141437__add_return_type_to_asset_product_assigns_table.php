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
        Schema::table('asset_product_assigns', function (Blueprint $table) {
            $table->date('return_date')->after('warranty')->nullable();
            $table->unsignedBigInteger('return_type')->after('return_date')->nullable();
            $table->text('return_reason')->after('return_type')->nullable();
            $table->date('repair_date')->after('return_reason')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('asset_product_assigns', function (Blueprint $table) {
            $table->dropColumn('return_date');
            $table->dropColumn('return_type');
            $table->dropColumn('return_reason');
            $table->dropColumn('repair_date');
        });
    }
};
