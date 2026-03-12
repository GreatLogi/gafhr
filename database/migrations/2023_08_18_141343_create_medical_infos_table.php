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
        Schema::create('medical_infos', function (Blueprint $table) {
            $table->id();
            $table->uuid()->index();
            $table->unsignedBigInteger('personnel_id');
            $table->foreign('personnel_id')
                ->references('id')->on('personnel')->onDelete('cascade');
            $table->string('vaccinated')->default(0)->nullable();
            $table->string('med_vax_case')->nullable();
            $table->string('vaccine_type')->nullable();
            $table->date('vax_date')->nullable();
            $table->mediumText('authority_remarks')->nullable();
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
        Schema::dropIfExists('medical_infos');
    }
};
