<?php

namespace Tests\Feature\Models;

use App\Models\Packing;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PackingModelTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_be_created_using_factory()
    {
        $packing = Packing::factory()->create();

        $this->assertDatabaseHas('packings', [
            'id' => $packing->id
        ]);
    }

    /** @test */
    public function it_belongs_to_a_planting()
    {
        $packing = Packing::factory()->create();

        $this->assertInstanceOf(\App\Models\Planting::class, $packing->planting);
    }
}
