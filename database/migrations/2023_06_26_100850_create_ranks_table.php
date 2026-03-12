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
        Schema::create('ranks', function (Blueprint $table) {
            $table->id();
            $table->uuid()->index();
            $table->integer('rank_code')->nullable();
            $table->string('army_display')->nullable();
            $table->string('army_full')->nullable();

            $table->string('navy_display')->nullable();
            $table->string('navy_full')->nullable();

            $table->string('airforce_display')->nullable();
            $table->string('airforce_full')->nullable();
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
        Schema::dropIfExists('ranks');
    }
};
