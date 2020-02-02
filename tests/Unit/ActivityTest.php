<?php

namespace Tests\Feature;

use App\Activity;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ActivityTest extends TestCase
{
   use DatabaseMigrations;
    public function test_activity_recorded_when_a_thread_is_created()
    {
        $this->signIn();
        $thread = create('App\Thread');
        $this->assertDatabaseHas('activities', [
            'type' => 'created_thread',
            'user_id' => auth()->id(),
            'subject_id' => $thread->id,
            'subject_type' => 'App\Thread'
        ]);
        $activity = Activity::first();
        $this->assertEquals($activity->subject->id, $thread->id);
    }
    public function test_activity_recorded_when_a_reply_is_created()
    {
        $this->signIn();
        $reply = create('App\Reply');
        $this->assertEquals(2, Activity::count());
    }
}
