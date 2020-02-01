<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ThreadTest extends TestCase
{

    use DatabaseMigrations;
    private $thread;
    protected function setUp(): void
    {
        parent::setUp();
        $this->thread=create('App\Thread');
    }
    public function test_a_thread_has_replies()
    {
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection',$this->thread->replies);
    }

    public function test_a_thread_has_a_creator()
    {
        $this->assertInstanceOf('App\User',$this->thread->creator);
    }

    public function test_thread_can_add_a_reply(){
        $this->thread->addReply([
            'body'=>'Foobar',
            'user_id'=>1
        ]);
        $this->assertCount(1,$this->thread->replies);
    }

    public function test_a_thread_belongs_to_a_channel()
    {
        $thread=create('App\Thread');

        $this->assertInstanceOf('App\Channel',$thread->channel);
    }
    public function test_a_thread_can_make_a_string_path()
    {
        $thread=create('App\Thread');

        $this->assertEquals("/threads/{$thread->channel->slug}/{$thread->id}",$thread->path());
    }
}
