<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subdistrict extends Model
{
    public $timestamps = false;

    use HasFactory;

    public function district()
    {
        return $this->belongsTo('App\Models\District');
    }
}
