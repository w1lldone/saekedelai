<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Field;
use App\Models\Planting;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FieldPlantingFeatureTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function user_can_store_a_planting()
    {
        $this->login();
        $field = Field::factory()->create();
        $data = Planting::factory()->make()->only('started_at', 'seed_variety', 'seed_quantity');

        $response = $this->postJson(route('field.planting.store', $field), $data);

        $response->assertRedirect();
        $data['field_id'] = $field->id;
        $this->assertDatabaseHas('plantings', $data);
    }

    /** @test */
    public function user_can_update_planting()
    {
        $this->login();
        $planting = Planting::factory()->create();
        $data = Planting::factory()->make()->only('started_at', 'seed_variety', 'seed_quantity');

        $response = $this->putJson(route('field.planting.update', [$planting->field_id, $planting->id]), $data);

        $response->assertRedirect();
        $data['id'] = $planting->id;
        $this->assertDatabaseHas('plantings', $data);
    }
}
