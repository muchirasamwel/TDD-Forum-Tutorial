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
       $thread = create('App\Thread');
        $reply = create('App\Reply');
        $response=$this->post($thread->path()."/replies",$reply->toArray())
            ->assertDontSee($reply->body);
       // dump($response);
    }
    public function test_authenticated_user_can_participate_in_threads()
    {
        $this->be($user=create('App\User'));

        $thread = create('App\Thread');

        $reply = make('App\Reply');

        $this->post($thread->path().'/replies',$reply->toArray());

        $this->get($thread->path())
            ->assertSee($reply->body);
    }
    function test_reply_requires_a_body(){
         $this->signIn();
        $thread = create('App\Thread');
        $reply=make('App\Reply',['body'=>null]);
        $this->withExceptionHandling()->post($thread->path().'/replies',$reply->toArray())
        ->assertSessionHasErrors('body');

    }
}
