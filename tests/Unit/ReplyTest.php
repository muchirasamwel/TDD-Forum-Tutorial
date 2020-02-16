<?php

namespace Tests\Unit;

use App\Reply;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ReplyTest extends TestCase
{
    use DatabaseMigrations;

    public function test_reply_has_owner()
    {
        $reply=create('App\Reply');
        $this->assertInstanceOf('App\User',$reply->owner);
    }

    public function test_reply_knows_if_it_was_just_published()
    {
        $reply = create('App\Reply');

        $this->assertTrue($reply->wasJustPublished());

        $reply->created_at = Carbon::now()->subMonth();

        $this->assertFalse($reply->wasJustPublished());
    }

    public function test_reply_can_detect_all_mentioned_users_in_the_body()
    {
        $reply = new Reply([
            'body' => '@JaneDoe wants to talk to @JohnDoe'
        ]);

        $this->assertEquals(['JaneDoe', 'JohnDoe'], $reply->mentionedUsers());
    }

    public function tests_mentioned_username_in_the_body_is_wrapped_within_anchor_tags()
    {
        $reply = new Reply([
            'body' => 'Hello @Jane-Doe.'
        ]);

        $this->assertEquals(
            'Hello <a href="/profiles/Jane-Doe">@Jane-Doe</a>.',
            $reply->body
        );

    }
}
