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
        Schema::create('postings', function (Blueprint $table) {
            $table->id();
            $table->uuid()->index();
            $table->unsignedBigInteger('personnel_id');
            $table->foreign('personnel_id')
                ->references('id')->on('personnel')->onDelete('cascade');
            $table->string('post_type')->nullable();
            $table->string('post_from')->nullable();
            $table->string('post_to')->nullable();
            $table->date('wef_date')->nullable();
            $table->date('end_date')->nullable();

            $table->unsignedBigInteger('appointment_id')->nullable();
            $table->string('appointment')->nullable();
            $table->string('appointment_type')->nullable();
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
        Schema::dropIfExists('postings');
    }
};
