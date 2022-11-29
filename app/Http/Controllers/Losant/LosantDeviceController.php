<?php

namespace App\Http\Controllers\Losant;

use App\Models\Device;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\LosantDevices as ResourcesLosantDevices;
use App\Integrations\Losant\LosantDevices;

class LosantDeviceController extends Controller
{
    public $device;

    public function __construct(LosantDevices $device) {
        $this->device = $device;
    }

    public function index(Request $request)
    {
        $params = ['query' => null];

        if ($request->exclude_registered == true) {
            $ids = Device::where('integration', 'losant')->pluck('device_id')->toArray();
            $params['query']['id'] = ['$nin' => $ids];
        }

        if ($params['query']) {
            $params['query'] = json_encode($params['query']);
        }

        $response = $this->device->devices($params);

        return ResourcesLosantDevices::collection($response->items);
    }

    public function show($device)
    {
        $reponse = $this->device->deviceDetail($device);

        return new ResourcesLosantDevices($reponse);
    }
}
