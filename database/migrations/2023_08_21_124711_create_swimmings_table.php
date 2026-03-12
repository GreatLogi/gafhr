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
        Schema::create('swimmings', function (Blueprint $table) {
            $table->id();
            $table->uuid()->index();
            $table->unsignedBigInteger('personnel_id');
            $table->string('test_done')->default(0)->nullable();
            $table->string('status')->nullable();
            $table->date('swimming_date')->nullable();
            $table->mediumText('authority_remarks')->nullable();
            $table->foreign('personnel_id')
                ->references('id')->on('personnel')->onDelete('cascade');
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
        Schema::dropIfExists('swimmings');
    }
};
