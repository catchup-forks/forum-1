<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\Redis;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ThreadTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * A basic test example.
     *
     * @return void
     */

    protected $thread;

    public function setUp(){
        parent::setUp();

        $this->thread = create('App\Thread');
    }

    public function testCreator()
    {
        $this->assertInstanceOf('App\User', $this->thread->creator);
    }

    public function testPath(){
        $thread = create('App\Thread');

        $this->assertEquals('/threads/' . $thread->channel->slug . '/' . $thread->slug, $thread->path());
    }

    public function testCanAddReply(){
        $this->thread->addReply([
            'body' => 'Test',
            'user_id' => 1,
        ]);

        $this->assertCount(1, $this->thread->replies);
    }

    public function testAThreadCanBeSubscribedTo()
    {
        $thread = create('App\Thread');

        $this->signIn();

        $thread->subscribe();

        $this->assertEquals(1, $thread->subscriptions()->where('user_id', auth()->id())->count() );
    }

    public function testAThreadCanBeUnsubscribedFrom()
    {
        $thread = create('App\Thread');

        $this->signIn();

        $thread->subscribe();
        $thread->unsubscribe();
        $this->assertEquals(0, $thread->subscriptions()->where('user_id', auth()->id())->count() );

        $user = create('App\User');
        $thread->subscribe($user->id);
        $thread->unsubscribe($user->id);

        $this->assertEquals(0, $thread->subscriptions()->where('user_id', $user->id)->count() );
    }

    public function testAThreadRecordEachVisit()
    {
        $thread = create('App\Thread');
        Redis::del('thread.' . $thread->id . '.visits');

        $this->assertSame(0, $thread->visits);

        $thread->recordVisit();

        $this->assertEquals(1, $thread->visits);

        $thread->recordVisit();

        $this->assertEquals(2, $thread->visits);

    }
}
