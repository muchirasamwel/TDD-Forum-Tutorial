<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ThreadsTest extends TestCase
{
    use DatabaseMigrations;

    public function test_a_user_can_get_all_threads()
    {
        $thread=factory('App\Thread')->create();
        $response = $this->get('/threads');
        $response->assertSee($thread->title);


    }

    public function test_user_can_get_a_thread()
    {
        $thread=factory('App\Thread')->create();

        $response = $this->get('/threads/'.$thread->id);
        $response->assertSee($thread->title);

    }
}
