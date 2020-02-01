<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ParticipationTest extends TestCase
{
    use DatabaseMigrations;
    public function test_unauthenticated_user_may_not_participate_on_thread(){
       $this->expectException('Illuminate\Auth\AuthenticationException');
        $thread = factory('App\Thread')->create();
        $reply = factory('App\Reply')->create();
        $this->post($thread->path()."/replies",$reply->toArray());
    }
    public function test_authenticated_user_can_participate_in_threads()
    {
        $this->be($user=factory('App\User')->create());

        $thread = factory('App\Thread')->create();

        $reply = factory('App\Reply')->make();

        $this->post($thread->path().'/replies',$reply->toArray());

        $this->get($thread->path())
            ->assertSee($reply->body);
    }
}
