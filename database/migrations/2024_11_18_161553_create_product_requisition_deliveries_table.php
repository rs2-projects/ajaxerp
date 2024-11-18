<?php

use App\Helpers\Development\MigrationHelper;
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
        Schema::create('product_requisition_deliveries', function (Blueprint $table) {
            $table->id();
            $table->string('delivery_no', 50)->nullable();
            $table->unsignedBigInteger('product_requisition_id');
            $table->date('delivery_date');
            $table->unsignedBigInteger('delivered_by');
            $table->timestamp('delivered_at')->nullable();
            $table->unsignedTinyInteger('received_status')->default(0);

            \App\Helpers\Development\MigrationHelper::getCommonColumns($table);
            $table->boolean('synced')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_requisition_deliveries');
    }
};
