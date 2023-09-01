<?php

namespace App\Listeners;

use App\Events\MessageSent;

class DisplayNewMessageToUser
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
    public function handle(MessageSent $event): void
    {
        info('sent message', [$event->message]);
    }
}
