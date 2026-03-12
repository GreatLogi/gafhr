<?php

declare (strict_types = 1);

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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->uuid()->index();
            $table->unsignedBigInteger('item_name')->nullable();
            $table->foreign('item_name')->references('id')->on('items_with_quantities')->onDelete('cascade');

            $table->unsignedBigInteger('category_id')->nullable();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');

            $table->unsignedBigInteger('mission_id')->nullable();
            $table->foreign('mission_id')->references('id')->on('missions')->onDelete('cascade');

            $table->unsignedBigInteger('sub_category')->nullable();
            $table->foreign('sub_category')->references('id')->on('sub_categories')->onDelete('cascade');

            $table->string('serial_no')->nullable();
            $table->string('type_own')->nullable();
            $table->string('item_description')->nullable();
            $table->string('un_no')->nullable();
            $table->string('engine_no')->nullable();
            $table->date('date_of_manufacture')->nullable();
            $table->date('date_of_unserviceable')->nullable();
            $table->mediumText('cause_of_unsvc')->nullable();
            $table->date('un_shelf_life')->nullable();
            $table->string('color')->nullable();
            $table->string('brand')->nullable();
            $table->string('weight')->nullable();
            $table->string('location')->nullable();
            $table->string('item_value')->nullable();
            $table->string('initial_cost')->nullable();
            $table->date('added_date')->nullable();
            $table->tinyInteger('status')->default('1');
            $table->tinyInteger('state')->default('1');
            $table->string('barcode_image')->nullable();
            $table->string('item_image')->nullable();
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
        Schema::dropIfExists('items');
    }
};
