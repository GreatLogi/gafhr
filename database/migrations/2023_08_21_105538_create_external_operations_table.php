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
        Schema::create('external_operations', function (Blueprint $table) {
            $table->id();
            $table->uuid()->index();
            $table->unsignedBigInteger('personnel_id');
            $table->foreign('personnel_id')
                ->references('id')->on('personnel')->onDelete('cascade');
            $table->string('operation_type')->nullable();
            $table->string('description')->nullable();
            $table->date('wef_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('appointment')->nullable();
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
        Schema::dropIfExists('external_operations');
    }
};
