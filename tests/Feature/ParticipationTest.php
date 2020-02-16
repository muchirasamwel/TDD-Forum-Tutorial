<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ParticipationTest extends TestCase
{
    use DatabaseMigrations;
    public function test_unauthenticated_user_may_not_participate_on_thread(){
       $thread = create('App\Thread');
        $reply = create('App\Reply');
        $response=$this->post($thread->path()."/replies",$reply->toArray())
            ->assertDontSee($reply->body);
    }
    public function test_authenticated_user_can_participate_in_threads()
    {
        $this->be($user=create('App\User'));

        $thread = create('App\Thread');

        $reply = make('App\Reply');

        $this->post($thread->path().'/replies',$reply->toArray());

        $this->assertDatabaseHas('replies',['body'=>$reply->body]);
        $this->assertEquals(1,$thread->fresh()->replies_count);

    }
    public function test_reply_requires_a_body(){
         $this->signIn();
        $thread = create('App\Thread');
        $reply=make('App\Reply',['body'=>null]);

        $this->withExceptionHandling()->post($thread->path().'/replies',$reply->toArray())
        ->assertStatus(422);
        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);
    }
    public function test_unauthorized_users_cannot_delete_a_reply()
    {
        $this->withExceptionHandling();
        $reply = create('App\Reply');
        $this->delete("/replies/{$reply->id}")
            ->assertRedirect('login');
        $this->signIn()
            ->delete("/replies/{$reply->id}")
            ->assertStatus(302);
    }

    public function test_authorized_users_can_delete_replies()
    {
        $this->signIn();
        $reply = create('App\Reply', ['user_id' => auth()->id()]);

        $this->delete("/replies/{$reply->id}")->assertStatus(302);

        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);

        $this->assertEquals(0,$reply->thread->fresh()->replies_count);
    }

    public function test_unauthorized_users_cannot_update_replies()
    {
        $this->withExceptionHandling();

        $reply = create('App\Reply');

        $this->patch("/replies/{$reply->id}")
            ->assertRedirect('login');

        $this->signIn()
            ->patch("/replies/{$reply->id}")
            ->assertStatus(422);
    }

    function test_authorized_users_can_update_replies()
    {
        $this->signIn();

        $reply = create('App\Reply', ['user_id' => auth()->id()]);

        $updatedReply = 'New content updated.';

        $this->patch("/replies/{$reply->id}", ['body' => $updatedReply]);

        $this->assertDatabaseHas('replies', ['id' => $reply->id, 'body' => $updatedReply]);
    }

    public function test_a_reply_that_contain_spam_may_not_be_created()
    {
        $this->signIn();

        $thread = create('App\Thread');
        $reply = make('App\Reply', [
            'body' => 'Yahoo Customer Support'
        ]);
        $this->post($thread->path() . '/replies', $reply->toArray())
            ->assertStatus(422);
        //$this->assertEquals('Your reply contains spam.',$response->exception->getMessage());
    }

    public function test_users_may_only_reply_a_maximum_of_once_per_minute()
    {
        $this->signIn();

        $thread = create('App\Thread');
        $reply = make('App\Reply');

        $this->post($thread->path() . '/replies', $reply->toArray())
            ->assertStatus(201);

        $this->post($thread->path() . '/replies', $reply->toArray())
            ->assertStatus(429);
    }



}
