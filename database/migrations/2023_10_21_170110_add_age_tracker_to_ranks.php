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
        Schema::table('ranks', function (Blueprint $table) {
            $table->integer('personnel_age_retirement')->after('category')->nullable();
            $table->integer('personnel_years_in_rank')->after('personnel_age_retirement')->nullable();

            $table->after('category', function ($table) {
                $table->integer('officer_age_retirement_male')->nullable();
                $table->integer('officer_age_retirement_female')->nullable();
                $table->integer('officer_age_retirement_male_med')->nullable();
                $table->integer('officer_age_retirement_female_med')->nullable();
                $table->integer('officer_age_retirement_med_specialist')->nullable();
                $table->integer('officer_age_retirement_male_female_legal')->nullable();
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ranks', function (Blueprint $table) {
            //
        });
    }
};
