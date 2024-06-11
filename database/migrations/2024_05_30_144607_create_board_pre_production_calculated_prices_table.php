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
        Schema::create('board_pre_production_calculated_prices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('board_pre_production_id');
            $table->unsignedBigInteger('product_material_id')->comment('raw board id');
            $table->unsignedDecimal('landed_cost_excluding_vat', 12, 2)->default(0)->comment('lastest purchase calculated price of raw board');
            $table->unsignedDecimal('machine_cost', 12, 2)->default(0)->comment('machine production cost');
            $table->unsignedDecimal('paper_up_cost', 12, 2)->default(0)->comment('lastest purchase calculated price of paper up');
            $table->unsignedDecimal('plate_up_cost', 12, 2)->default(0)->comment('plate up production cost');
            $table->unsignedDecimal('paper_down_cost', 12, 2)->default(0)->comment('lastest purchase calculated price of paper down');
            $table->unsignedDecimal('plate_down_cost', 12, 2)->default(0)->comment('plate down production cost');
            $table->unsignedDecimal('vat_percent', 12, 2)->default(12);
            $table->unsignedDecimal('retail_percent', 12, 2)->default(0);
            $table->unsignedDecimal('discount_percent', 12, 2)->default(0);
            
            $table->unsignedDecimal('total_production_cost_excluding_vat', 12, 2)->default(0)->comment('(value = landed cost + machine cost + paper up cost + plate up cost + paper down cost + plate down cost)');
            $table->unsignedDecimal('retail_price', 12, 2)->default(0)->comment('(value = total_production_cost_excluding_vat + (total_production_cost_excluding_vat / 100) * retail_percent)');
            $table->unsignedDecimal('price_excluding_vat', 12, 2)->default(0);
            $table->unsignedDecimal('vat', 12, 2)->default(0);
            $table->unsignedDecimal('discount_wholesale', 12, 2)->default(0)->comment(' value = retail_price - (retail_price / 100) * discount_percent');
            
            \App\Helpers\Development\MigrationHelper::getCommonColumns($table);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('board_pre_production_calculated_prices');
    }
};
