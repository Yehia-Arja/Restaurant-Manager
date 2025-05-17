<?php

namespace App\Services\Client;

use App\Models\Chat;
use App\Models\Message;
use App\Schemas\MessageSchema;
use App\Services\Common\PrismService;
use App\Services\IntentHandlers\ProductIntentHandler;
use App\Services\IntentHandlers\AppGuideResponder;
use App\Services\IntentHandlers\AppGuiderIntentHandler;

class ChatService
{
    public static function handleMessage(array $data)
    {
        $chat = $data['chat'];

        // Save user message
        Message::create([
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

        if (!empty($structured['reply'])) {
            Message::create([
                'chat_id'     => $chat->id,
                'sender_type' => 'assistant',
                'content'     => $structured['reply'],
            ]);
            return $structured;
        }

        $intent = $structured['intent'] ?? null;
        $reply = 'Sorry, I didn’t understand.';

        if ($intent === 'product_enquiry') {
            $reply = ProductIntentHandler::handle($structured);
        } elseif ($intent === 'app_enquiry') {
            $reply = AppGuiderIntentHandler::handle($data['message']);
        }

        Message::create([
            'chat_id'     => $chat->id,
            'sender_type' => 'assistant',
            'content'     => $reply,
        ]);

        $structured['reply'] = $reply;
        return $structured;
    }

    public static function getChatHistory(Chat $chat): array
    {
        return Message::where('chat_id', $chat->id)
        ->orderBy('created_at')
        ->get(['sender_type', 'content', 'created_at'])
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
