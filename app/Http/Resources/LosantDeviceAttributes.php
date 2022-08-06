<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LosantDeviceAttributes extends JsonResource
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
            'type' => $this->dataType,
            'unit' => optional($this)->unit,
            'conversion' => optional($this)->conversion
        ];
    }
}
