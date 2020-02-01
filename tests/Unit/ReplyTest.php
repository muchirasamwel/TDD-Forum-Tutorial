<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ReplyTest extends TestCase
{
    use DatabaseMigrations;

    function test_reply_has_owner()
    {
        $reply=create('App\Reply');
        $this->assertInstanceOf('App\User',$reply->owner);
    }
}
