<?php

namespace Tests\Feature;

use App\Reply;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ParticipateInForumTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testAnAuthenticatedUserCanParticipateInForumThreads()
    {
        $this->signIn();

        $thread = create('App\Thread');

        $reply = make('App\Reply');
        $this->post($thread->path() . '/replies', $reply->toArray());

        $this->get($thread->path());
        $this->assertDatabaseHas('replies', ['body' => $reply->body]);
    }

    public function testUnAuthorizedUsersCannotDeleteReplies()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');
        $reply = create('App\Reply');

        $this->delete('/replies/' . $reply->id);
    }

    public function testAnAutenticatedUserCanDeleteItsReplies()
    {
        $this->signIn();

        $reply = create('App\Reply', ['user_id' => auth()->id()]);

        $this->delete('/replies/' . $reply->id);

        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);
    }

    public function testAnAutorizedUserCanUpdateItsReplies()
    {
        $this->signIn();

        $reply = create('App\Reply', ['user_id' => auth()->id()]);

        $this->patch('/replies/' . $reply->id, ['body' => 'hej']);

        $resultReply = Reply::find($reply->id);
        $this->assertEquals('hej', $resultReply->body);
    }

    public function testUnAuthorizedUsersCannotEditReplies()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');
        $reply = create('App\Reply');

        $this->patch('/replies/' . $reply->id, ['body' => 'hej']);
    }

    public function testAuthorizedUsersCannotEditOthersReplies()
    {
        $this->expectException('Illuminate\Auth\Access\AuthorizationException');

        $this->signIn();

        $reply = create('App\Reply');

        $this->patch('/replies/' . $reply->id, ['body' => 'hej']);
    }
}
