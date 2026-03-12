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
        Schema::create('patrolplan', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->index();
            $table->string('patrol_no');
            $table->string('patrol_type');
            $table->string('composition_vehicle');
            $table->string('composition_persons');
            $table->double('lat', 20, 10);
            $table->double('lng', 20, 10);
            $table->string('route')->nullable();
            $table->date('date');
            $table->string('status');
            $table->time('time');
            $table->string('document');
            $table->mediumText('description');
            $table->mediumText('reason')->nullable();
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
        Schema::dropIfExists('patrolplan');
    }
};
