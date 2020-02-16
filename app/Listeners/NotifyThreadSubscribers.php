<?php

namespace App\Listeners;

use App\Events\ThreadHasReply;

class NotifyThreadSubscribers
{

    public function __construct()
    {
        //
    }

    public function handle(ThreadHasReply $event)
    {
        $event->thread->subscriptions
            ->where('user_id', '!=', $event->reply->user_id)
            ->each
            ->notify($event->reply);
    }
}
