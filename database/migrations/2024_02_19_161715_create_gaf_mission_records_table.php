<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gaf_mission_records', function (Blueprint $table) {
            $table->id();
            $table->uuid()->index();
            $table->string('svcnumber')->nullable();
            $table->string('rank_name')->nullable();
            $table->string('surname')->nullable();
            $table->string('othernames')->nullable();
            $table->string('first_name')->nullable();
            $table->string('initial')->nullable();
            $table->string('gender')->nullable();
            $table->string('blood_group')->nullable();
            $table->string('height')->nullable();
            $table->string('virtual_mark')->nullable();
            $table->string('mobile_no')->nullable();
            $table->string('email')->nullable();
            $table->string('arm_of_service')->nullable();
            $table->string('unit_name')->nullable();
            $table->date('departure_date')->nullable();
            $table->string('departuredays')->nullable();
            $table->string('country')->nullable();
            $table->string('arrivaldays')->nullable();
            $table->string('status')->comment('0=Pending,1=Approve,2=Deployed,3=Canceled,4=Scheduled,5=Return,6=Repatriated')->nullable();
            $table->date('today_date')->nullable();
            $table->string('chalk_list')->nullable();
            $table->string('appointment_name')->nullable();
            $table->string('ghanbatt_name')->nullable();
            $table->string('service_category')->nullable();
            $table->date('return_date')->nullable();
            $table->string('mission_name')->nullable();
            $table->string('un_email')->nullable();
            $table->string('un_id')->nullable();
            $table->string('coy')->nullable();
            $table->string('cell')->nullable();
            $table->string('passport_number')->nullable();
            $table->date('passport_expiry_date')->nullable();
            $table->string('passport_expiry_days')->nullable();
            $table->string('personnel_image')->nullable();
            $table->longText('remarks')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade'); 
            $table->unsignedBigInteger('updated_by');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gaf_mission_records');
    }
};
