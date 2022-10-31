<?php

namespace Tests\Feature\Models;

use App\Models\Address;
use App\Models\Device;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DeviceModelTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_be_created_using_factory()
    {
        $device = Device::factory()->create();

        $this->assertDatabaseHas('devices', [
            'id' => $device->id
        ]);
    }

    /** @test */
    public function it_has_address()
    {
        $device = Device::factory()->create();
        $device->address()->create(Address::factory()->make()->only(['province', 'city', 'district', 'subdistrict', 'address']));

        $this->assertInstanceOf(Address::class, $device->address);
    }
}
