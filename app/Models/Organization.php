<?php

namespace App\Models;

use App\Models\Address;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Organization extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::deleted(function ($organization) {
            $organization->address()->delete();
            $organization->users()->detach();
        });
    }

    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('member_type');
    }

    public function address()
    {
        return $this->morphOne(Address::class, 'addressable');
    }
}
