<?php

declare(strict_types=1);

use App\Models\Trade;
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
        Schema::create('sq_courses', function (Blueprint $table) {
            $table->id();
            $table->uuid()->index();
            $table->unsignedBigInteger('personnel_id');
            $table->foreign('personnel_id')
                ->references('id')->on('personnel')->onDelete('cascade');
            $table->foreignIdFor(Trade::class)->nullable()->constrained();
            // $table->string('course_name')->nullable();
            $table->string('level')->nullable();
            $table->string('grade')->nullable();
            $table->float('score')->nullable();
            $table->date('course_date')->nullable();
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
        Schema::dropIfExists('sq_courses');
    }
};
