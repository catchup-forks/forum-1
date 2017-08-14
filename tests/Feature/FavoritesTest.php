<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class FavoritesTest extends TestCase
{
    use DatabaseMigrations;

    public function testGuestsCanNotFavoriteAnything()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');
        $this->post('/replies/1/favorite');
    }

    public function testAnAuthenticatedUserCanFavoriteReplies()
    {
        $this->signIn();

        $reply = create('App\Reply');

        $this->post('/replies/' . $reply->id . '/favorite');

        $this->assertCount(1, $reply->favorites);
    }

    public function testAnAuthenticatedUserCanOnlyFavoriteRepliesOnce()
    {
        $this->signIn();

        $reply = create('App\Reply');

        try {
            $this->post('/replies/' . $reply->id . '/favorite');
            $this->post('/replies/' . $reply->id . '/favorite');
        } catch (\Exception $e) {
            $this->fail('Did not expect the same record twice');
        }

        $this->assertCount(1, $reply->favorites);
    }
}
