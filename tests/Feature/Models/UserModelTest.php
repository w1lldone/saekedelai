<?php

namespace Tests\Feature\Models;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserModelTest extends TestCase
{
    use RefreshDatabase;

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
}
