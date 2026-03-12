<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Traits\InteractsWithUuid;
use App\Traits\SaveToUpper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;

final class NavyConfidentialReportRequest extends Model
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
        'service_no',
        'initials',
        'present_rank',
        'commission_type',
        'branch_id',
        'request_message',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('NavyConfidentialReportRequest')
            ->logOnly($this->fillable)
            ->logOnlyDirty();
    }

    public function personnel()
    {
        return $this->hasOne(Personnel::class, 'service_no', 'service_no');
    }

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        // Ensure you add any casts here if needed
    ];
}
