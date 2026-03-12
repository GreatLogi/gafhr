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
        Schema::create('inventoryrecords', function (Blueprint $table) {
            $table->id();
            $table->uuid()->index();
            $table->string('country_name')->nullable();
            $table->string('mission_name')->nullable();
            $table->string('serial_no')->nullable();
            $table->string('item_name')->nullable();
            $table->string('category_name')->nullable();
            $table->date('issued_date')->nullable();
            $table->string('state')->nullable()->comment('Loaned=0', 'Unreturned=2');
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
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
        Schema::dropIfExists('inventoryrecords');
    }
};
