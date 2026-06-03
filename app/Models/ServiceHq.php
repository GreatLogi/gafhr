<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Traits\InteractsWithUuid;
use App\Traits\SaveToUpper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class ServiceHq extends Model
{
    use HasFactory;
    use InteractsWithUuid;
    use SaveToUpper;

    protected $fillable = [
        'ghq_id',
        'service_name',
        'service_code',
    ];

    public function ghq()
    {
        return $this->belongsTo(Ghq::class);
    }

    public function commandHqs()
    {
        return $this->hasMany(CommandHq::class);
    }

    public function personnel()
    {
        return $this->hasMany(Personnel::class);
    }
}
