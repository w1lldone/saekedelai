<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $appends = ['formatted_address'];

    public function addressable()
    {
        return $this->morphTo();
    }

    public function getFormattedAddressAttribute()
    {
        if ($this->province == null) {
            return null;
        }

        return "{$this->province}, {$this->city}, {$this->district}, {$this->subdistrict}, {$this->address}";
    }
}
