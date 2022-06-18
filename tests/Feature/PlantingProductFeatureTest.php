<?php

namespace Tests\Feature;

use App\Models\Planting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PlantingProductFeatureTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_store_product_planting()
    {
        $this->login();
        $planting = Planting::factory()->create();

        $data = [
            'production_date' => now()->toDateTimeString(),
            'expired_date' => now()->addYear()->toDateTimeString(),
            'product_batch' => 'JAP-1000',
            'product_processor' => 'someone',
            'water_content' => 12,
            'dirts' => 0.5,
            'discolors' => 1.1,
            'splits' => 1.2,
            'damaged' => 0.5,
            'fungal' => 0.3,
            'bugs' => 0,
        ];

        $response = $this->postJson(route('planting.product.store', $planting->id), $data);

        $response->assertRedirect();
        $this->assertDatabaseHas('plantings', [
            'id' => $planting->id,
            'production_date' => $data['production_date'],
            'expired_date' => $data['expired_date'],
            'product_batch' => $data['product_batch'],
            'product_processor' => $data['product_processor'],
        ]);
        $this->assertDatabaseHas('qualities', [
            'planting_id' => $planting->id,
            'category' => 'product',
            'water_content' => 12,
            'dirts' => 0.5,
            'discolors' => 1.1,
            'splits' => 1.2,
            'damaged' => 0.5,
            'fungal' => 0.3,
            'bugs' => 0,
        ]);
    }
}
