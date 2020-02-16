<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ThreadHasReply
{
    use  SerializesModels;

    public $reply;
    public $thread;

    public function __construct($thread,$reply)
    {
       $this->reply=$reply;
       $this->thread=$thread;
    }
}
