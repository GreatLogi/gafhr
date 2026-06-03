<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Traits\InteractsWithUuid;
use App\Traits\SaveToUpper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class Directorate extends Model
{
    use HasFactory;
    use InteractsWithUuid;
    use SaveToUpper;

    protected $fillable = [
        'ghq_id',
        'directorate_name',
        'directorate_code',
        'description',
    ];

    public function ghq()
    {
        return $this->belongsTo(Ghq::class);
    }

    public function personnel()
    {
        return $this->hasMany(Personnel::class);
    }
}
