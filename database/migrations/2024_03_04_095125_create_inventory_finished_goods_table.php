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
        Schema::create('inventory_finished_goods', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('finished_goods_category_id');
            $table->unsignedBigInteger('finished_goods_id')->index();
            $table->unsignedTinyInteger('type')->default(0)->comment('0=in,1=out');
            $table->unsignedTinyInteger('reference_type')->default(0)->comment('0=receive from warehouse,1=sale etc');
            $table->unsignedBigInteger('reference_id')->nullable()->comment('id from respective table [0=production_dispatches] etc');
            $table->unsignedInteger('quantity')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_finished_goods');
    }
};
