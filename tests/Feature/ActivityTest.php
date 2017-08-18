<?php

namespace Tests\Feature;

use App\Activity;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ActivityTest extends TestCase
{
    use DatabaseMigrations;

    public function testItRecordsAnActivityWhenAThreadIsCreated()
    {
        $this->signIn();

        $thread = create('App\Thread');

        $this->assertDatabaseHas('activities', [
            'type' => 'created_thread',
            'user_id' => auth()->id(),
            'subject_id' => $thread->id,
            'subject_type' => 'App\Thread',
        ]);

        $activity = Activity::first();

        $this->assertEquals($activity->subject->id, $thread->id);
    }

    public function testItRecordsAnActivityWhenAReplyIsCreated()
    {
        $this->signIn();

        $reply = create('App\Reply');

        $this->assertDatabaseHas('activities', [
            'type' => 'created_reply',
            'user_id' => auth()->id(),
            'subject_id' => $reply->id,
            'subject_type' => 'App\Reply',
        ]);

        // Assert 2 since 1 for Reply and 1 for associated Thread
        $this->assertEquals(2, Activity::count());

    }
}
