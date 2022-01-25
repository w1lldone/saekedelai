<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Onfarm extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $dates = ['timestamp'];

    public function planting()
    {
        return $this->belongsTo(\App\Models\Planting::class);
    }
}
