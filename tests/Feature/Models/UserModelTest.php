<?php

namespace Tests\Feature\Models;

use Tests\TestCase;
use App\Models\User;
use App\Models\Organization;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserModelTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function it_can_be_created_using_factory()
    {
        $user = User::factory()->create();

        $this->assertDatabaseHas(User::class, [
            'id' => $user->id
        ]);
    }

    /** @test */
    public function it_automatically_create_an_address()
    {
        $user = User::factory()->create();

        $this->assertDatabaseHas('addresses', [
            'addressable_type' => User::class,
            'addressable_id' => $user->id
        ]);
    }

    /** @test */
    public function it_can_check_roles()
    {
        $role = 'viewer';
        $otherRole = 'enumerator';
        $user = User::factory()->create(['role' => $role]);

        $this->assertTrue($user->hasRole([$role]));
        $this->assertFalse($user->hasRole([$otherRole]));
    }

    /** @test */
    public function it_belongs_to_many_organizations()
    {
        $user = User::factory()->create();
        $organiztion = Organization::factory()->create();

        $user->organizations()->attach($organiztion);

        $this->assertDatabaseHas('organization_user', [
            'organization_id' => $organiztion->id,
            'user_id' => $user->id
        ]);
        $this->assertCount(1, $user->organizations);
    }

    /** @test */
    public function it_can_generate_fake_email()
    {
        $user = new User;
        $user->name = "Dyas Selvi";
        $user->phone_number = "08123224999";

        $this->assertEquals("dyas_selvi999@saekedelai.com", $user->generateFakeEmail());
    }

    /** @test */
    public function it_detaches_organizations_after_deleted()
    {
        $user = User::factory()->create();
        $organization = Organization::factory()->create();

        $user->organizations()->attach($organization);
        $user->delete();

        $this->assertDatabaseMissing('organization_user', [
            'user_id' => $user->id,
            'organization_id' => $organization->id
        ]);
    }
}
