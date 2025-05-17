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
            'message'     => $data['message'],
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
                'message'     => $structured['reply'],
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
            'message'     => $reply,
        ]);

        $structured['reply'] = $reply;
        return $structured;
    }
}
