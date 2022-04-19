<?php

namespace Tests\Feature;

use App\Models\Planting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PlantingHarvestFeatureTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_store_harvest()
    {
        $this->login();
        $planting = Planting::factory()->create();

        $data = [
            'harvested_at' => now(),
            'yield' => 300000,
            'released_quantity' => 260000,
            'ureleased_quantity' => 20000,
            'water_content' => 12,
            'dirts' => 0.5,
            'discolors' => 1.1,
            'splits' => 1.2,
            'damaged' => 0.5,
            'fungal' => 0.3,
            'bugs' => 0,
            'harvest_costs' => [
                [
                    'description' => 'test',
                    'value' => 130000,
                ]
            ],
        ];

        $response = $this->postJson(route('planting.harvest.store', $planting), $data);

        $response->assertRedirect();
        $this->assertDatabaseHas('qualities', [
            'category' => 'harvest',
            'planting_id' => $planting->id
        ]);
    }
}
