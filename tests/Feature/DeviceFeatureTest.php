<?php

namespace Tests\Feature;

use App\Models\Address;
use App\Models\Device;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DeviceFeatureTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_create_a_device()
    {
        $this->login();
        $device = Device::factory()->make()->toArray();
        $address = Address::factory()->make()->toArray();
        $attributes = [
            ['name' => 'uv', 'type' => 'number']
        ];
        $data = array_merge($device, $address);
        $data['payload_attributes'] = $attributes;

        $response = $this->postJson(route('device.store'), $data);

        $response->assertRedirect();
        $device['payload_attributes'] = json_encode($attributes);
        $this->assertDatabaseHas('devices', $device);
    }
}
