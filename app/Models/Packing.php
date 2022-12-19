<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Packing extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected static $grades = [
        'a', 'b', 'reject'
    ];

    public static function getGrades()
    {
        return self::$grades;
    }

    public function planting()
    {
        return $this->belongsTo(\App\Models\Planting::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function organization()
    {
        return $this->belongsTo(\App\Models\Organization::class);
    }
}
