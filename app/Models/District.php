<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    public $timestamps = false;

    use HasFactory;

    public function subdistricts()
    {
        return $this->hasMany('App\Models\Subdistricts');
    }

    public function city()
    {
        return $this->belongsTo('App\Models\City');
    }
}
