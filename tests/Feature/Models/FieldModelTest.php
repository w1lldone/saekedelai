<?php

namespace Tests\Feature\Models;

use Tests\TestCase;
use App\Models\User;
use App\Models\Field;
use App\Models\Onfarm;
use App\Models\Address;
use App\Models\Planting;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

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

    /** @test */
    public function it_can_be_grouped_using_address()
    {
        $addressOne = Address::factory()->make()->only(['province', 'city', 'district', 'subdistrict']);
        $addressTwo = Address::factory()->make()->only(['province', 'city', 'district', 'subdistrict']);
        $addressThree = Address::factory()->make()->only(['province', 'city', 'district', 'subdistrict']);
        Field::factory(5)->has(Planting::factory(3)->harvested())->create()->each(function ($field) use ($addressOne)
        {
            $field->address()->create($addressOne);
        });

        Field::factory(5)->has(Planting::factory(3)->harvested())->create()->each(function ($field) use ($addressTwo) {
            $field->address()->create($addressTwo);
        });

        Field::factory(5)->has(Planting::factory(3)->harvested())->create()->each(function ($field) use ($addressThree) {
            $field->address()->create($addressThree);
        });

        $plantings = Planting::leftJoin('addresses', function (JoinClause $join)
        {
            $join->where('addressable_type', '=', 'App\Models\Field')->on('addressable_id', '=', 'plantings.field_id');
        })
        ->select([
            'province',
            'city',
            'district',
            DB::raw('SUM(yield) as total_yield')
        ])->groupBy('province', 'city', 'district')->get();

        $this->assertCount(3, $plantings);
    }
}
