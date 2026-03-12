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
            $table->integer('engagement')->nullable()->after('enlistment_date');
            $table->string('pass_out_rank')->nullable()->after('rank_on_commission');
            $table->float('sea_trg')->nullable()->after('intake');
            $table->float('btn_results')->nullable()->after('sea_trg');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('personnel', function (Blueprint $table) {
            $table->dropColumn('trade_group_id');
        });
    }
};
