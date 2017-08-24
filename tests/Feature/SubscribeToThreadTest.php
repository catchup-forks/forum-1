<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SubscribeToThreadTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testAUserCanSubscribeToAThread()
    {
        $this->signIn();

        $thread = create('App\Thread');

        $this->post($thread->path() . '/subscriptions');

        $this->assertEquals(1, $thread->subscriptions()->count());
    }

    public function testAUserCanUnsubscribeFromAThread()
    {
        $this->signIn();

        $thread = create('App\Thread');
        $thread->subscribe();

        $this->delete($thread->path() . '/subscriptions');

        $this->assertEquals(0, $thread->subscriptions()->count());
    }

    public function testTheThreadKnowIfTheUserIsSubscrubedToIt()
    {
        $this->signIn();

        $thread = create('App\Thread');

        $this->assertFalse($thread->isSubscribedTo);

        $thread->subscribe();

        $this->assertTrue($thread->isSubscribedTo);

    }
}
