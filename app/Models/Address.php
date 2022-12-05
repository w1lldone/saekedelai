<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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
        $collection = collect($this->only('province', 'city', 'district', 'subdistrict', 'address'))->filter(function ($item)
        {
            return $item != null;
        });

        return $collection->join(", ");
    }
}
