<?php

declare(strict_types=1);

use App\Models\Region;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('personnel', function (Blueprint $table) {
            $table->foreignIdFor(Region::class)->after('hometown_region')->nullable()->constrained();
        });
        Schema::table('personnel', function (Blueprint $table) {
            $table->dropColumn('hometown_region');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('personnel', function (Blueprint $table) {
            $table->dropColumn('hometown_region_id');
        });
    }
};
