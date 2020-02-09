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
    public function test_reply_requires_a_body(){
         $this->signIn();
        $thread = create('App\Thread');
        $reply=make('App\Reply',['body'=>null]);
        $this->withExceptionHandling()->post($thread->path().'/replies',$reply->toArray())
        ->assertSessionHasErrors('body');
    }
    public function test_unauthorized_users_cannot_delete_a_reply()
    {
        $this->withExceptionHandling();
        $reply = create('App\Reply');
        $this->delete("/replies/{$reply->id}")
            ->assertRedirect('login');
        $this->signIn()
            ->delete("/replies/{$reply->id}")
            ->assertStatus(403);
    }

    function test_authorized_users_can_delete_replies()
    {
        $this->signIn();
        $reply = create('App\Reply', ['user_id' => auth()->id()]);

        $this->delete("/replies/{$reply->id}")->assertStatus(302);
        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);
    }

    function test_unauthorized_users_cannot_update_replies()
    {
        $this->withExceptionHandling();

        $reply = create('App\Reply');

        $this->patch("/replies/{$reply->id}")
            ->assertRedirect('login');

        $this->signIn()
            ->patch("/replies/{$reply->id}")
            ->assertStatus(403);
    }

    function test_authorized_users_can_update_replies()
    {
        $this->signIn();

        $reply = create('App\Reply', ['user_id' => auth()->id()]);

        $updatedReply = 'You been changed, fool.';
        $this->patch("/replies/{$reply->id}", ['body' => $updatedReply]);

        $this->assertDatabaseHas('replies', ['id' => $reply->id, 'body' => $updatedReply]);
    }

}
