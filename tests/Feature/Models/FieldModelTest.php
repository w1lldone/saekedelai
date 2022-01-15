<?php

namespace Tests\Feature\Models;

use App\Models\Address;
use App\Models\Field;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FieldModelTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_be_created_using_factory()
    {
        $field = Field::factory()->create();

        $this->assertDatabaseHas(Field::class, [
            'id' => $field->id
        ]);
    }

    /** @test */
    public function it_belongs_to_a_user()
    {
        $field = Field::factory()->create();

        $this->assertInstanceOf(User::class, $field->user);
    }

    /** @test */
    public function it_has_address()
    {
        $field = Field::factory()->has(Address::factory())->create();

        $this->assertInstanceOf(Address::class, $field->address);
    }

}
