<?php

namespace App\Events;

use App\Models\Message;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    /**
     * Create a new event instance.
     */

    public function __construct(public Message $message)
    {
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        $privateChannelName = "private-conversation-" . $this->message->conversation_id;
        $channelName = "conversation-" . $this->message->conversation_id;

        $otherParties = $this->message->conversation()->first()->otherParty;

        $channels = [
            new Channel($channelName),
        ];

        foreach ($otherParties as $party) {
            $partyChannelName = "user-$party->id";
            array_push($channels, new Channel($partyChannelName));
        }

        return $channels;
    }
}
