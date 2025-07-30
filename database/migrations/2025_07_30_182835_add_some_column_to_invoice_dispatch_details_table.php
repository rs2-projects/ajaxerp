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

        Schema::table('invoice_dispatch_details', function (Blueprint $table) {
            $table->unsignedBigInteger('invoice_id')->after('invoice_dispatch_id');
            $table->unsignedTinyInteger('item_type')->default(0)->comment('0=Raw Material,1=Raw Board, 2=Paper, 3=Finished Goods, 4=Finished Boards, 5=Set Item')->after('invoice_detail_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoice_dispatch_details', function (Blueprint $table) {
            $table->dropColumn('invoice_id');
            $table->dropColumn('item_type');
        });
    }
};
