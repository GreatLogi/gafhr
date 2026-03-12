<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Traits\InteractsWithUuid;
use App\Traits\SaveToUpper;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Lab404\Impersonate\Models\Impersonate;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Sanctum\PersonalAccessToken;
use LaravelAndVueJS\Traits\LaravelPermissionToVueJS;
use Spatie\Permission\Traits\HasRoles;

/**
 * App\Models\User.
 *
 * @property int $id
 * @property string $uuid
 * @property string $name
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read DatabaseNotificationCollection|DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read Collection|PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 *
 * @method static UserFactory factory(...$parameters)
 * @method static Builder|User findByUuid(string $uuid)
 * @method static Builder|User findOrFailByUuid(string $uuid)
 * @method static Builder|User newModelQuery()
 * @method static Builder|User newQuery()
 * @method static Builder|User query()
 * @method static Builder|User whereCreatedAt($value)
 * @method static Builder|User whereEmail($value)
 * @method static Builder|User whereEmailVerifiedAt($value)
 * @method static Builder|User whereId($value)
 * @method static Builder|User whereName($value)
 * @method static Builder|User wherePassword($value)
 * @method static Builder|User whereRememberToken($value)
 * @method static Builder|User whereUpdatedAt($value)
 * @mixin \Eloquent
 *
 * @method static Builder|User whereUuid($value)
 *
 * @property-read Collection|Post[] $posts
 * @property-read int|null $posts_count
 */
final class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use InteractsWithUuid;
    use Notifiable;
   
    
    use HasRoles;
    
   
    use SaveToUpper;
 

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'service_no',
        'title',
        'name',
        'surname',
        'first_name',
        'other_names',
        'appointment_id',
        'email',
        'phone',
        'rank_code',
        'status',
        'password',
        'theme',
        'password_updated_at',
        'arm_of_service',
        'category',
        'service_email',
        'appointment_email',
        'current_signature',
    ];

    protected $guard_name = 'web';

  

    protected $appends = [
        // 'initials',
        // 'avatar',
        'portals',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function personnel()
    {
        return $this->hasOne(Personnel::class, 'service_no', 'service_no');
    }

    public function last_login()
    {
        return $this->hasOne(LoginLog::class, 'model_id', 'id')->latest();
    }

    public function logins()
    {
        return $this->hasMany(LoginLog::class, 'model_id', 'id');
    }

    public function getAvatarAttribute()
    {
        if ($this->firstMedia('avatar')) {
            return $this->firstMedia('avatar')->getUrl();
        }

        return asset('img/avatar.jpg');
    }

    public function getSignatureAttribute()
    {
        if ($this->hasMedia('signature')) {
            return $this->firstMedia('signature')->getUrl();
        }

        return null;
    }

    // public function getInitialsAttribute()
    // {
    //     $initials = initials($this->first_name.' '.$this->other_names);

    //     if ($this->level == 'OFFICER') {
    //         return  $initials.' '.$this->surname;
    //     } else {
    //         return  $this->surname.' '.$initials;
    //     }
    // }

    // public function getLevelAttribute()
    // {
    //     return $this->category == 'OFFICER' ? 'OFFICER' : category()[$this->arm_of_service];
    // }

    public function getPortalsAttribute()
    {
        return PortalAccess::where('service_no', $this->service_no)->pluck('portal');
    }

    public function portal_access()
    {
        return $this->hasMany(PortalAccess::class, 'service_no', 'service_no');
    }

    public function generateAndSendOTP(): int
    {
        $otp = random_int(100000, 999999);
        $this->otp_code = (string) $otp;
        $this->save();

        return $otp;
    }
}
