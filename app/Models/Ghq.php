<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Traits\InteractsWithUuid;
use App\Traits\SaveToUpper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class Ghq extends Model
{
    use HasFactory;
    use InteractsWithUuid;
    use SaveToUpper;

    protected $fillable = [
        'name',
        'location',
    ];

    public function departments()
    {
        return $this->hasMany(Department::class);
    }

    public function directorates()
    {
        return $this->hasMany(Directorate::class);
    }

    public function serviceHqs()
    {
        return $this->hasMany(ServiceHq::class);
    }
}
