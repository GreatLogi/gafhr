<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Traits\InteractsWithUuid;
use App\Traits\SaveToUpper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;
    use SaveToUpper;
    use InteractsWithUuid;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'country_name',
        'mission_name',
        'created_by',
        'updated_by',
    ];
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [];
    /**
     * The attributes that should be converted to uppercase.
     *
     * @var array
     */
    protected static $uppercaseAttributes = [
        'arm_of_service',
    ];
    /**
     * Get the list of attributes that should be converted to uppercase.
     *
     * @return array
     */
    protected static function getUppercaseAttributes()
    {
        return self::$uppercaseAttributes;
    }
}
