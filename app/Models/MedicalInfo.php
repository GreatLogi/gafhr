<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Traits\InteractsWithUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class MedicalInfo extends Model
{
    use HasFactory;
    use InteractsWithUuid;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'personnel_id',
        'vaccinated',
        'med_vax_case',
        'vaccine_type',
        'vax_date',
        'physique',
        'upper_limbs',
        'lower_limbs',
        'hearing_right',
        'hearing_left',
        'eyesight_right',
        'eyesight_left',
        'mental_function',
        'stability',
        'authority_remarks',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [];
}
