<?php

namespace Tests\Feature\Models;

use App\Models\Address;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AddressModelTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_be_created_using_factory()
    {
        $address = Address::factory()->create();

        $this->assertDatabaseHas(Address::class, [
            'id' => $address->id
        ]);
    }

    /** @test */
    public function it_can_format_address()
    {
        $address = Address::factory()->create();

        $this->assertEquals(
            "{$address->province}, {$address->city}, {$address->district}, {$address->subdistrict}, {$address->address}",
            $address->formatted_address
        );
    }

    /** @test */
    public function it_appends_formatted_address()
    {
        $address = Address::factory()->create();

        $this->assertArrayHasKey('formatted_address', $address->toArray());
    }

}
