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
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('business_name', 255)->index();
            $table->string('image', 255)->nullable();
            $table->string('email', 128)->nullable();
            $table->string('phone', 64)->nullable();
            $table->string('contact_first_name', 128)->nullable();
            $table->string('contact_last_name', 128)->nullable();
            $table->string('lead_time_status', 128)->nullable();

            //address
            $table->string('address', 255)->nullable();
            $table->string('city', 64)->nullable();
            $table->string('zip_code', 64)->nullable();
            $table->unsignedBigInteger('country_id')->nullable();
            $table->unsignedBigInteger('state_id')->nullable();

            //extra
            $table->string('account_no', 64)->nullable();
            $table->string('fax', 64)->nullable();
            $table->string('website', 128)->nullable();
            $table->string('notes', 255)->nullable();

            \App\Helpers\Development\MigrationHelper::getCommonColumns($table);

            //define foreign key
            $table->foreign('country_id')->references('id')->on('countries');
            $table->foreign('state_id')->references('id')->on('states');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};
