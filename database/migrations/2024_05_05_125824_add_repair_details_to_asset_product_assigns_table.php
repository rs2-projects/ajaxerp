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
            $table->unsignedBigInteger('repaired_by')->after('repair_date')->nullable();
            $table->text('repair_note')->after('repaired_by')->nullable();
            $table->timestamp('repaired_at')->after('repair_note')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('asset_product_assigns', function (Blueprint $table) {
            $table->dropColumn('repaired_by');
            $table->dropColumn('repair_note');
            $table->dropColumn('repaired_at');
        });
    }
};
