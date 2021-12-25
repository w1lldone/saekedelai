<?php

namespace Tests\Feature;

use App\Models\Address;
use App\Models\Organization;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrganizationFeatureTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_create_an_organization()
    {
        $this->login();
        $data = Organization::factory()->make()->toArray();
        $address = Address::factory()->make()->only('province', 'city',);

        $response = $this->postJson(route('organization.store'), array_merge($data, $address));

        $response->assertRedirect();
        $this->assertDatabaseHas(Organization::class, $data);
        $this->assertDatabaseHas(Address::class, array_merge([
            'addressable_type' => Organization::class
        ], $address));
    }

    /** @test */
    public function user_cannot_create_organization_without_address()
    {
        $this->login();
        $data = Organization::factory()->make()->toArray();

        $response = $this->postJson(route('organization.store'), $data);

        $response->assertJsonValidationErrors(['province', 'city']);
    }

    /** @test */
    public function user_can_update_organization()
    {
        $this->login();
        $organization = Organization::factory()->create();
        $data = Organization::factory()->make()->toArray();

        $response = $this->putJson(route('organization.update', $organization), $data);

        $response->assertRedirect();
        $this->assertDatabaseHas(Organization::class, array_merge([
            'id' => $organization->id
        ],$data));
    }

    /** @test */
    public function user_can_delete_organization()
    {
        $organization = Organization::factory()->create();
        $this->login();

        $reponse = $this->deleteJson(route('organization.destroy', $organization));

        $reponse->assertRedirect();
        $this->assertDeleted($organization);
    }
}
