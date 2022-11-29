<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LosantDevices extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'name' => $this->name,
            'device_id' => $this->deviceId,
            'payload_attributes' => LosantDeviceAttributes::collection($this->resource->attributes)
        ];
    }
}
