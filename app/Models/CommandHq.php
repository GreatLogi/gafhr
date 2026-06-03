<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Traits\InteractsWithUuid;
use App\Traits\SaveToUpper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class CommandHq extends Model
{
    use HasFactory;
    use InteractsWithUuid;
    use SaveToUpper;

    protected $fillable = [
        'service_hq_id',
        'command_name',
        'command_code',
        'command_type',
    ];

    public function serviceHq()
    {
        return $this->belongsTo(ServiceHq::class);
    }

    public function units()
    {
        return $this->hasMany(Unit::class);
    }

    public function personnel()
    {
        return $this->hasMany(Personnel::class);
    }
}
