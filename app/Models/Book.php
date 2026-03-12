<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Traits\InteractsWithUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

final class Book extends Model
{
    use HasFactory;
    use InteractsWithUuid;
    

    protected $appends = ['cover_image', 'book_url'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'author',
        'serial_number',
        'book_category_id',
        'description',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [];

    public function category()
    {
        return $this->belongsTo(BookCategory::class, 'book_category_id', 'id');
    }

    public function getCoverImageAttribute()
    {
        if ($this->hasMedia('cover')) {
            return $this->firstMedia('cover')->getUrl();
        }

        return asset('img/identity.png');
    }

    public function getBookUrlAttribute()
    {
        if ($this->hasMedia('book')) {
            return $this->firstMedia('book')->getAbsolutePath();

            return $this->firstMedia('book')->getUrl();
        }

        return asset('img/identity.png');
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            $model->slug = Str::slug($model->title);
        });
    }
}
