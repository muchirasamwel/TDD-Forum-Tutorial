<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ThreadsTest extends TestCase
{
    use DatabaseMigrations;
    public $thread;
    protected function setUp(): void
    {
        parent::setUp();
        $this->thread=factory('App\Thread')->create();
    }

    public function test_a_user_can_get_all_threads()
    {

        $this->get('/threads')
            ->assertSee($this->thread->title);
    }

    public function test_user_can_get_a_thread()
    {
         $this->get('/threads/'.$this->thread->id)
            ->assertSee($this->thread->title);

    }

    public function test_user_can_read_replies_to_a_thread()
    {
        $reply=factory('App\Reply')->create(['thread_id'=>$this->thread->id]);
        $this->get('/threads/'.$this->thread->id)
            ->assertSee($reply->body);

    }
}
