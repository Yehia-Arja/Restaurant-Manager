<?php

namespace App\Services;

use App\Models\Chat;
use App\Models\Message;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Config;
use App\Events\AiMessageEvent;

class AiChatService
{
    public function process(int $userId, int $branchId, string $text, ?int $chatId = null): Chat
    {
        // Get or create chat session
        $chat = $chatId
            ? Chat::find($chatId)
            : Chat::firstOrCreate(
                ['user_id' => $userId, 'branch_id' => $branchId],
                ['user_id' => $userId, 'branch_id' => $branchId]
              );

        // Save user message
        Message::create([
            'user_id'     => $userId,
            'chat_id'     => $chat->id,
            'sender_type' => 'USER',
            'content'     => $text,
        ]);

        // Load conversation history
        $history = Message::where('chat_id', $chat->id)
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(fn($m) => "{$m->sender_type}: {$m->content}")
            ->implode("\n");

        // Fetch product cache
        $key      = "products:{$userId}:{$branchId}";
        $products = json_encode(json_decode(Redis::get($key) ?: '[]'));

        // Extract intent (for internal logic only)
        $intentPrompt = Config::get('ai_prompts.intent');
        $payload1 = strtr($intentPrompt, [
            '{{products}}' => $products,
            '{{message}}'  => $text,
        ]);
        $resp1   = $this->callOpenAi($payload1);
        $intent  = data_get(json_decode($resp1, true), 'intent', 'unknown');

        // Generate full AI reply based on that intent
        $responsePrompt = Config::get('ai_prompts.response');
        $payload2 = strtr($responsePrompt, [
            '{{intent}}'   => $intent,
            '{{branchId}}' => $branchId,
            '{{history}}'  => $history,
            '{{message}}'  => $text,
        ]);
        $reply = $this->callOpenAi($payload2);

        // Save AI message
        Message::create([
            'user_id'      => $userId,
            'chat_id'      => $chat->id,
            'sender_type'  => 'AI',
            'content'      => $reply,
        ]);

        // Broadcast only the AI message
        broadcast(new AiMessageEvent($chat->id, $reply))->toOthers();

        return $chat;
    }

    protected function callOpenAi(string $prompt): string
    {
        $apiKey = Config::get('openai.key');
        $model  = Config::get('openai.model');

        $response = Http::withHeaders([
            'Authorization' => "Bearer {$apiKey}",
        ])->post('https://api.openai.com/v1/chat/completions', [
            'model'        => $model,
            'messages'     => [['role'=>'system','content'=>$prompt]],
            'temperature'  => 0.7,
        ]);

        return $response->json('choices.0.message.content') ?: '';
    }
}
