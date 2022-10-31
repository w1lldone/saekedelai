<?php

namespace App\Integrations\Losant;

use GuzzleHttp\Client;

class LosantClient
{
    protected $client;

    public function __construct() {
        $appId = config("services.losant.app_id");
        $client = new Client([
            'base_uri' => "https://api.losant.com/applications/{$appId}/",
            'headers' => [
                'Authorization' => "Bearer ".config("services.losant.api_token"),
            ]
        ]);

        $this->client = $client;
    }

    public function getClient()
    {
        return $this->client;
    }
}
