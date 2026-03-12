<?php

namespace App\Models;

use App\Traits\SaveToUpper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    use HasFactory;
    use SaveToUpper;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    
    protected $fillable = [
        'name',
        'portal',
        'guard_name',
    ];

    protected $casts = [];

    protected $appends = [
        'list',
    ];

    public function getListAttribute()
    {
        return $this->permissions()->pluck('name');
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {

            // if (substr($model->name, 0, strlen($model->portal)) != $model->portal) {
            //     $model->name = Str::upper($model->portal . '_' . $model->name);
            // } else {
            //     $model->name = Str::upper($model->name);
            // }

            $model->name = Str::upper($model->name);

            $model->guard_name = 'web';
        });
    }
}
