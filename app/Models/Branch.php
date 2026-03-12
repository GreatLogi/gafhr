<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Traits\InteractsWithUuid;
use App\Traits\SaveToUpper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class Branch extends Model
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
        'branch',
        'arm_of_service',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'trades' => 'array',
    ];

    // public function trades()
    // {
    //     return $this->hasMany(Trade::class);
    // }
    
    public function trades()
    {
        return $this->hasMany(Trade::class);
    }

    public function professions()
    {
        return $this->hasMany(Profession::class);
    }

    public function personnel()
    {
        return $this->hasMany(Personnel::class);
    }
}
