<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Notifications\ThreadWasUpdated;
use Illuminate\Support\Facades\Notification;
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
    public function test_a_thread_can_be_subscribed_to(){
        $thread=create('App\Thread');
        $this->signIn();
        $thread->subscribe();
       $this->assertEquals(1, $thread->subscriptions()->where('user_id',auth()->id())->count());
    }

    public function test_a_thread_can_be_unsubscribed_from(){

        $thread=create('App\Thread');

        $thread->subscribe(1);

        $thread->unsubscribe(1);

        $this->assertCount(0, $thread->subscriptions);
    }

    public function test_thread_detects_if_an_authenticated_user_is_subscribed_to_it()
    {
        $thread = create('App\Thread');

        $this->signIn();

        $this->assertFalse($thread->isSubscribedTo);

        $thread->subscribe();

        $this->assertTrue($thread->isSubscribedTo);
    }

    function test_thread_notifies_all_registered_subscribers_on_a_reply_is_added()
    {
        Notification::fake();

        $this->signIn()
            ->thread
            ->subscribe()
            ->addReply([
                'body' => 'Hey This Is my reply',
                'user_id' => 12
            ]);

        Notification::assertSentTo(auth()->user(), ThreadWasUpdated::class);
    }
}
