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
        Schema::table('finished_goods', function (Blueprint $table) {
            $table->unsignedTinyInteger('type')->default(0)->comment('0=others,1=board')->after('id');
            $table->unsignedBigInteger('embossed_up')->nullable()->default(null)->after('warehouse_id');
            $table->unsignedBigInteger('color_up')->nullable()->default(null)->after('embossed_up');
            $table->unsignedBigInteger('embossed_down')->nullable()->default(null)->after('color_up');
            $table->unsignedBigInteger('color_down')->nullable()->default(null)->after('embossed_down');

            //define foreign keys
            $table->foreign('embossed_up')->references('id')->on('board_embosseds');
            $table->foreign('color_up')->references('id')->on('board_colors');
            $table->foreign('embossed_down')->references('id')->on('board_embosseds');
            $table->foreign('color_down')->references('id')->on('board_colors');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('finished_goods', function (Blueprint $table) {
            $table->dropColumn('type');
            $table->dropColumn('embossed_up');
            $table->dropColumn('color_up');
            $table->dropColumn('embossed_down');
            $table->dropColumn('color_down');
        });
    }
};
