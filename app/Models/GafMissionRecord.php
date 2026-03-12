<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Traits\InteractsWithUuid;
use App\Traits\SaveToUpper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class GafMissionRecord extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    use SaveToUpper;
    use InteractsWithUuid;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'svcnumber',
        'rank_name',
        'surname',
        'othernames',
        'first_name',
        'initial',
        'gender',
        'mobile_no',
        'email',
        'arm_of_service',
        'unit_name',
        'today_date',
        'departure_date',
        'departuredays',
        'country',
        'arrivaldays',
        'status',
        'today_date',
        'chalk_list',
        'appointment_name',
        'ghanbatt_name',
        'service_category',
        'return_date',
        'mission_name',
        'un_email',
        'un_id',
        'coy',
        'cell',
        'passport_number',
        'passport_expiry_date',
        'passport_expiry_days',
        'personnel_image',
        'remarks',
        'repatriation_remarks',
        'password',
        'password_changed_at',
        'created_by',
        'updated_by',
    ];

    public function ranks()
    {
        return $this->belongsTo(rank::class, 'rank_id', 'id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id', 'id');
    }

    public function units()
    {
        return $this->belongsTo(unit::class, 'unit_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getFullNameAttribute()
    {
        return "{$this->surname} {$this->othernames}";
    }

    public function GafMissionRecords()
    {
        return $this->hasMany(rank::class);
    }

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [];
}
