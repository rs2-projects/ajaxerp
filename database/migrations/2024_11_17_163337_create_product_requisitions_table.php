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
        Schema::create('product_requisitions', function (Blueprint $table) {
            $table->id();

            $table->string('requisition_no', 32)->nullable();
            $table->unsignedBigInteger('production_staff_id');
            $table->text('description')->nullable();

            $table->unsignedSmallInteger('delivery_status')->default(0)->comment('0=Pending, 1=Delivered, 2=Partially Delivered');
            $table->unsignedSmallInteger('received_status')->default(0)->comment('0=Pending, 1=Received, 2=Partially Received');

            \App\Helpers\Development\MigrationHelper::getCommonColumns($table);
            $table->boolean('synced')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_requisitions');
    }
};
