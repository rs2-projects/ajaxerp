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
        Schema::table('pre_productions', function (Blueprint $table) {
            $table->unsignedInteger('dispatched_qty')->default(0)->after('received_status')->comment('qty dispatched to warehouse after production');
            $table->unsignedTinyInteger('dispatched_status')->default(0)->after('dispatched_qty')->comment('0=not dispatched,1=dispatched, 2=partially dispatched');
            $table->unsignedInteger('damage_qty')->default(0)->after('dispatched_status')->comment('qty damaged on/after production');
            $table->unsignedInteger('received_qty')->default(0)->after('damage_qty')->comment('total qty received in warehouse after production');

            $table->unsignedInteger('sale_qty')->default(0)->after('received_qty')->comment('qty sold from warehouse by invoice/order');
            $table->unsignedInteger('available_qty')->default(0)->after('sale_qty')->comment('qty available in warehouse');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pre_productions', function (Blueprint $table) {
            $table->dropColumn('dispatched_qty');
            $table->dropColumn('dispatched_status');
            $table->dropColumn('damage_qty');
            $table->dropColumn('received_qty');
            $table->dropColumn('sale_qty');
            $table->dropColumn('available_qty');
        });
    }
};
