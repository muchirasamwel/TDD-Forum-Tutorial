<?php

namespace Tests\Feature;

use App\Activity;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreatThreadTest extends TestCase
{
    use DatabaseMigrations;

    public function test_guest_cannot_create_thread()
    {
        $this->withExceptionHandling()->post("/threads",[])
        ->assertRedirect('/login');

        $this->withExceptionHandling()->get('/threads/create')
            ->assertRedirect('/login');

    }
    public function test_authenticated_user_can_create_thread()
    {
        $this->signIn();
        $thread = make('App\Thread');
        $response=$this->post('/threads', $thread->toArray());

        $this->get($response->headers->get('Location'))
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }
    function test_thread_requires_a_title(){
       $this->signIn();
        $thread=make('App\Thread',['title'=>null]);
        $this->withExceptionHandling()->post('/threads',$thread->toArray())
            ->assertSessionHasErrors('title');
    }
    function test_thread_requires_a_body(){
        $this->signIn();
        $thread=make('App\Thread',['body'=>null]);
        $this->withExceptionHandling()->post('/threads',$thread->toArray())
            ->assertSessionHasErrors('body');
    }
    function test_thread_requires_valid_channel_id(){
        factory('App\Channel',2)->create();
        $this->signIn();
        $thread=make('App\Thread',['channel_id'=>5675]);
        $this->withExceptionHandling()->post('/threads',$thread->toArray())
            ->assertSessionHasErrors('channel_id');
    }

    function test_unauthorized_users_can_not_delete_threads()
    {
        $this->withExceptionHandling();

        $thread = create('App\Thread');

        $this->delete($thread->path())
            ->assertRedirect('/login');
        $this->signIn();
        $this->delete($thread->path())->assertStatus(403);
    }

    function test_thread_can_be_deleted_by_authorized_user()
    {
        $this->signIn();
        $thread = create('App\Thread', ['user_id' => auth()->id()]);
        $reply = create('App\Reply', ['thread_id' => $thread->id]);

        $response = $this->json('DELETE', $thread->path());

        $response->assertStatus(204);

        $this->assertDatabaseMissing('threads', ['id' => $thread->id]);
        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);
        $this->assertEquals(0, Activity::count());
    }
}
