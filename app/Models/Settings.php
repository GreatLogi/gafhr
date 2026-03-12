<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Traits\InteractsWithUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class Settings extends Model
{
    use HasFactory;
    use InteractsWithUuid;

    // protected $appends = ['value'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'key',
        'value',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'value' => 'array',
    ];

    // public function getValueAttribute()
    // {
    //     if (! is_array($this->configs)) {
    //         return $this->configs;
    //     }

    //     return $this->configs;

    //     if (count($this->configs) < 2) {
    //         return $this->configs[0];
    //     } else {
    //         return $this->configs;
    //     }
    // }
}
