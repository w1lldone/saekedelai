<?php

namespace Tests\Feature\Models;

use App\Models\Field;
use App\Models\Onfarm;
use App\Models\Planting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PlantingModelTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_be_created_using_factory()
    {
        $planting = Planting::factory()->create();

        $this->assertDatabaseHas('plantings', [
            'id' => $planting->id
        ]);
    }

    /** @test */
    public function it_belongs_to_a_field()
    {
        $planting = Planting::factory()->create();

        $this->assertInstanceOf(Field::class, $planting->field);
    }

    /** @test */
    public function it_has_many_onfarms()
    {
        $planting = Planting::factory()->has(Onfarm::factory(2))->create();

        $onfarm = $planting->onfarms->first();

        $this->assertInstanceOf(Onfarm::class, $onfarm);
    }
}
