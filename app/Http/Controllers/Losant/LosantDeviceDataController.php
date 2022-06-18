<?php

namespace App\Http\Controllers\Losant;

use App\Http\Controllers\Controller;
use App\Http\Resources\LosantDataResource;
use App\Integrations\Losant\LosantData;
use App\Models\Device;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class LosantDeviceDataController extends Controller
{
    public $client;

    public function __construct(LosantData $client) {
        $this->client = $client;
    }

    public function index(Device $device, Request $request)
    {
        $this->authorize('view', $device);

        $request->validate([
            'start_date' => 'date|nullable',
            'end_date' => 'date|nullable',
            'aggregation' => ['nullable', Rule::in(LosantData::getAggregations())],
            'resolution' => ['integer', 'nullable', Rule::requiredIf($request->filled('aggregation'))],
            'payload_attributes' => ['nullable', 'array'],
            'payload_attributes.*' => ['string']

        ]);

        $data['deviceIds'] = [$device->device_id];
        $data['end'] = 0;

        if ($request->filled('start_date')) {
            $data['start'] = Carbon::parse($request->start_date)->timestamp * 1000;
        }

        if ($request->filled('end_date')) {
            $data['end'] = Carbon::parse($request->end_date)->timestamp * 1000;
        }

        if ($request->filled('payload_attributes')) {
            $data['attributes'] = $request->payload_attributes;
        }

        if ($request->filled('aggregation')) {
            $data['aggregation'] = $request->aggregation;
        }

        if ($request->filled('resolution')) {
            $data['resolution'] = $request->resolution;
        }

        $response = $this->client->timeSeriesQuery($data);

        return LosantDataResource::collection($response->devices->{$device->device_id}->points);
    }
}
