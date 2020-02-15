<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReadThreadsTest extends TestCase
{
    use DatabaseMigrations;
    public $thread;

    protected function setUp(): void
    {
        parent::setUp();
        $this->thread = factory('App\Thread')->create();
    }

    function test_a_user_can_get_all_threads()
    {

        $this->get('/threads')
            ->assertSee($this->thread->title);
    }

    function test_user_can_get_a_thread()
    {
        $this->get($this->thread->path())
            ->assertSee($this->thread->title);

    }

//    function test_user_can_read_replies_to_a_thread()
//    {
//        $reply = factory('App\Reply')->create(['thread_id' => $this->thread->id]);
//        $this->get($this->thread->path())
//            ->assertSee($reply->body);
//    }

    function test_user_can_filter_threads_using_tag()
    {
        $channel = create('App\Channel');
        $threadInChannel = create('App\Thread', ['channel_id' => $channel->id]);
        $threadNotInChannel = create('App\Thread',['channel_id' => 10000]);

        $this->get('/threads/' . $channel->slug)
            ->assertSee($threadInChannel->title)
            ->assertSee($threadInChannel->body)
            ->assertDontSee($threadNotInChannel->title);
    }

    function test_user_can_filter_threads_by_username()
    {
        $user = create('App\User', ['name' => 'JohnDoe']);
        $this->signIn($user);
        $threadByJohn = create('App\Thread', ['user_id' => $user->id]);
        $anotherThread = create('App\Thread', ['user_id' => 6789098]);

        $this->get('/threads?by=JohnDoe')
            ->assertSee($threadByJohn->title)
            ->assertDontSee($anotherThread->title);

    }



    function test_user_can_filter_thread_by_popularity()
    {
        $threadWithTwoReplies = create('App\Thread');
        create('App\Reply', ['thread_id' => $threadWithTwoReplies->id], 2);
        $threadWithThreeReplies = create('App\Thread');
        create('App\Reply', ['thread_id' => $threadWithThreeReplies->id], 3);
        $response = $this->getJson('threads?popular=1')->json();
        $this->assertEquals([3, 2, 0], array_column($response, 'replies_count'));

    }

    function test_a_user_can_request_all_replies_for_a_give_thread(){
        $thread = create('App\Thread');
        create('App\Reply', ['thread_id' => $thread->id]);

        $response=$this->getJson($thread->path()."/replies")->json();
       // dd($response);
        $this->assertCount(1,$response['data']);
        $this->assertEquals(1,$response['total']);
    }

    function test_user_can_filter_unanswered_threads(){
        $thread = create('App\Thread');
        create('App\Reply', ['thread_id' => $thread->id]);

        $response=$this->getJson("threads?unanswered=1")->json();

        $this->assertCount(1,$response);

    }

}
