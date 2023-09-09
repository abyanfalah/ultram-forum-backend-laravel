<?php

namespace App\Listeners;

use App\Events\NewCommentSent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ListenNewCommentSent
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(NewCommentSent $event): void
    {
        $channelName = "comment-thread-" . $event->post->thread_id;

        info('new comment', [$channelName]);
    }
}
