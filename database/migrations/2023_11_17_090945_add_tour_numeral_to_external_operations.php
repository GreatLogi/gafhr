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
        Schema::table('external_operations', function (Blueprint $table) {
            $table->after('description', function ($table) {
                $table->integer('tour_numeral')->nullable();
                $table->string('medal')->nullable();
            });
        });

        Schema::table('awards', function (Blueprint $table) {
            $table->dropColumn('numeral')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('external_operations', function (Blueprint $table) {
            //
        });
    }
};
