<?php

namespace App\Services\Client;

use App\Models\Chat;
use App\Models\Message;
use App\Schemas\MessageSchema;
use App\Services\Common\PrismService;
use App\Services\IntentHandlers\ProductIntentHandler;
use App\Services\IntentHandlers\AppGuiderIntentHandler;

class ChatService
{
    public static function handleMessage(array $data)
    {
        $chat = $data['chat'];

        // Save user message
        Message::create([
            'user_id'     => $data['user_id'],
            'chat_id'     => $chat->id,
            'sender_type' => 'user',
            'content'     => $data['message'],
        ]);

        $schema = MessageSchema::make('chat_message', 'Structured chat response', [
            'intent'       => 'What the user wants to do',
            'reply'        => 'AI reply if possible',
            'product_name' => 'Mentioned product, if any',
            'tags'         => 'Comma-separated tags',
            'category'     => 'Category if applicable',
        ]);

        $structured = PrismService::generate($schema, $data['prompt']);

        $reply = $structured['reply'] ?? null;

        if (!$reply) {
            $intent = $structured['intent'] ?? null;
            $reply = 'Sorry, I didn’t understand.';

            if ($intent === 'product_enquiry') {
                $reply = ProductIntentHandler::handle($structured);
            } elseif ($intent === 'app_enquiry') {
                $reply = AppGuiderIntentHandler::handle($data['message']);
            }
        }

        $aiMessage = Message::create([
            'user_id'     => $data['user_id'],
            'chat_id'     => $chat->id,
            'sender_type' => 'ai',
            'content'     => $reply,
        ]);

        $structured['reply'] = $reply;
        $structured['message'] = $aiMessage;

        return $structured;
    }

    public static function getChatHistory(Chat $chat): array
    {
        return Message::where('chat_id', $chat->id)
            ->orderBy('created_at')
            ->get()
            ->toArray();
    }

    public static function getOrCreateChat($userId, $locationId): Chat
    {
        return Chat::firstOrCreate([
            'user_id' => $userId,
            'restaurant_location_id' => $locationId,
        ]);
    }

    public static function deleteMessage(int $id, int $userId): void
    {
        $message = Message::findOrFail($id);
        $chat = Chat::findOrFail($message->chat_id);

        if ($chat->user_id !== $userId) {
            throw new \Exception("Unauthorized action.");
        }

        $message->delete();
    }
}
