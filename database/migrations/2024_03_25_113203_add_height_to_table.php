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
        Schema::table('personnels', function (Blueprint $table) {
            $table->string('height')->nullable()->after('gender');
            $table->string('virtual_mark')->nullable()->after('blood_group');
            $table->unsignedBigInteger('unit_id')->nullable()->after('virtual_mark');
            $table->foreign('unit_id')->references('id')->on('units')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('personnels', function (Blueprint $table) {
            $table->dropColumn('height');
            $table->dropColumn('virtual_mark');
            $table->dropColumn('unit_id');
        });
    }
};
