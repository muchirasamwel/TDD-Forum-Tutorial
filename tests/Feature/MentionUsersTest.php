<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class MentionUsersTest extends TestCase
{
    use DatabaseMigrations;

    public function test_mentioned_users_in_are_reply_are_notified()
    {
        $john = create('App\User', ['name' => 'JohnDoe']);

        $this->signIn($john);

        $jane = create('App\User', ['name' => 'JaneDoe']);

        $thread = create('App\Thread');

        $reply = make('App\Reply', [
            'body' => 'Sure @JaneDoe That is true.'
        ]);

        $response = $this->json('post', $thread->path() . '/replies', $reply->toArray());

        $this->assertCount(1, $jane->fresh()->notifications);
    }
}
