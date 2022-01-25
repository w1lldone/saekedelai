<?php

namespace App\Models;

use App\Models\Address;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Field extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function address()
    {
        return $this->morphOne(Address::class, 'addressable');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function plantings()
    {
        return $this->hasMany(\App\Models\Planting::class);
    }

    public function lastPlanting()
    {
        return $this->belongsTo(\App\Models\Planting::class);
    }

    public function scopeWithLastPlanting($query)
    {
        $query->addSelect([
            'last_planting_id' => \App\Models\Planting::select('id')
                ->whereColumn('field_id', 'fields.id')
                ->orderByDesc('started_at')
                ->limit(1)
        ])->with('lastPlanting');
    }
}
