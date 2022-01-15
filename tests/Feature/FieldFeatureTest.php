<?php

namespace Tests\Feature;

use App\Models\Address;
use App\Models\Field;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FieldFeatureTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_store_field()
    {
        $this->login();
        $field = Field::factory()->make()->toArray();
        $address = Address::factory()->make()->only(['province', 'city', 'district', 'subdistrict']);
        $data = array_merge($field, $address);

        $response = $this->postJson(route('field.store'), $data);

        $this->assertDatabaseHas('fields', $field);
        $this->assertDatabaseHas('addresses', $address);
    }

    /** @test */
    public function user_can_update_field()
    {
        $this->login();
        $field = Field::factory()->has(Address::factory())->create();
        $newField = Field::factory()->make()->only(['description', 'area', 'longitude', 'latitude']);
        $address = Address::factory()->make()->only(['province', 'city', 'district', 'subdistrict']);

        $data = array_merge($newField, $address);
        $response = $this->putJson(route('field.update', $field), $data);

        $response->assertRedirect();
        $newField['id'] = $field->id;
        $address['addressable_id'] = $field->id;
        $address['addressable_type'] = Field::class;
        $this->assertDatabaseHas('fields', $newField);
        $this->assertDatabaseHas('addresses', $address);
    }
}
