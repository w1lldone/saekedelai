<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Planting extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $dates = ['started_at', 'harvested_at'];

    protected static $seedVarieties = [
        'Gema', 'DETAM-2', 'Lokal Grobogan', 'Gepak Kuning', 'Gepak Ijo'
    ];

    public static function getSeedVarieties()
    {
        return self::$seedVarieties;
    }

    public function field()
    {
        return $this->belongsTo(\App\Models\Field::class);
    }

    public function onfarms()
    {
        return $this->hasMany(\App\Models\Onfarm::class);
    }

    public function lastOnfarm()
    {
        return $this->belongsTo(\App\Models\Onfarm::class);
    }

    public function scopeWithLastOnfarm($query)
    {
        $query->addSelect([
            'last_onfarm_id' => \App\Models\Onfarm::select('id')
                ->whereColumn('planting_id', 'plantings.id')
                ->orderByDesc('timestamp')
                ->limit(1)
        ])->with('lastOnfarm');
    }
}
