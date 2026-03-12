<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Traits\InteractsWithUuid;
use App\Traits\SaveToUpper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;

final class NavalConfidentialReport extends Model
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
        'report_no',
        'report_unique_id',
        'surname',
        'initials',
        'present_rank',
        'commission_type',
        'date_promoted',
        'branch_id',
        'date_of_birth',
        'marital_status',
        'children',
        'children_sex',
        'unit_id',
        'date_posted',
        'appointment_id',
        'primary_duties',
        'secondary_duties',
        'military_or_civilian_courses_desired',
        'employment_desired_on_next_posting',
        'factors_affecting_future_posting',
        'zeal_and_energy',
        'reliability',
        'common_sense',
        'intelligence_and_power',
        'initiative_and_alertness',
        'leadership',
        'power_of_expression',
        'organising_ability',
        'tact_and_co_operation',
        'first_narrative_comment',
        'second_narrative_comment',
        'third_narrative_comment',
        'recommending_training_regarding_next_stage',
        'recommending_posting_regarding_next_stage',
        'recommending_employment_regarding_next_stage',
        'first_comparative_assessment',
        'second_comparative_assessment',
        'first_recommendation_for_promotion',
        'second_recommendation_for_promotion',
        'third_recommendation_for_promotion',
        'third_senior_officer_remarks',
        'third_senior_officer_knowledge_of_officer',
        'forth_senior_officer_remarks',
        'forth_senior_officer_knowledge_of_officer',
        'fifth_senior_officer_remarks',
        'sixth_senior_officer_remarks',
        'officer_one',
        'officer_two',
        'officer_three',
        'officer_four',
        'officer_five',
        'naval_sec_assign_officers_at',
        'officer_one_completed_at',
        'officer_two_completed_at',
        'officer_three_completed_at',
        'officer_four_completed_at',
        'officer_five_completed_at',
        'children_age',
        'social_attributes',
        'period_from',
        'period_to',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('NavalConfidentialReport')
            ->logOnly($this->fillable)
            ->logOnlyDirty();
    }

    public function organic_unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id', 'id');
    }

    public function appointment()
    {
        return $this->belongsTo(Appointment::class, 'appointment_id', 'id');
    }

    public function promoted_rank()
    {
        return $this->hasOne(Rank::class, 'rank_code', 'promoted_to_rank_code');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'id');
    }

    public function current_rank()
    {
        return $this->hasOne(Rank::class, 'rank_code', 'present_rank');
    }

    public function reporting_officer_one()
    {
        return $this->belongsTo(Personnel::class, 'officer_one', 'service_no');
    }

    public function reporting_officer_two()
    {
        return $this->belongsTo(Personnel::class, 'officer_two', 'service_no');
    }

    public function reporting_officer_three()
    {
        return $this->belongsTo(Personnel::class, 'officer_three', 'service_no');
    }

    public function reporting_officer_four()
    {
        return $this->belongsTo(Personnel::class, 'officer_four', 'service_no');
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
        'primary_duties' => 'array',
        'secondary_duties' => 'array',
    ];
}
