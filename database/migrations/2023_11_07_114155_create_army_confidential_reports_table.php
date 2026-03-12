<?php

declare(strict_types=1);

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
        Schema::create('army_confidential_reports', function (Blueprint $table) {
            $table->id();
            $table->uuid()->index();
            $table->unsignedBigInteger('personnel_id');
            $table->foreign('personnel_id')->references('id')->on('personnel')->onDelete('cascade');
            $table->json('languages')->nullable();
            $table->json('assessment')->nullable();
            $table->json('grading')->nullable();
            $table->string('pes')->nullable();
            $table->date('pes_date')->nullable();
            $table->string('report_no')->nullable();
            $table->string('report_unique_id')->nullable();
            $table->string('any_other_languages')->nullable();
            $table->date('commission_date')->nullable();
            $table->string('institution')->nullable();
            $table->string('present_rank')->nullable();
            $table->string('initials')->nullable();
            $table->string('temporary_rank')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->date('seniority_date')->nullable();
            $table->string('arm_of_service')->nullable();
            $table->string('commission_type')->nullable();
            $table->string('unit_id')->nullable();
            $table->string('marital_status')->nullable();
            $table->string('qualification_psc')->nullable();
            $table->integer('sense_of_duty')->nullable();
            $table->integer('loyalty')->nullable();
            $table->integer('proficiency_in_current_duties')->nullable();
            $table->integer('integrity')->nullable();
            $table->integer('example')->nullable();
            $table->integer('presence')->nullable();
            $table->integer('turnout')->nullable();
            $table->integer('physical_fitness')->nullable();
            $table->integer('social_conduct')->nullable();
            $table->integer('determination_infield')->nullable();
            $table->integer('reliability_infield')->nullable();
            $table->integer('judgement_infield')->nullable();
            $table->integer('initiative_and_improvisation_infield')->nullable();
            $table->integer('self_confidence_infield')->nullable();
            $table->integer('presence_of_mind_infield')->nullable();
            $table->integer('level_of_knowledge_1_infield')->nullable();
            $table->integer('level_of_knowledge_2_infield')->nullable();
            $table->integer('organising_ability_infield')->nullable();
            $table->integer('cooperation_infield')->nullable();
            $table->integer('tact_infield')->nullable();
            $table->integer('intelligence_infield')->nullable();
            $table->integer('power_of_expression_oral_infield')->nullable();
            $table->integer('power_of_expression_written_infield')->nullable();
            $table->integer('technical_proficiency_infield')->nullable();
            $table->integer('determination_inoffice')->nullable();
            $table->integer('reliability_inoffice')->nullable();
            $table->integer('judgement_inoffice')->nullable();
            $table->integer('initiative_and_improvisation_inoffice')->nullable();
            $table->integer('self_confidence_inoffice')->nullable();
            $table->integer('presence_of_mind_inoffice')->nullable();
            $table->integer('level_of_knowledge_1_inoffice')->nullable();
            $table->integer('level_of_knowledge_2_inoffice')->nullable();
            $table->integer('organising_ability_inoffice')->nullable();
            $table->integer('cooperation_inoffice')->nullable();
            $table->integer('tact_inoffice')->nullable();
            $table->integer('intelligence_inoffice')->nullable();
            $table->integer('power_of_expression_oral_inoffice')->nullable();
            $table->integer('power_of_expression_written_inoffice')->nullable();
            $table->integer('technical_proficiency_inoffice')->nullable();
            $table->integer('power_to_inspire_infield')->nullable();
            $table->integer('power_of_command_infield')->nullable();
            $table->integer('discipline_infield')->nullable();
            $table->integer('attitude_towards_sub_officers_infield')->nullable();
            $table->integer('attitude_towards_men_infield')->nullable();
            $table->integer('leader_self_confidence_infield')->nullable();
            $table->integer('power_to_inspire_inoffice')->nullable();
            $table->integer('power_of_command_inoffice')->nullable();
            $table->integer('discipline_inoffice')->nullable();
            $table->integer('attitude_towards_sub_officers_inoffice')->nullable();
            $table->integer('attitude_towards_men_inoffice')->nullable();
            $table->integer('leader_self_confidence_inoffice')->nullable();
            $table->string('to_the_next_substantive')->nullable();
            $table->string('to_the_next_acting')->nullable();
            $table->string('appointment_higher_rank')->nullable();
            $table->string('reached_ceiling')->nullable();
            $table->string('passed_by_better_ability')->nullable();
            $table->string('recommend_next_appointment')->nullable();
            $table->string('future_appointment')->nullable();
            $table->mediumText('additional_remarks')->nullable();
            $table->date('report_covered_date_from')->nullable();
            $table->date('report_covered_date_to')->nullable();
            $table->date('served_under_you_from_date')->nullable();
            $table->date('served_under_you_to_date')->nullable();
            $table->date('last_appointment_held_date')->nullable();
            $table->date('present_appointment_held_date')->nullable();
            $table->string('suitable_for_selection_for_appointment_at_gma')->nullable();
            $table->string('suitable_for_staff_tfg')->nullable();
            $table->string('served_with_troops')->nullable();
            $table->date('head_of_service_date')->nullable();
            $table->string('first_superior_knowledge_about_personnel')->nullable();
            $table->string('agree_with_initiation_officer')->nullable();
            $table->mediumText('first_superior_remarks')->nullable();
            $table->string('second_superior_knowledge_about_personnel')->nullable();
            $table->mediumText('second_superior_remarks')->nullable();
            $table->string('third_superior_knowledge_about_personnel')->nullable();
            $table->mediumText('third_superior_remarks')->nullable();
            $table->string('course_name')->nullable();
            $table->string('course_grade')->nullable();
            $table->string('practical_passed_lt_cpt')->nullable();
            $table->string('written_passed_lt_cpt')->nullable();
            $table->date('lt_to_cpt_exams_date')->nullable();
            $table->string('practical_passed_cpt_maj')->nullable();
            $table->string('written_passed_cpt_maj')->nullable();
            $table->date('cpt_to_maj_exams_date')->nullable();
            $table->string('user_approve')->nullable();
            $table->date('user_process_at')->nullable();
            $table->string('asec_officer_service_no')->nullable();
            $table->string('officer_one')->nullable();
            $table->string('officer_two')->nullable();
            $table->string('officer_three')->nullable();
            $table->string('officer_four')->nullable();
            $table->string('officer_five')->nullable();
            $table->dateTime('asec_assign_officers_at')->nullable();
            $table->dateTime('officer_one_completed_at')->nullable();
            $table->dateTime('officer_two_completed_at')->nullable();
            $table->dateTime('officer_three_completed_at')->nullable();
            $table->dateTime('officer_four_completed_at')->nullable();
            $table->dateTime('officer_five_completed_at')->nullable();
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
        Schema::dropIfExists('army_confidential_reports');
    }
};
