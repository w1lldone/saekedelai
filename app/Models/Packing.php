<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Packing extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function planting()
    {
        return $this->belongsTo(\App\Models\Planting::class);
    }
}
