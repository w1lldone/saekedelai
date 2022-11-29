<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'payload_attributes' => 'json'
    ];

    public static $integrations = [
        'losant' => [
            'device' => \App\Integrations\Losant\LosantDevices::class,
            'data' => \App\Integrations\Losant\LosantData::class,
        ]
    ];

    public function address()
    {
        return $this->morphOne(\App\Models\Address::class, 'addressable');
    }

    public static function availableIntegrations()
    {
        return array_keys(self::$integrations);
    }
}
