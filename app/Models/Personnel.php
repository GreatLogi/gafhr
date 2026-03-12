<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Traits\InteractsWithUuid;
use App\Traits\SaveToUpper;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;
use Spatie\Activitylog\LogOptions;
use Storage;

final class Personnel extends Model
{
    use HasFactory;
    use InteractsWithUuid;
    use SaveToUpper;
    use Notifiable;

    protected $table = 'personnel';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'seniority_roll',
        'service_no',
        'surname',
        'first_name',
        'other_names',
        'initials',
        'sex',
        'date_of_birth',
        'age',
        'place_of_birth',
        'blood_group',
        'marital_status',
        'status',
        'current_status',
        'arm_of_service',
        'enlistment_date',
        'rod',
        'pto',
        'engagement_date',
        'intake',
        'intake_number',
        'place_of_commission',
        'commission_type',
        'commission_date',
        'rank_code',
        'rank_on_commission',
        'present_rank',
        'present_rank_date',
        'unit_id',
        'attached_unit',
        'rtu',
        'present_location',
        'branch_id',
        'trade_id',
        'squadron',
        'disposition',
        'conversion_date',
        'conversion_snr_date',
        'appointment_type',
        'hometown',
        'hometown_region',
        'hometown_district',
        'tribe_id',
        'residential_address',
        'digital_address',
        'ghana_card_number',
        'passport_number',
        'email',
        'phone',
        'secondary_phone',
        'languages_spoken',
        'hobbies',
        'religion',
        'denomination_id',
        'appointment_id',
        'profession_id',
        'personnel_image',
        'rank_type',
        'seniority_date',
        'level',

        'status_authority_remarks',
        'status_changed_at',

        'accommodation',
        'bks_accn',

        'trade_group_id',
        'trade_group',
        'trade_group_date',
        'trade_group_category_id',
        'trade_classification',

        'engagement',
        'rank_type',
        'pass_out_rank',
        'intake_year',
        'sea_trg',
        'btn_results',

        'confirmation_date',
        'disability',
        'type_of_disability',
        'rank_on_entry',
        'type_of_qualification',
        'education_category',
        'medical',
        'type_of_qualification',
        'service_email',

        'end_of_leave',
    ];

    

    protected $appends = [
        'photo',
        'course',
        'rank_name',
        'svc_email',
    ];

    public function getSvcEmailAttribute()
    {
        if (!empty($this->service_email)) {
            return $this->service_email;
        }

        if (function_exists('generateServiceEmail')) {
            return generateServiceEmail($this);
        }

        return null;
    }

    public function getPhotoAttribute()
    {
        if (!empty($this->personnel_image)) {
            return asset($this->personnel_image);
        }

        return '/img/avatar.jpg';
    }

    public function organic_unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id', 'id');
    }

    public function present_unit()
    {
        return $this->belongsTo(Unit::class, 'present_location', 'id');
    }

    public function attach_unit()
    {
        return $this->belongsTo(AttachedUnit::class, 'attached_unit', 'id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'id');
    }

    public function trade()
    {
        return $this->belongsTo(Trade::class, 'trade_id', 'id');
    }

    public function tradegroup()
    {
        return $this->belongsTo(TradeGroup::class, 'trade_group_id', 'id');
    }



    public function tribe()
    {
        return $this->belongsTo(Tribe::class, 'tribe_id', 'id');
    }

    public function denominations()
    {
        return $this->belongsTo(Denomination::class, 'denomination_id', 'id');
    }

    public function home_region()
    {
        return $this->hasOne(Region::class, 'id', 'hometown_region');
    }

    public function current_rank()
    {
        return $this->hasOne(Rank::class, 'rank_code', 'present_rank');
    }

    public function commission_rank()
    {
        return $this->hasOne(Rank::class, 'rank_code', 'rank_on_commission');
    }

    public function swimming()
    {
        return $this->hasMany(Swimming::class);
    }

    public function awards()
    {
        return $this->hasMany(Award::class);
    }

    public function courses()
    {
        return $this->hasMany(Course::class)->latest('end_date');
    }

    public function sq_courses()
    {
        return $this->hasMany(SqCourse::class);
    }

    public function promotion_courses()
    {
        return $this->hasMany(PromotionCourse::class);
    }

    public function promotions()
    {
        return $this->hasMany(Promotion::class)->latest('effective_date');
    }

    public function education()
    {
        return $this->hasMany(CivilEducation::class)->latest('from');
    }

    public function idcards()
    {
        return $this->hasMany(IdCard::class);
    }

    public function medinfo()
    {
        return $this->hasMany(MedicalInfo::class);
    }

    public function family()
    {
        return $this->hasMany(Family::class);
    }

    public function posts()
    {
        return $this->hasMany(Posting::class)->latest('wef_date');
    }

    public function appointments()
    {
        return $this->hasMany(Posting::class)->whereNotNull('appointment_id')->latest('wef_date');
    }

    public function operations()
    {
        return $this->hasMany(ExternalOperation::class)->latest('wef_date');
    }

    public function promex()
    {
        return $this->hasMany(Promex::class)->latest('year');
    }

    public function next_of_kin()
    {
        return $this->hasOne(NextOfKin::class);
    }

    public function remarks()
    {
        return $this->hasMany(Remark::class);
    }

    public function appointment()
    {
        return $this->belongsTo(Appointment::class, 'appointment_id', 'id');
    }

    public function profession()
    {
        return $this->belongsTo(Profession::class, 'profession_id', 'id');
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function leave()
    {
        return $this->hasMany(Leave::class);
    }

    public function currentRank()
    {
        return $this->hasOne(Rank::class, 'rank_code', 'present_rank');
    }

    public function interviews()
    {
        return $this->hasMany(Interview::class);
    }

    public function offences()
    {
        return $this->hasMany(Disciplinary::class);
    }

    public function confidential_reports()
    {
        return $this->hasMany(ArmyConfidentialReport::class);
    }

    public function personnel_children()
    {
        return $this->hasMany(Family::class)
            ->whereIn('family_relation', ['DAUGHTER', 'SON']);
    }

    public function getFullNameAttribute()
    {
        return $this->attributes['surname'] . '  ' . $this->attributes['other_names'] . '  ' . $this->attributes['first_name'];
    }

    public function getCourseAttribute()
    {
        if ($this->level != 'OFFICER' && ! empty($this->intake)) {
            $parts = explode(' ', $this->intake);
            $year_parts = explode('/', $parts[1]);

            return [
                'part_1' => $parts[0] ?? null,
                'part_2' => $year_parts[0] ?? null,
                'part_3' => $year_parts[1] ?? null,
            ];
        }

        if ($this->level == 'OFFICER' && ! empty($this->intake)) {
            $parts = explode(' ', $this->intake);

            return [
                'part_1' => $parts[0] ?? null,
                'part_2' => $parts[1] ?? null,
            ];
        }

        return null;
    }

  

    public function getRankNameAttribute()
    {
        if (empty($this->current_rank)) {
            return '...';
        }

        $column = str()->slug(str_replace(' ', '', $this->arm_of_service)) . '_display';

        return $this->current_rank->$column;
    }

    

    public function user()
    {
        return $this->belongsTo(User::class, 'service_no', 'service_no');
    }

    public function portals()
    {
        return $this->hasMany(PortalAccess::class, 'service_no', 'service_no');
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            if ($model->surname != null || $model->surname != '') {
                $initials = initials($model->first_name . ' ' . $model->other_names);

                if ($model->level == 'OFFICER') {
                    $model->initials = $initials . ' ' . $model->surname;
                } else {
                    $model->initials = $model->surname . ' ' . $initials;
                }
            }

            $model->service_email = generateServiceEmail($model);

            if ($model->isDirty('email') || $model->isDirty('phone') || $model->isDirty('appointment_id')) {
                if ($model->user) {
                    $model->user->update([
                        'email' => $model->email,
                        'phone' => $model->phone,
                        'appointment_id' => $model->appointment_id,
                    ]);
                }
            }

            update_puf_phone($model->service_no, $model->phone, $model->secondary_phone);

            if ($model->date_of_birth != null || $model->date_of_birth != '') {
                $model->age = Carbon::parse($model->date_of_birth)->age;
            }
        });

        static::creating(
            function ($model) {
                $model->current_status = 'ACTIVE';
            }
        );
    }

    public function getSignatureAttribute()
    {
        $filename = public_path('uploads/signature/' . str_replace('/', '-', $this->service_no) . '.png');

        return $new_signature = str_replace('chr', 'mygafportal', $this->service_no);

        return null;
    }

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'languages_spoken' => 'array',
        'hobbies' => 'array',
        // 'seniority_date' => 'date'
        // 'enlistment_date' => 'date: Y-m-d',
        'end_of_leave' => 'date: Y-m-d',
        'puf_last_update' => 'date: d F Y, H:i',
    ];
}
