<?php

namespace Tests\Feature\Models;

use Tests\TestCase;
use App\Models\Field;
use App\Models\Packing;
use App\Models\Planting;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;

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

    /** @test */
    public function it_can_be_related_to_user()
    {
        Packing::factory(5)->create();
        $expected = Packing::factory()->create();

        $packing = Packing::leftJoin('plantings', function ($join) {
            $join->on('plantings.id', 'packings.planting_id');
        })->select([
            'user_id' => Field::select('user_id')->whereColumn('fields.id', 'field_id')->limit(1),
            DB::raw('SUM(initial_quantity) * SUM(bag_size) as total_quantity'),
        ])->groupBy('user_id')->with('user:id,name')->find($expected->id);

        $this->assertEquals($expected->planting->field->user->name, $packing->user->name);
    }
}
