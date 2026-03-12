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
        Schema::create('disciplinaries', function (Blueprint $table) {
            $table->id();
            $table->uuid()->index();
            $table->unsignedBigInteger('personnel_id');
            $table->foreign('personnel_id')->references('id')->on('personnel')->onDelete('cascade');
            $table->unsignedBigInteger('unit_id');
            $table->string('disciplinary_type')->nullable();
            $table->foreign('unit_id')->references('id')->on('units')->onDelete('cascade');
            $table->string('place_of_offense')->nullable();
            $table->date('date_of_offense')->nullable();
            $table->string('findings_of_offense')->nullable();
            $table->string('award')->nullable();
            $table->string('part_order_number')->nullable();
            $table->string('offenses')->nullable();
            $table->string('number_of_offenses')->nullable();
            $table->string('board_member_name')->nullable();
            $table->string('witness_name')->nullable();
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
        Schema::dropIfExists('disciplinaries');
    }
};
