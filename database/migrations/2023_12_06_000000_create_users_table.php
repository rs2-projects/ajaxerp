<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Helpers\Development\MigrationHelper;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('employee_id',16)->nullable();
            $table->unsignedTinyInteger('type')->default(1)->comment('0=admin, 1=employee');
            $table->unsignedSmallInteger('role')->comment('0=superuser,1=admin');
            $table->unsignedBigInteger('department_id')->nullable();
            $table->unsignedBigInteger('designation_id')->nullable();
            $table->string('first_name', 255)->index();
            $table->string('last_name', 255)->index();
            $table->string('email',128)->nullable()->index();
            $table->string('phone',32)->nullable()->index();
            $table->date('joining_date')->nullable();
            $table->string('nid_no', 32)->nullable();
            $table->string('nid_image', 255)->nullable();
            $table->string('passport_no', 32)->nullable();
            $table->date('passport_expiry_date')->nullable();
            $table->string('passport_image', 255)->nullable();
            $table->date('date_of_birth')->nullable();
            $table->unsignedTinyInteger('gender')->comment('0=male,1=female,2=other')->nullable();
            $table->string('religion', 32)->nullable();
            $table->unsignedTinyInteger('marital_status')->comment('0=single,1=married,2=divorced,3=widowed')->nullable();
            $table->date('marriage_date')->nullable();
            $table->text('present_address')->nullable();
            $table->text('permanent_address')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();

            $table->boolean('resigned')->default(false)->comment('0=No, 1=Yes');
            $table->date('resign_date')->nullable();
            $table->boolean('terminated')->default(false)->comment('0=No, 1=Yes');
            $table->date('terminate_date')->nullable();
            MigrationHelper::getCommonColumns($table);

            //define relationships
            $table->foreign('department_id')->references('id')->on('departments');
            $table->foreign('designation_id')->references('id')->on('designations');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
