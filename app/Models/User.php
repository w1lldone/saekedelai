<?php

namespace App\Models;

use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

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
    }

    public function address()
    {
        return $this->morphOne(Address::class, 'addressable');
    }

    public function organizations()
    {
        return $this->belongsToMany(Organization::class)->withPivot('member_type');
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
        return Str::snake($this->name).substr($this->phone_number,-3)."@".self::$fakeEmail;
    }
}
