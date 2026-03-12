<?php

declare(strict_types=1);

use App\Models\AirForceBase;
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
        Schema::create('air_force_bases', function (Blueprint $table) {
            $table->id();
            $table->uuid()->index();
            $table->string('name')->nullable();
            $table->string('location')->nullable();
            $table->string('short_code')->nullable();
            $table->timestamps();
        });

        AirForceBase::create([
            'name' => 'AFHQ',
            'location' => 'Accra',
            'short_code' => 'AFHQ',
        ]);

        AirForceBase::create([
            'name' => 'AFB (Accra)',
            'location' => 'Accra',
            'short_code' => 'AFBA',
        ]);

        AirForceBase::create([
            'name' => 'AFB (Takoradi)',
            'location' => 'Takoradi',
            'short_code' => 'AFBTD',
        ]);

        AirForceBase::create([
            'name' => 'AFB (Tamale)',
            'location' => 'Tamale',
            'short_code' => 'AFBTM',
        ]);

        AirForceBase::create([
            'name' => 'TAC (Bui)',
            'location' => 'Bui',
            'short_code' => 'TACB',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('air_force_bases');
    }
};
