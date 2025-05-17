<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\MessageRequest;
use App\Services\Client\ChatService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\JsonResponse;

class ChatController extends Controller
{

    public function handleUserMessage(MessageRequest $request): JsonResponse
    {
        try {
            $user = Auth::user();
            $data = $request->validated();

            $chat = ChatService::getOrCreateChat(
                $user->id,
                $data['restaurant_location_id']
            );

            $prompt = $this->buildChatPrompt($chat, $data['message']);

            $payload = [
                'user_id'   => $user->id,
                'message'   => $data['message'],
                'chat'      => $chat,
                'prompt'    => $prompt,
                'branch_id' => $data['branch_id'] ?? $data['restaurant_location_id'],
            ];

            $response = ChatService::handleMessage($payload);

            return $this->success($response['reply']);
        } catch (\Throwable $e) {
            Log::error('Chat message handling failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return $this->error('An error occurred while processing your message.', 500);
        }
    }
}
