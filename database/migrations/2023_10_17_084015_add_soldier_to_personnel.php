<?php

use App\Models\TradeGroup;
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
            $table->string('trade_group')->nullable()->after('trade_id');
            $table->date('trade_group_date')->nullable()->after('trade_group');
            $table->date('engagement_date')->after('enlistment_date')->nullable();
            $table->foreignIdFor(TradeGroup::class)->after('trade_group')->nullable()->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('personnel', function (Blueprint $table) {
            $table->dropColumn('trade_group');
            $table->dropColumn('trade_group_date');
        });
    }
};
