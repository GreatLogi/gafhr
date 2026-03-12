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
        Schema::create('retirements', function (Blueprint $table) {
            $table->id();
            $table->uuid()->index();
            $table->string('service_no')->nullable();
            $table->integer('age')->nullable();
            $table->integer('rank_order')->nullable();
            $table->string('rank')->nullable();
            $table->string('branch')->nullable();
            $table->string('arm_of_service')->nullable();
            $table->string('category')->nullable();
            $table->date('date_of_birth')->nullable();
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
        Schema::dropIfExists('retirements');
    }
};
