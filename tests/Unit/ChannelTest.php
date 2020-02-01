<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ChannelTest extends TestCase
{
   use DatabaseMigrations;
    public function test_channel_has_threads()
    {
        $channel = create('App\Channel');
        $thread = create('App\Thread',['channel_id'=>$channel->id]);
         $this->assertTrue($channel->threads->contains($thread));
    }
}
