<?php
namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class SubscribeToThreadTest extends TestCase
{
   use DatabaseMigrations;
    public function test_user_can_subscribe_to_a_thread()
    {
        $this->signIn();
        $thread=create('App\Thread');

        $this->post($thread->path()."/subscriptions");

        $this->assertCount(1,$thread->subscriptions);

        $thread->addReply([
           'user_id'=>auth()->id(),
           'body'=>'Reply Here'
        ]);

      //  $this->assertCount(1,auth()->user()->notifications);
    }
}
