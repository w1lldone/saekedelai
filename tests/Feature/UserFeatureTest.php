<?php

namespace Tests\Feature;

use App\Models\Address;
use App\Models\Organization;
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
        $member = User::factory()->create(['role' => 'member']);
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

    /** @test */
    public function admin_can_create_a_non_email_user()
    {
        $this->login();
        $organization = Organization::factory()->create();
        $data = User::factory()->make()->only(['name', 'phone_number', 'id_number']);

        $response = $this->postJson(route('user.store'), array_merge(
            $data, ['organization_id' => $organization->id, 'member_type' => 'member']
        ));

        $response->assertRedirect();
        $this->assertDatabaseHas('users', $data);
        $this->assertCount(1, $organization->users);
        $this->assertEquals('member', $organization->users->first()->pivot['member_type']);
    }

    /** @test */
    public function admin_can_create_user_with_email()
    {
        $this->login();
        $data = User::factory()->make()->only(['name', 'phone_number', 'id_number', 'email']);

        $response = $this->postJson(route('user.store'), $data);

        $response->assertRedirect();
        $this->assertDatabaseHas('users', $data);
    }

    /** @test */
    public function admin_can_create_user_with_address()
    {
        $this->login();
        $data = User::factory()->make()->only(['name', 'phone_number', 'id_number', 'email']);
        $address = Address::factory()->make()->only(['province', 'city', 'district', 'subdistrict']);
        $data = array_merge($data, $address);

        $response = $this->postJson(route('user.store'), $data);

        $response->assertRedirect();
        $this->assertDatabaseHas('addresses', $address);
    }

    /** @test */
    public function admin_can_filter_user_by_keyword()
    {
        $this->login();
        User::factory(5)->create([
            'name' => 'name'
        ]);
        User::factory(3)->create([
            'name' => 'other'
        ]);

        $response = $this->getJson(route('user.index', [
            'keyword' => 'name'
        ]));

        $response->assertOk()
            ->assertJsonCount(5, 'data');
    }

    /** @test */
    public function it_can_create_user_with_a_role()
    {
        $this->login();
        $data = User::factory()->make()->only(['name', 'phone_number', 'id_number', 'email', 'role']);

        $response = $this->postJson(route('user.store'), $data);

        $response->assertRedirect();
        $this->assertDatabaseHas('users', $data);
    }
}
