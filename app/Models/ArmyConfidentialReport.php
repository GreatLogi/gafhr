<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Traits\InteractsWithUuid;
use App\Traits\SaveToUpper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;

final class ArmyConfidentialReport extends Model
{
    use HasFactory;
    use InteractsWithUuid;
    use SaveToUpper;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    
    protected $fillable = [
        'personnel_id',
        'languages',
        'decorations',
        'report_no',
        'pes',
        'pes_date',
        'report_unique_id',
        'any_other_languages',
        'course_name',
        'course_grade',
        'institution',
        'present_rank',
        'initials',
        'temporary_rank',
        'date_of_birth',
        'seniority_date',
        'arm_of_service',
        'commission_type',
        'unit_id',
        'marital_status',
        'qualification_psc',
        'assessment',
        'sense_of_duty',
        'loyalty',
        'proficiency_in_current_duties',
        'integrity',
        'example',
        'presence',
        'turnout',
        'physical_fitness',
        'social_conduct',
        'determination_infield',
        'reliability_infield',
        'judgement_infield',
        'initiative_and_improvisation_infield',
        'self_confidence_infield',
        'presence_of_mind_infield',
        'level_of_knowledge_1_infield',
        'level_of_knowledge_2_infield',
        'organising_ability_infield',
        'cooperation_infield',
        'tact_infield',
        'intelligence_infield',
        'power_of_expression_oral_infield',
        'power_of_expression_written_infield',
        'technical_proficiency_infield',
        'determination_inoffice',
        'reliability_inoffice',
        'judgement_inoffice',
        'initiative_and_improvisation_inoffice',
        'self_confidence_inoffice',
        'presence_of_mind_inoffice',
        'level_of_knowledge_1_inoffice',
        'level_of_knowledge_2_inoffice',
        'organising_ability_inoffice',
        'cooperation_inoffice',
        'tact_inoffice',
        'intelligence_inoffice',
        'power_of_expression_oral_inoffice',
        'power_of_expression_written_inoffice',
        'technical_proficiency_inoffice',
        'power_to_inspire_infield',
        'power_of_command_infield',
        'discipline_infield',
        'attitude_towards_sub_officers_infield',
        'attitude_towards_men_infield',
        'leader_self_confidence_infield',
        'power_to_inspire_inoffice',
        'power_of_command_inoffice',
        'discipline_inoffice',
        'attitude_towards_sub_officers_inoffice',
        'attitude_towards_men_inoffice',
        'leader_self_confidence_inoffice',
        'field_duties_ex',
        'field_duties_above_av8',
        'field_duties_above_av7',
        'field_duties_average6',
        'field_duties_average5',
        'field_duties_average4',
        'field_duties_below_av3',
        'field_duties_below_av2',
        'field_duties_poor',
        'office_duties_ex',
        'office_duties_above_av8',
        'office_duties_above_av7',
        'office_duties_average6',
        'office_duties_average5',
        'office_duties_average4',
        'office_duties_below_av3',
        'office_duties_below_av2',
        'office_duties_poor',
        'professional_efficiency_ex',
        'professional_efficiency_above_av8',
        'professional_efficiency_above_av7',
        'professional_efficiency_average6',
        'professional_efficiency_average5',
        'professional_efficiency_average4',
        'professional_efficiency_below_av3',
        'professional_efficiency_below_av2',
        'professional_efficiency_poor',

        'extra_regimental_1',
        'extra_regimental_1_ex',
        'extra_regimental_1_above_av8',
        'extra_regimental_1_above_av7',
        'extra_regimental_1_average6',
        'extra_regimental_1_average5',
        'extra_regimental_1_average4',
        'extra_regimental_1_below_av3',
        'extra_regimental_1_below_av2',
        'extra_regimental_1_poor',

        'extra_regimental_2',
        'extra_regimental_2_ex',
        'extra_regimental_2_above_av8',
        'extra_regimental_2_above_av7',
        'extra_regimental_2_average6',
        'extra_regimental_2_average5',
        'extra_regimental_2_average4',
        'extra_regimental_2_below_av3',
        'extra_regimental_2_below_av2',
        'extra_regimental_2_poor',

        'extra_regimental_3',
        'extra_regimental_3_ex',
        'extra_regimental_3_above_av8',
        'extra_regimental_3_above_av7',
        'extra_regimental_3_average6',
        'extra_regimental_3_average5',
        'extra_regimental_3_average4',
        'extra_regimental_3_below_av3',
        'extra_regimental_3_below_av2',
        'extra_regimental_3_poor',

        'acting_outstanding',
        'acting_above_rank',
        'acting_up_to_rank',
        'acting_below_rank',

        'substantive_outstanding',
        'substantive_above_rank',
        'substantive_up_to_rank',
        'substantive_below_rank',

        'to_the_next_substantive',
        'to_the_next_acting',
        'appointment_higher_rank',
        'reached_ceiling',
        'passed_by_better_ability',
        'recommend_next_appointment',
        'future_appointment',
        'additional_remarks',

        'grading',
        'report_covered_date_from',
        'report_covered_date_to',
        'served_under_you_from_date',
        'served_under_you_to_date',
        'last_appointment_held_date',
        'present_appointment_held_date',
        'suitable_for_selection_for_appointment_at_gma',
        'suitable_for_staff_tfg',
        'served_with_troops',

        'practical_passed_lt_cpt',
        'written_passed_lt_cpt',
        'lt_to_cpt_exams_date',
        'practical_passed_cpt_maj',
        'written_passed_cpt_maj',
        'cpt_to_maj_exams_date',
        'head_of_service_date',

        'first_superior_knowledge_about_personnel',
        'agree_with_initiation_officer',
        'first_superior_remarks',
        'head_of_service_process_at',

        'second_superior_knowledge_about_personnel',
        'second_superior_remarks',
        'second_superior_reporting_officer_process_at',

        'third_superior_knowledge_about_personnel',
        'third_superior_remarks',
        'third_superior_reporting_officer_process_at',

        'user_approve',
        'user_process_at',
        'initiation_officer_service_no',
        'asec_officer_service_no',
        'head_of_service_officer_service_no',
        'first_superior_officer_service_no',
        'second_superior_officer_service_no',
        'third_superior_officer_service_no',

        'officer_one',
        'officer_two',
        'officer_three',
        'officer_four',
        'officer_five',
        'asec_assign_officers_at',
        'officer_one_completed_at',
        'officer_two_completed_at',
        'officer_three_completed_at',
        'officer_four_completed_at',
        'officer_five_completed_at',

    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('Confidential Report')
            ->logOnly($this->fillable)
            ->logOnlyDirty();
    }

    public function organic_unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id', 'id');
    }

    public function current_rank()
    {
        return $this->hasOne(Rank::class, 'rank_code', 'present_rank');
    }

    public function personnel()
    {
        return $this->belongsTo(Personnel::class, 'personnel_id', 'id');
    }

    public function upload_signature()
    {
        return $this->belongsTo(Admin::class, 'service_number', 'id');
    }

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'languages' => 'array',
        'assessment' => 'array',
        'grading' => 'array',
    ];
}
