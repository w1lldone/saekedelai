<?php

namespace Tests\Feature;

use App\Models\Address;
use App\Models\Province;
use App\Models\Subdistrict;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AddressFeatureTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_be_created_using_factory()
    {
        $subdisctrict = Subdistrict::factory()->create();

        $address = User::factory()->create()->address()->create([
            'province' => $subdisctrict->district->city->province->name,
            'city' => $subdisctrict->district->city->name,
            'district' => $subdisctrict->district->name,
            'subdistrict' => $subdisctrict->name
        ]);

        $this->assertDatabaseHas('addresses', [
            'province' => $subdisctrict->district->city->province->name,
            'city' => $subdisctrict->district->city->name,
            'district' => $subdisctrict->district->name,
            'subdistrict' => $subdisctrict->name
        ]);
    }

    /** @test */
    public function user_has_one_address()
    {
        $subdisctrict = Subdistrict::factory()->create();
        $user = User::factory()->create();
        $address = $user->address()->create([
            'province' => $subdisctrict->district->city->province->name,
            'city' => $subdisctrict->district->city->name,
            'district' => $subdisctrict->district->name,
            'subdistrict' => $subdisctrict->name
        ]);

        $this->assertInstanceOf(Address::class, $user->address);
    }

    /** @test */
    public function user_can_update_address()
    {
        $this->login();

        $address = Address::factory()->make()->only('province', 'city', 'district', 'subdistrict', 'address');
        $this->put(route('user.address.update', $this->user), $address);

        $this->assertDatabaseHas('addresses', array_merge([
            'addressable_type' => User::class,
            'addressable_id' => $this->user->id,
        ], $address));
    }
}
