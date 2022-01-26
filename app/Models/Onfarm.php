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

    protected $dates = ['timestamp'];

    protected static $categories = [
        'penanaman', 'pemupukan', 'pemeliharaan'
    ];

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
