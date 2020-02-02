<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreatThreadTest extends TestCase
{
    use DatabaseMigrations;

    public function test_guest_cannot_create_thread()
    {
        //$this->expectException('Illuminate\Auth\AuthenticationException');
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
      //  $this->expectException('Illuminate\Validation\ValidationException');
        $this->signIn();
        $thread=make('App\Thread',['title'=>null]);
        $this->withExceptionHandling()->post('/threads',$thread->toArray())
            ->assertSessionHasErrors('title');
    }
    function test_thread_requires_a_body(){
       // $this->expectException('Illuminate\Validation\ValidationException');
        $this->signIn();
        $thread=make('App\Thread',['body'=>null]);
        $this->withExceptionHandling()->post('/threads',$thread->toArray())
            ->assertSessionHasErrors('body');
    }
    function test_thread_requires_valid_channel_id(){
        //$this->expectException('Illuminate\Validation\ValidationException');
        factory('App\Channel',2)->create();
        $this->signIn();
        $thread=make('App\Thread',['channel_id'=>5675]);
        $this->withExceptionHandling()->post('/threads',$thread->toArray())
            ->assertSessionHasErrors('channel_id');
    }
}
