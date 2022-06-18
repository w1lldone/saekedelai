<?php

namespace App\Integrations\Losant;

use App\Integrations\Losant\LosantClient;

class LosantData
{
    public $client;

    protected static $aggregations = [
        "FIRST",
        "LAST",
        "COUNT",
        "MAX",
        "MIN",
        "MEDIAN",
        "MEAN",
        "SUM",
        "STD_DEV"
    ];

    public function __construct(LosantClient $client = null)
    {
        $this->client = $client->getClient();
    }

    public static function getAggregations()
    {
        return self::$aggregations;
    }

    public function timeSeriesQuery($query = [])
    {
        $json = [
            'start' => now()->subDay()->timestamp * 1000,
            'end' => 0,
            'resolution' => 1000 * 60 * 60,
            'aggregation' => "MEAN",
            "attributes" => [
                "humidity"
            ],
            'deviceIds' => [
                '629f745f2d35cffbb2823416'
            ]
        ];

        $response = $this->client->post('data/time-series-query', [
            'json' => $query
        ]);

        return json_decode($response->getBody()->getContents(), false);
    }

    public function lastValueQuery($json = [])
    {
        $response = $this->client->post('data/last-value-query', [
            'json' => $json
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }
}
