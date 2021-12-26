<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserFeatureTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function admin_can_see_user_list()
    {
        $this->login();

        $response = $this->get(route('user.index'));

        $response->assertOk();
    }

    /** @test */
    public function member_can_not_see_users_list()
    {
        $member = User::factory()->create();
        $this->login($member);

        $response = $this->get(route('user.index'));

        $response->assertForbidden();
    }

    /** @test */
    public function enumerator_can_see_users_list()
    {
        $enumerator = User::factory()->create(['role' => 'enumerator']);
        $this->login($enumerator);

        $response = $this->get(route('user.index'));

        $response->assertOk();
    }

    /** @test */
    public function admin_can_update_user()
    {
        $this->login();
        $user = User::factory()->create();
        $data = [
            'name' => 'new name'
        ];

        $response = $this->put(route('user.update', $user), $data);

        $response->assertRedirect();
        $data['id'] = $user->id;
        $this->assertDatabaseHas('users', $data);
    }

    /** @test */
    public function enumerator_can_update_role()
    {
        $this->login(
            User::factory()->create(['role' => 'enumerator'])
        );
        $user = User::factory()->create(['role' => null]);

        $role = $this->faker->randomElement(User::getRoles());
        $response = $this->putJson(route('user.role.update', $user), [
            'role' => $role
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas(User::class, [
            'id' => $user->id,
            'role' => $role
        ]);
    }

    /** @test */
    public function user_can_only_select_registered_role()
    {
        $this->login();
        $user = User::factory()->create();

        $response = $this->putJson(route('user.role.update', $user), [
            'role' => $this->faker->word
        ]);

        $response->assertJsonValidationErrors('role');
    }
}
