<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class NotificationTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();

        $this->signIn();
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testANotificationIsPreparedWhenASubscribedThreadGetsANewReplyThatIsNotCreatedByCurrentUser()
    {
        $thread = create('App\Thread');

        $thread->subscribe();

        $this->assertCount(0, auth()->user()->notifications);

        $thread->addReply([
            'user_id' => auth()->id(),
            'body' => 'Reply here',
        ]);

        $this->assertCount(0, auth()->user()->fresh()->notifications);

    }

    public function testANotificationIsPreparedWhenASubscribedThreadGetsANewReplyByAnotherUser()
    {
        $thread = create('App\Thread');

        $thread->subscribe();

        $this->assertCount(0, auth()->user()->notifications);

        $thread->addReply([
            'user_id' => create('App\User')->id,
            'body' => 'Reply here',
        ]);

        $this->assertCount(1, auth()->user()->fresh()->notifications);
    }

    public function testAUserCanFetchItsUnreadNotifications()
    {
        $thread = create('App\Thread');

        $thread->subscribe();

        $thread->addReply([
            'user_id' => create('App\User')->id,
            'body' => 'Reply here',
        ]);

        $notifications = $this->getJson('/notifications')->json();

        $this->assertCount(1, $notifications);

    }

    public function testAUserCanMarkANotificationAsRead()
    {
        $thread = create('App\Thread');

        $thread->subscribe();

        $thread->addReply([
            'user_id' => create('App\User')->id,
            'body' => 'Reply here',
        ]);

        $this->assertCount(1, auth()->user()->unreadNotifications);

        $notificationId = auth()->user()->unreadNotifications->first()->id;

        $this->delete('/notifications/' . $notificationId);

        $this->assertCount(0, auth()->user()->fresh()->unreadNotifications);
    }
}
