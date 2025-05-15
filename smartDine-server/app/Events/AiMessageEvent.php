<?php

namespace App\Events;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;

class AiMessageEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets;

    public int $chatId;
    public string $text;

    public function __construct(int $chatId, string $text)
    {
        $this->chatId = $chatId;
        $this->text   = $text;
    }

    public function broadcastOn(): PrivateChannel
    {
        return new PrivateChannel("chat.{$this->chatId}");
    }

    public function broadcastWith(): array
    {
        return ['text' => $this->text];
    }

    public function broadcastAs(): string
    {
        return 'AiMessageEvent';
    }
}
