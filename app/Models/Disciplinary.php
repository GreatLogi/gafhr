<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Traits\InteractsWithUuid;
use App\Traits\SaveToUpper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;

final class Disciplinary extends Model
{
    use HasFactory;
    use InteractsWithUuid;
    use SaveToUpper;

    protected $appends = ['doc'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'personnel_id',
        'unit_id',
        'disciplinary_type',
        'place_of_offense',
        'date_of_offense',
        'findings_of_offense',
        'award',
        'part_order_number',
        'board_member_name',
        'witness_name',
        'offenses',
        'number_of_offenses',

    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('Disciplinary')
            ->logOnly($this->fillable)
            ->logOnlyDirty();
    }

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'board_member_name' => 'array',
        'witness_name' => 'array',
        'offenses' => 'array',
    ];

    public function getDocAttribute()
    {
        $media = [];
        if ($this->hasMedia('document')) {
            foreach ($this->getMedia('document') as $file) {
                $media[] = [
                    'id' => $file->id,
                    'url' => $file->getUrl(),
                ];
            }
        }

        return $media;
    }
}
