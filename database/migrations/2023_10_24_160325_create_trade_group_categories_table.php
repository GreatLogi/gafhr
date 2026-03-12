<?php

declare(strict_types=1);

use App\Models\TradeGroupCategory;
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
        Schema::create('trade_group_categories', function (Blueprint $table) {
            $table->id();
            $table->uuid()->index();
            $table->string('category');
            $table->timestamps();
        });

        $category = [
            'AIII',
            'AII',
            'AI',
            'BIII',
            'BII',
            'BI',
            'UT',
            'AIV',
            'BIV',
            'XI',
            'POT',
            'XIA',
            'X',
            'XII',
            'XIII',
            'XIV',
        ];

        foreach ($category as $cat) {
            TradeGroupCategory::create([
                'category' => $cat,
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trade_group_categories');
    }
};
