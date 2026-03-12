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
        Schema::table('families', function (Blueprint $table) {
            $table->string('date_of_birth')->nullable()->after('full_name');
        });

        Schema::table('next_of_kin', function (Blueprint $table) {
            $table->string('date_of_birth')->nullable()->after('full_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('families', function (Blueprint $table) {
            $table->dropColumn('date_of_birth');
        });

        Schema::table('next_of_kin', function (Blueprint $table) {
            $table->dropColumn('date_of_birth');
        });
    }
};
