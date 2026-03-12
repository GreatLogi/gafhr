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
        Schema::table('medical_infos', function (Blueprint $table) {
            $table->integer('stability')->nullable()->after('vax_date');
            $table->integer('mental_function')->nullable()->after('vax_date');
            $table->integer('eyesight_left')->nullable()->after('vax_date');
            $table->integer('eyesight_right')->nullable()->after('vax_date');
            $table->integer('hearing_left')->nullable()->after('vax_date');
            $table->integer('hearing_right')->nullable()->after('vax_date');
            $table->integer('lower_limbs')->nullable()->after('vax_date');
            $table->integer('upper_limbs')->nullable()->after('vax_date');
            $table->integer('physique')->nullable()->after('vax_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('medical_infos', function (Blueprint $table) {
            $table->dropColumn('stability');
            $table->dropColumn('mental_function');
            $table->dropColumn('eyesight_left');
            $table->dropColumn('eyesight_right');
            $table->dropColumn('hearing_left');
            $table->dropColumn('hearing_right');
            $table->dropColumn('lower_limbs');
            $table->dropColumn('upper_limbs');
            $table->dropColumn('physique');
        });
    }
};
