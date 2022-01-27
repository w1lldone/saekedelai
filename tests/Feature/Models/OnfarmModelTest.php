<?php

namespace Tests\Feature\Models;

use App\Models\Onfarm;
use App\Models\Planting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class OnfarmModelTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_be_created_using_factory()
    {
        $onfarm = Onfarm::factory()->create();

        $this->assertDatabaseHas('onfarms', [
            'id' => $onfarm->id
        ]);
    }

    /** @test */
    public function it_belongs_to_a_planting()
    {
        $onfarm = Onfarm::factory()->create();

        $this->assertInstanceOf(Planting::class, $onfarm->planting);
    }

    /** @test */
    public function it_removes_media_on_delete()
    {
        /** @var Onfarm */
        $onfarm = Onfarm::factory()->create();
        $file = UploadedFile::fake()->image('image');

        $media = $onfarm->addMedia($file)->toMediaCollection();

        $onfarm->delete();

        $this->assertDeleted($media);
    }
}
