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
        Schema::table('product_material_purchases', function (Blueprint $table) {
            $table->unsignedTinyInteger('has_boards')->default(0)->comment('0=No,1=Yes')->after('invoice_footer');
            $table->unsignedTinyInteger('has_others')->default(0)->comment('0=No,1=Yes')->after('has_boards');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_material_purchases', function (Blueprint $table) {
            $table->dropColumn('has_boards');
            $table->dropColumn('has_others');
        });
    }
};
