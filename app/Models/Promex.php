<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Traits\InteractsWithUuid;
use App\Traits\SaveToUpper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class Promex extends Model
{
    use HasFactory;
    use InteractsWithUuid;
    use SaveToUpper;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'promex';

    protected $fillable = [
        'personnel_id',
        'bft_done',
        'level',
        'category',
        'attempt',
        'attempts_remaining',
        'year',
        'remarks',
        'bft_status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [];
}
