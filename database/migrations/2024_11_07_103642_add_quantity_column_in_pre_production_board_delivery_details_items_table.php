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
        Schema::table('pre_production_board_delivery_details_items', function (Blueprint $table) {
            $table->unsignedBigInteger('lot_production_id')->nullable()->default(null)->after('finished_board_id')->comment('id from pre_productions table from where the item is delivering');
            $table->unsignedInteger('quantity')->default(0)->after('lot_production_id');
            $table->unsignedInteger('received_qty')->default(0)->after('quantity');
            $table->unsignedSmallInteger('received_status')->default(0)->comment('0=Pending, 1=Received, 2=Partially Received')->after('received_qty');
            $table->unsignedSmallInteger('scanned_qty')->default(0)->after('received_status');
            $table->unsignedSmallInteger('scan_status')->default(0)->after('scanned_qty')->comment('0=Pending, 1=Scanned, 2=Partially Scanned');

            // $table->string('barcode', 64)->nullable()->default(null);
            DB::select("ALTER TABLE `pre_production_board_delivery_details_items` CHANGE `barcode` `barcode` VARCHAR(64);");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pre_production_board_delivery_details_items', function (Blueprint $table) {
            $table->dropColumn('quantity');
            $table->dropColumn('received_qty');
            $table->dropColumn('received_status');
            $table->dropColumn('scanned_qty');
            $table->dropColumn('scan_status');
        });
    }
};
