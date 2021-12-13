<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserFeatureTest extends TestCase
{
    use RefreshDatabase;

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
}
