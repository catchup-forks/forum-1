<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ReadThreadsTest extends TestCase
{

    use DatabaseMigrations;

    protected $thread;

    public function setUp()
    {
        parent::setUp();

        $this->thread = create('App\Thread');
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testAUserCanBrowseAllThreads()
    {
        $response = $this->get('/threads');
        $response->assertSee($this->thread->title);
    }

    public function testAUserCanBrowseASingleThread()
    {
        $response = $this->get('/threads/' . $this->thread->channel->name . '/' . $this->thread->id);
        $response->assertSee($this->thread->body);
    }

    public function testAUserCanReadRepliesToTheThread()
    {
        $reply = create('App\Reply', ['thread_id' => $this->thread->id]);

        $response = $this->get($this->thread->path());
        $response->assertSee($reply->body);
    }

    public function testFilterThreadsAccordingToChannel()
    {
        $channel = create('App\Channel');

        $threadInChannel = create('App\Thread', ['channel_id' => $channel->id]);
        $threadNotInChannel = create('App\Thread');


        $this->get('threads/' . $channel->slug)
            ->assertSee($threadInChannel->title)
            ->assertDontSee($threadNotInChannel->title);
    }

    public function testAUserCanFilterThreadsByUsername()
    {
        $myName = 'Test Testsson';
        $this->signIn($user = create('App\User', ['name' => $myName]));

        $threadMadeByMe = create('App\Thread', ['user_id' => auth()->id()]);
        $threadNotMadeByMe = create('App\Thread');

        $this->get('/threads?by=' . $myName)
            ->assertSee($threadMadeByMe->title)
            ->assertDontSee($threadNotMadeByMe->title);
    }

    public function testSortThreadsOfAllTimeMostPopular()
    {
        $threadWith3Replies = create('App\Thread');
        create('App\Reply', ['thread_id' => $threadWith3Replies->id], 3);

        $threadWith0Replies = $this->thread;

        $threadWith11Replies = create('App\Thread');
        create('App\Reply', ['thread_id' => $threadWith11Replies->id], 11);

        $response = $this->getJson('/threads?popular=1')->json();

        $this->assertEquals([11, 3, 0], array_column($response, 'replies_count'));

    }

}
