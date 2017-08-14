<?php

namespace Tests\Feature;

use App\Thread;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ManageThreadsTest extends TestCase
{

    use DatabaseMigrations;


    public function testGuestsMayNotCreateThreads()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');

        $thread = make('App\Thread');
        $this->post('/threads', $thread->toArray());
    }

    public function testUserCannotSeeCreatePageIfLoggedOut()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');

        $this->get('/threads/create');
    }

    public function testAnAuthenticatedUserCanCreateForumThreads()
    {
        $this->signIn();

        $thread = make('App\Thread');
        $response = $this->post('/threads', $thread->toArray());

        $this->get($response->headers->get('Location'))->assertSee($thread->title)->assertSee($thread->body);
    }

    public function testAThreadBelongsToAChannel()
    {
        $thread = create('App\Thread');

        $this->assertInstanceOf('App\Channel', $thread->channel);
    }

    public function testAThreadRequiresATitle()
    {
        $this->expectException('Illuminate\Validation\ValidationException');

        $this->signIn();

        $thread = make('App\Thread', ['title' => null]);

        $this->post('/threads', $thread->toArray())
            ->assertSessionHasErrors('title');
    }

    public function testAUserCanDeleteItsOwnThread()
    {
        $user = create('App\User');

        $this->signIn($user);

        $thread = create('App\Thread', ['user_id' => $user->id]);
        $reply = create('App\Reply', ['thread_id' => $thread->id]);

        $this->delete($thread->path());

        $this->assertDatabaseMissing('threads', ['id' => $thread->id]);
        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);

    }

    public function testAUserCanNotDeleteOthersThreads()
    {
        $user = create('App\User');
        $user2 = create('App\User');

        $this->signIn($user);

        $thread = create('App\Thread', ['user_id' => $user2->id]);

        $this->delete($thread->path());

        $this->assertDatabaseHas('threads', ['id' => $thread->id]);

    }
}
