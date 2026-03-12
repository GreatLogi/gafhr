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
            $table->after('account_no', function ($table) {
                $table->date('confirmation_date')->nullable();
                $table->boolean('disability')->default(0);
                $table->string('type_of_disability', 100)->nullable();
                $table->string('rank_on_entry', 30)->nullable();
                $table->string('type_of_qualification', 100)->nullable();
                $table->string('education_category', 100)->nullable();
                $table->string('medical', 100)->nullable();
            });

            $table->after('email', function ($table) {
                $table->string('service_email', 100)->nullable();
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('personnel', function (Blueprint $table) {
            $table->dropColumn('confirmation_date');
            $table->dropColumn('disability');
            $table->dropColumn('type_of_disability');
            $table->dropColumn('rank_on_entry');
            $table->dropColumn('type_of_qualification');
            $table->dropColumn('education_category');
            $table->dropColumn('medical');
            $table->dropColumn('service_email');
        });
    }
};
