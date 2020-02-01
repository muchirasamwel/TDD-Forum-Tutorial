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
    }
    public function test_authenticated_user_can_create_thread()
    {
        $this->actingAs(factory('App\User')->create());

        $thread = factory('App\Thread')->make();

        $this->post('/threads', $thread->toArray());
        $this->get($thread->path())
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }
}
