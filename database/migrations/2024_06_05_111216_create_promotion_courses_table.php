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
        Schema::create('promotion_courses', function (Blueprint $table) {
            $table->id();
            $table->uuid()->index();
            $table->unsignedBigInteger('personnel_id');
            $table->foreign('personnel_id')
                ->references('id')->on('personnel')->onDelete('cascade');
            $table->string('course_name')->nullable();

            $table->string('course_type')->nullable();
            $table->string('grade')->nullable();
            $table->float('score')->nullable();
            $table->string('remark')->nullable();

            $table->date('course_date')->nullable();
            $table->date('date_completed')->nullable();
            $table->string('course_location')->nullable();
            $table->text('authority')->nullable();
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
        Schema::dropIfExists('military_courses');
    }
};
