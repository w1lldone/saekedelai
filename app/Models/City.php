<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    public $timestamps = false;

    use HasFactory;

    public function districs()
    {
        return $this->hasMany('App\Models\District');
    }

    public function province()
    {
        return $this->belongsTo('App\Models\Province');
    }
}
