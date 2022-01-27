<?php

namespace Tests\Feature\Models;

use App\Models\Address;
use App\Models\Field;
use App\Models\Onfarm;
use App\Models\Planting;
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

    /** @test */
    public function it_removes_plantings_on_deleted()
    {
        $planting = Planting::factory()->create();

        $planting->field->delete();

        $this->assertDeleted($planting);
    }

    /** @test */
    public function it_removes_address_on_deleted()
    {
        $field = Field::factory()->create();
        $address = $field->address()->create(
            Address::factory()->make()->toArray()
        );

        $field->delete();

        $this->assertDeleted($address);
    }
}
