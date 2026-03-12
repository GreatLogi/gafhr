<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('service_email')->after('appointment_email')->nullable();
        });

        Schema::table('personnel', function (Blueprint $table) {
            $table->date('rtu')->after('present_location')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('service_email');
        });

        Schema::table('personnel', function (Blueprint $table) {
            $table->dropColumn('rtu');
        });
    }
};
