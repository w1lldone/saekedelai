<?php

namespace App\Integrations\Losant;

class LosantDevices
{
    public $client;

    public function __construct(LosantClient $client = null) {
        $this->client = $client->getClient();
    }

    public function devices($query = [])
    {
        $response = $this->client->get('devices', [
            'query' => $query
        ]);

        return json_decode($response->getBody()->getContents(), false);
    }

    public function deviceDetail($id)
    {
        $response = $this->client->get('devices/'.$id);

        return json_decode($response->getBody()->getContents(), false);
    }
}
