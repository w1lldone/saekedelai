<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    public $timestamps = false;

    use HasFactory;

    public function cities()
    {
        return $this->hasMany('App\Models\City');
    }
}
