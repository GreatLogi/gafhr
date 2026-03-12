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
        Schema::table('gaf_mission_records', function (Blueprint $table) {
            $table->string('chalk_out')->nullable()->after('chalk_list');
            $table->date('leave_departure_date')->nullable()->after('passport_expiry_days');
            $table->date('leave_return_date')->nullable()->after('passport_expiry_days');
            $table->string('leave_status')->nullable()->after('passport_expiry_days');
            $table->mediumText('leave_reason')->nullable()->after('passport_expiry_days');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('gaf_mission_records', function (Blueprint $table) {
            //
        });
    }
};
