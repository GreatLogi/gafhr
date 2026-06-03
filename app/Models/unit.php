<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Traits\InteractsWithUuid;
use App\Traits\SaveToUpper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class Unit extends Model
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
        'unit',
        'unit_name',
        'unit_code',
        'unit_type',
        'arm_of_service',
        'command_hq_id',
        'created_by',
        'updated_by',
        'uuid',
        'attached_units',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        // 'attached_units' => 'array'
    ];

    public function attached_units()
    {
        return $this->hasMany(AttachedUnit::class);
    }

    public function commandHq()
    {
        return $this->belongsTo(CommandHq::class);
    }
}
