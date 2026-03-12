<?php
declare (strict_types = 1);
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
        Schema::create('g_a_f_t_o_t_r_a_v_e_l_r_e_c_o_r_d_s', function (Blueprint $table) {
            $table->id();
            $table->uuid()->index();
            $table->string('svcnumber')->nullable();
            $table->string('rank_name')->nullable();
            $table->string('surname')->nullable();
            $table->string('othernames')->nullable();
            $table->string('first_name')->nullable();
            $table->string('initial')->nullable();
            $table->string('gender')->nullable();
            $table->string('blood_group')->nullable();
            $table->string('mobile_no')->nullable();
            $table->string('email')->nullable();
            $table->string('arm_of_service')->nullable();
            $table->string('unit_name')->nullable();
            $table->string('service_category')->nullable();
            $table->string('status')->comment('0=Pending,1=Approve,2=Deployed,3=Canceled,4=Scheduled,5=Return,6=Repatriated')->nullable();
            $table->date('today_date')->nullable();
            $table->string('purpose')->nullable();
            $table->string('country')->nullable();
            $table->string('destination_address')->nullable();
            $table->string('ticket_number')->nullable();
            $table->string('departure_flight_number')->nullable();
            $table->string('return_flight_number')->nullable();
            $table->date('departure_date')->nullable();
            $table->string('departuredays')->nullable();
            $table->date('return_date')->nullable();
            $table->string('arrivaldays')->nullable();
            $table->time('etd')->nullable();
            $table->time('eta')->nullable();
            $table->string('passport_number')->nullable();
            $table->date('passport_expiry_date')->nullable();
            $table->string('passport_expiry_days')->nullable();
            $table->string('amount')->nullable();
            $table->string('sponsorship')->nullable();
            $table->string('responsibility')->nullable();
            $table->string('personnel_image')->nullable();
            $table->longText('remarks')->nullable();
              $table->string('travelled_with_civ')->nullable();
            $table->string('civ_state')->nullable();
            $table->string('civ_full_name')->nullable();
            $table->string('civ_gender')->nullable();
            $table->string('civ_mobile_no')->nullable();
            $table->string('civ_email')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('updated_by');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('g_a_f_t_o_t_r_a_v_e_l_r_e_c_o_r_d_s');
    }
};
