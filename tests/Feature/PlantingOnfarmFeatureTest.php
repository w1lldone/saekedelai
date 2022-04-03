<?php

namespace Tests\Feature;

use App\Models\Onfarm;
use App\Models\Planting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PlantingOnfarmFeatureTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_store_an_onfarm()
    {
        $this->login();
        $planting = Planting::factory()->create();

        $data = Onfarm::factory()->make(['planting_id' => $planting->id])->toArray();
        $data['started_at'] = now()->toDateTimeString();
        $data['finished_at'] = now()->addWeek()->toDateTimeString();
        $response = $this->postJson(route('planting.onfarm.store', $planting), $data);

        $response->assertRedirect();
        $data['costs'] = json_encode($data['costs']);
        $this->assertDatabaseHas('onfarms', $data);
    }

    /** @test */
    public function it_automatically_sums_total_costs()
    {
        $this->login();
        $planting = Planting::factory()->create();

        $data = Onfarm::factory()->make(['planting_id' => $planting->id])->toArray();
        $response = $this->postJson(route('planting.onfarm.store', $planting), $data);

        $totalCost = collect($data['costs'])->sum('value');
        $this->assertDatabaseHas('onfarms', [
            'name' => $data['name'],
            'total_cost' => $totalCost
        ]);
    }
}
