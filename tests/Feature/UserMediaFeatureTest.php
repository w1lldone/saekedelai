<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserMediaFeatureTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_upload_media()
    {
        $this->login();
        Storage::fake('public');
        /** @var User */
        $user = User::factory()->create();
        $file = UploadedFile::fake()->image('map.svg');

        $response = $this->postJson(route('user.media.store', $user), [
            'media' => $file,
            'collection' => 'profile_picture',
        ]);

        $response->assertRedirect();
        $this->assertNotEmpty($user->getMedia('profile_picture')->first());
    }

    /** @test */
    public function user_can_retrive_a_media()
    {
        $this->login();
        Storage::fake('public');
        /** @var User */
        $user = User::factory()->create();
        $file = UploadedFile::fake()->image('map.jpg');
        $media = $user->addMedia($file)->toMediaCollection('profile_picture');

        $response = $this->get(route('user.media.show', [$user, $media]));

        $response->assertOk()->assertHeader('content-type', "image/jpeg");
    }

    /** @test */
    public function user_can_delete_a_media()
    {
        $this->login();
        Storage::fake('public');
        /** @var User */
        $user = User::factory()->create();
        $file = UploadedFile::fake()->image('map.jpg');
        $media = $user->addMedia($file)->toMediaCollection('profile_picture');

        $response = $this->deleteJson(route('user.media.show', [$user, $media]));

        $response->assertRedirect();
        $this->assertDeleted($media);
    }
}
