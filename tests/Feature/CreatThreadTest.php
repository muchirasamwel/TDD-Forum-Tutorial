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
        $this->expectException('Illuminate\Auth\AuthenticationException');
        $this->post("/threads",[]);
        $this->get('/threads/create');

    }
    public function test_authenticated_user_can_create_thread()
    {
        $this->signIn();

        $thread = create('App\Thread');
        $this->post('/threads', $thread->toArray());

        $this->get($thread->path())
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }
}
