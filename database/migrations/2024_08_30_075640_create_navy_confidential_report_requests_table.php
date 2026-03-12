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
        Schema::create('navy_confidential_report_requests', function (Blueprint $table) {
            $table->id();
            $table->uuid()->index();
            $table->unsignedBigInteger('personnel_id');
            $table->foreign('personnel_id')->references('id')->on('personnel')->onDelete('cascade');
            $table->string('service_no')->nullable();
            $table->string('present_rank')->nullable();
            $table->string('initials')->nullable();
            $table->string('commission_type')->nullable();
            $table->string('branch_id')->nullable();
            $table->mediumText('request_message')->nullable();
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
        Schema::dropIfExists('navy_confidential_report_requests');
    }
};
