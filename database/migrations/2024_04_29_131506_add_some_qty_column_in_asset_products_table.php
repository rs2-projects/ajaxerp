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
        Schema::table('asset_products', function (Blueprint $table) {
            $table->unsignedInteger('assigned_qty')->default(0)->after('available_qty');
            $table->unsignedInteger('maintenance_qty')->default(0)->after('assigned_qty');
            $table->unsignedInteger('sold_qty')->default(0)->after('maintenance_qty');
            $table->unsignedInteger('disposed_qty')->default(0)->after('sold_qty');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('asset_products', function (Blueprint $table) {
            $table->dropColumn('assigned_qty');
            $table->dropColumn('maintenance_qty');
            $table->dropColumn('sold_qty');
            $table->dropColumn('disposed_qty');
        });
    }
};
