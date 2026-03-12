<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Traits\InteractsWithUuid;
use App\Traits\SaveToUpper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;

final class Document extends Model
{
    use HasFactory;
    use InteractsWithUuid;
    use SaveToUpper;

    protected $appends = ['url'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'personnel_id',
        'document_name',

    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('Document')
            ->logOnly($this->fillable)
            ->logOnlyDirty();
    }

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [];

    public function getUrlAttribute()
    {
        if ($this->hasMedia('documents')) {
            return $this->firstMedia('documents')->getUrl();
        }

        return asset('img/identity.png');
    }
}
