<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Traits\InteractsWithUuid;
use App\Traits\SaveToUpper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;

final class MsList extends Model
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
        'seniority_roll',
        'service_no',
        'ms_date',
        'remarks',
        'appointment_id',
        'unit_id',
        'ms_publication_id',
    ];

    public function ms_pub()
    {
        return $this->belongsTo(MsPublication::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function personnel()
    {
        return $this->belongsTo(Personnel::class, 'service_no', 'service_no');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('MsList')
            ->logOnly($this->fillable)
            ->logOnlyDirty();
    }

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [];
}
