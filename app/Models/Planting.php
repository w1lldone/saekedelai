<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Planting extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $dates = ['started_at', 'harvested_at', 'received_at', 'production_date', 'expired_date'];

    protected $casts = [
        'harvest_costs' => 'json'
    ];

    protected static $seedVarieties = [
        'Gema', 'DETAM-2', 'Lokal Grobogan', 'Gepak Kuning', 'Gepak Ijo'
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::deleted(function ($planting) {
            $planting->onfarms()->delete();
            $planting->packings()->delete();
            $planting->qualities()->delete();
        });

        static::saving(function ($planting)
        {
            $planting->total_harvest_cost = collect($planting->harvest_costs)->sum('value');
        });
    }

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

    public function qualities()
    {
        return $this->hasMany(\App\Models\Quality::class);
    }

    public function packings()
    {
        return $this->hasMany(\App\Models\Packing::class);
    }

    public function lastOnfarm()
    {
        return $this->belongsTo(\App\Models\Onfarm::class);
    }

    public function getHarvestQualityAttribute()
    {
        return $this->qualities->where('category', 'harvest')->first();
    }

    public function getProductQualityAttribute()
    {
        return $this->qualities->where('category', 'product')->first();
    }

    public function scopeWithLastOnfarm($query)
    {
        $query->addSelect([
            'last_onfarm_id' => \App\Models\Onfarm::select('id')
                ->whereColumn('planting_id', 'plantings.id')
                ->orderByDesc('started_at')
                ->limit(1)
        ])->with('lastOnfarm');
    }
}
