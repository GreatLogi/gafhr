<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Traits\InteractsWithUuid;
use App\Traits\SaveToUpper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class Family extends Model
{
    use HasFactory;
    use InteractsWithUuid;
    use SaveToUpper;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, >
     */
    protected $fillable = [
        'personnel_id',
        'family_relation',
        'sex',
        'full_name',
        'date_of_birth',
        'nationality',
        'status',
        'place_of_birth',
        'house_address',
        'authority_remarks',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<, >
     */
    protected $casts = [];
}
