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
        Schema::table('civil_education', function (Blueprint $table) {
            $table->boolean('to_date')->after('to')->nullable();
        });

        Schema::table('personnel', function (Blueprint $table) {
            $table->unsignedBigInteger('present_location')->change();
            $table->foreign('present_location')
                ->references('id')->on('units')->onDelete('cascade');
        });

        Schema::table('postings', function (Blueprint $table) {
            $table->unsignedBigInteger('post_from')->change();
            $table->foreign('post_from')
                ->references('id')->on('units')->onDelete('cascade');
        });

        Schema::table('postings', function (Blueprint $table) {
            $table->unsignedBigInteger('post_to')->change();
            $table->foreign('post_to')
                ->references('id')->on('units')->onDelete('cascade');
        });

        Schema::table('families', function (Blueprint $table) {
            $table->string('sex')->after('family_relation')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('civil_education', function (Blueprint $table) {
            $table->dropColumn('to_date');
        });

        Schema::table('families', function (Blueprint $table) {
            $table->dropColumn('sex');
        });
    }
};
