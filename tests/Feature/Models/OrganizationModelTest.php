<?php

namespace Tests\Feature\Models;

use App\Models\Organization;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrganizationModelTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_be_created_using_factory()
    {
        $organization = Organization::factory()->create();

        $this->assertInstanceOf(Organization::class, $organization);
    }

    /** @test */
    public function it_belongs_to_many_users()
    {
        $user = User::factory()->create();
        $organiztion = Organization::factory()->create();

        $organiztion->users()->attach($user);

        $this->assertDatabaseHas('organization_user', [
            'organization_id' => $organiztion->id,
            'user_id' => $user->id
        ]);
        $this->assertCount(1, $organiztion->users);
    }
}
