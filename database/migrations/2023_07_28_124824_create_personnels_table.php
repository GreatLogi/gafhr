<?php

declare(strict_types=1);

use App\Models\Branch;
use App\Models\Denomination;
use App\Models\Tribe;
use App\Models\Unit;
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
        Schema::create('personnels', function (Blueprint $table) {
            $table->id();
            $table->uuid()->index();
            $table->string('service_no')->nullable();
            $table->string('surname')->nullable();
            $table->string('first_name')->nullable();
            $table->string('other_names')->nullable();
            $table->string('initials')->nullable();
            $table->string('sex')->nullable();

            $table->date('date_of_birth')->nullable();
            $table->string('place_of_birth')->nullable();
            $table->string('blood_group')->nullable();

            $table->string('marital_status')->nullable();

            $table->string('status')->nullable();
            $table->string('arm_of_service')->nullable();

            $table->date('enlistment_date')->nullable();
            $table->string('intake')->nullable();
            $table->integer('intake_number')->nullable();

            $table->string('place_of_commission')->nullable();
            $table->string('commission_type')->nullable();
            $table->date('commission_date')->nullable();

            $table->string('rank_code')->nullable();
            $table->string('rank_on_commission')->nullable();
            $table->string('present_rank')->nullable();
            $table->date('present_rank_date')->nullable();

            $table->foreignIdFor(Unit::class)->nullable()->constrained();
            $table->string('attached_unit')->nullable();
            $table->string('present_location')->nullable();

            $table->foreignIdFor(Branch::class)->nullable()->constrained();
            $table->string('trade')->nullable();

            $table->string('squadron')->nullable();
            $table->string('disposition')->nullable();

            $table->date('conversion_date')->nullable();
            $table->date('conversion_snr_date')->nullable();

            $table->string('accommodation')->nullable();

            $table->string('hometown')->nullable();
            $table->string('hometown_region')->nullable();
            $table->string('hometown_district')->nullable();
            $table->foreignIdFor(Tribe::class)->nullable()->constrained();

            $table->string('residential_address')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('secondary_phone')->nullable();

            $table->json('languages_spoken')->nullable();
            $table->json('hobbies')->nullable();
            $table->string('religion')->nullable();
            $table->foreignIdFor(Denomination::class)->nullable()->constrained();

            $table->mediumText('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('personnels');
    }
};
