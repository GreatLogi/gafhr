<?php
declare (strict_types = 1);
namespace App\Models;

use App\Models\Traits\InteractsWithUuid;
use App\Traits\SaveToUpper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class GAFTOTRAVELRECORD extends Model implements Auditable
{
    use HasFactory;
    use InteractsWithUuid;
    use SaveToUpper;
    use \OwenIt\Auditing\Auditable;
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
        'blood_group',
        'mobile_no',
        'email',
        'arm_of_service',
        'unit_name',
        'status',
        'today_date',
        'purpose',
        'country',
        'destination_address',
        'ticket_number',
        'departure_flight_number',
        'return_flight_number',
        'departure_date',
        'departuredays',
        'return_date',
        'arrivaldays',
        'etd',
        'eta',
        'passport_number',
        'passport_expiry_date',
        'passport_expiry_days',
        'amount',
        'sponsorship',
        'responsibility',
        'personnel_image',
        'remarks',
        'created_by',
        'updated_by',
          'travelled_with_civ',
           'civ_state',
           'civ_full_name',
           'civ_gender',
           'civ_mobile_no',
           'civ_email',
    ];
    public function country()
    {
        return $this->belongsTo(Country::class, 'country', 'id');
    }
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [

    ];
}
