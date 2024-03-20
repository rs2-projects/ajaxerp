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
        Schema::table('invoice_details', function (Blueprint $table) {
            $table->tinyInteger('dispatched')->default(0)->comment('0=No,1=Dispatched,2=Partially Dispatched')->change();
            $table->unsignedInteger('dispatched_qty')->default(0)->after('dispatched');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoice_details', function (Blueprint $table) {
            $table->dropColumn('dispatched_qty');
        });
    }
};
