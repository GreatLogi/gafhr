<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Traits\InteractsWithUuid;
use App\Traits\SaveToUpper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class Posting extends Model
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
        'post_from',
        'post_to',
        'post_type',
        'wef_date',
        'end_date',
        'appointment_id',
        'appointment_type',
        'authority_remarks',

    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [];

    public function posted_from()
    {
        return $this->belongsTo(Unit::class, 'post_from', 'id');
    }

    public function posted_to()
    {
        return $this->belongsTo(Unit::class, 'post_to', 'id');
    }

    public function appointment()
    {
        return $this->belongsTo(Appointment::class, 'appointment_id', 'id');
    }

    public function personnel()
    {
        return $this->belongsTo(Personnel::class, 'personnel_id', 'id');
    }

    // public function x_list()
    // {
    //     return $this->belongsTo(Personnel::class, 'personnel_id', 'id')->where('post_type', 'X LIST');
    // }
}
