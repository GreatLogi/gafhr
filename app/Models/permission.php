<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Permission as ModelsPermission;

class Permission extends ModelsPermission
{
    use HasFactory;

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

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            $model->guard_name = 'web';
        });
    }
}
