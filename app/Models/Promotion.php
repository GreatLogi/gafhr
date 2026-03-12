<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Traits\InteractsWithUuid;
use App\Traits\SaveToUpper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class Promotion extends Model
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
        'previous_rank_code',
        'promoted_to_rank_code',
        'promotion_type',
        'effective_date',
        'seniority_date',
        'authority_remarks',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [];

    public function promoted_rank()
    {
        return $this->hasOne(Rank::class, 'rank_code', 'promoted_to_rank_code');
    }

    public function previous_rank()
    {
        return $this->hasOne(Rank::class, 'rank_code', 'previous_rank_code');
    }

    public function personnel()
    {
        return $this->belongsTo(Personnel::class);
    }
}
