<?php

namespace App\Models;

use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class User extends Authenticatable implements HasMedia
{
    use HasApiTokens, HasFactory, Notifiable, InteractsWithMedia;

    public static $roles = ['enumerator', 'viewer', 'member'];

    public static $fakeEmail = "saekedelai.com";

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_superadmin',
        'phone_number',
        'id_number',
        'role'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::created(function ($user) {
            $user->address()->firstOrCreate();
        });

        static::deleted(function ($user) {
            $user->address()->delete();
            $user->organizations()->detach();
        });
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('profile_picture')->singleFile();
    }

    public function scopeWithProfilePicture($query)
    {
        $query->addSelect([
            'profile_picture_id' => Media::select('id')
                ->where('model_type', User::class)
                ->whereColumn('model_id', 'users.id')
                ->limit(1)
        ])->with('profilePicture');
    }

    public function profilePicture()
    {
        return $this->belongsTo(Media::class);
    }

    public function address()
    {
        return $this->morphOne(Address::class, 'addressable');
    }

    public function organizations()
    {
        return $this->belongsToMany(Organization::class)->withPivot('member_type');
    }

    public function fields()
    {
        return $this->hasMany(Field::class);
    }

    public static function getRoles()
    {
        return self::$roles;
    }

    /**
     * check if whether the user has the role
     *
     * @param array $roles
     * @return boolean
     */
    public function hasRole(array $roles = [])
    {
        if (in_array($this->role, $roles)) {
            return true;
        }

        return false;
    }

    public function generateFakeEmail()
    {
        return Str::snake($this->name) . substr($this->phone_number, -3) . "@" . self::$fakeEmail;
    }
}
