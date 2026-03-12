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
        Schema::table('personnel', function (Blueprint $table) {
            $table->string('rank_type')->after('present_rank_date')->nullable();
            $table->date('seniority_date')->after('rank_type')->nullable();
            $table->string('level')->after('arm_of_service')->default('OFFICER');
            $table->string('bks_accn')->after('tribe_id')->nullable();

            $table->dropColumn('ghana_card_number');
            $table->dropColumn('passport_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('personnel', function (Blueprint $table) {
            $table->dropColumn('rank_type');
            $table->dropColumn('seniority_date');
            $table->dropColumn('level');
            $table->dropColumn('bks_accn');
        });
    }
};
