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
            \Illuminate\Support\Facades\DB::select("ALTER TABLE invoice_details DROP FOREIGN KEY `invoice_details_finished_good_id_foreign`;");
            \Illuminate\Support\Facades\DB::select("ALTER TABLE `invoice_details` DROP INDEX `invoice_details_finished_good_id_foreign`;");
            $table->dropColumn('finished_good_id');
            $table->unsignedBigInteger('item_id')->default(0)->after('invoice_id');
            $table->unsignedTinyInteger('item_type')->default(0)->comment('0=Raw Material,1=Raw Board, 2=Paper, 3=Finished Goods, 4=Finished Boards, 5=Set Item')->after('item_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoice_details', function (Blueprint $table) {
            $table->dropColumn('item_id');
            $table->dropColumn('item_type');
        });
    }
};
