<?php

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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->uuid()->index();
            $table->string('selectedDate')->nullable();
            $table->string('eventType')->nullable();
            $table->string('occurrenceType')->nullable();
            $table->string('whatHappened')->nullable();
            $table->string('whereInvolved')->nullable();
            $table->string('whoInvolved')->nullable();
            $table->string('locationInvolved')->nullable();
            $table->string('incidentDate')->nullable();
            $table->string('attachedFile')->nullable();
            $table->string('numberInvolved')->nullable();
            $table->string('impactType')->nullable();
            $table->string('impactCategory')->nullable();
            $table->string('actionTaken')->nullable();
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
        Schema::dropIfExists('events');
    }
};
