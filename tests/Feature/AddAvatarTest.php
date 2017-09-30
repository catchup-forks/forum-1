<?php

namespace Tests\Feature;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AddAvatarTest extends TestCase
{
    use DatabaseMigrations;

    public function testOnlyMembersCanAddAvatars()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');

        $this->json('POST', '/api/upload/avatar')->assertStatus(401);
    }

    public function testAValidAvatarMustBeProvided()
    {
        $this->signIn();

        $this->expectException('Illuminate\Validation\ValidationException');

        $this->json('POST', '/api/upload/avatar', [
            'avatar' => 'not-an-image'
        ])->assertStatus(422);
    }

    public function testAUserCanAddAnAvatarToTheirProfile()
    {
        $this->signIn();

        Storage::fake('public');

        $this->json('POST', '/api/upload/avatar', [
            'avatar' => $file = UploadedFile::fake()->image('avatar.jpg')
        ]);

        $this->assertEquals(asset('avatars/' . $file->hashName()), asset(auth()->user()->avatar_path));

        Storage::disk('public')->assertExists('avatars/' . $file->hashName());
    }
}