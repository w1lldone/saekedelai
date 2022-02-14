<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Onfarm extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $guarded = ['id'];

    protected $dates = ['started_at', 'finished_at'];

    protected $casts = [
        'costs' => 'json'
    ];

    protected static $categories = [
        'penanaman', 'pemupukan', 'pemeliharaan'
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::saving(function ($onfarm)
        {
            $onfarm->total_cost = collect($onfarm->costs)->sum('value');
        });

        static::deleted(function ($onfarm) {
            $onfarm->media()->delete();
        });
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('galery');
    }

    public static function getCategories()
    {
        return self::$categories;
    }

    public function planting()
    {
        return $this->belongsTo(\App\Models\Planting::class);
    }
}
