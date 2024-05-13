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
        Schema::table('finished_goods_categories', function (Blueprint $table) {
            $table->unsignedTinyInteger('type')->default(0)->comment('0=Others,1=Boards')->after('id');
        });

        \Illuminate\Support\Facades\DB::table('finished_goods_categories')->insert([
            'type' => \App\Models\Products\FinishedGoodsCategory::TYPE_BOARD,
            'name' => 'Boards'
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('finished_goods_categories', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
};
