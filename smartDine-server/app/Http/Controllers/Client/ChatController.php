<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\MessageRequest;
use App\Services\Client\ChatService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ChatController extends Controller
{

    public function handleUserMessage(MessageRequest $request): JsonResponse
    {
        try {
            $userId = Auth::id();
            $data = $request->validated();

            $chat = ChatService::getOrCreateChat(
                $userId,
                $data['restaurant_location_id']
            );

            $prompt = $this->buildChatPrompt($chat, $data['message']);

            $payload = [
                'user_id'   => $userId,
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

            return $this->error($e->getMessage(), 500);
        }
    }

    public function getChatHistory(Request $request): JsonResponse
    {
        try {
            $userId = Auth::id();
            $branchId = $request->input('restaurant_location_id');

            $chat = ChatService::getOrCreateChat($userId, $branchId);
            $history = ChatService::getChatHistory($chat);

            return $this->success('Chat history retrieved successfully.', $history);
        } catch (\Throwable $e) {
            Log::error('Fetching chat history failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return $this->error('Failed to fetch chat history.', 500);
        }
    }


    public function deleteMessage(int $id): JsonResponse
    {
        try {
            $userId = Auth::id();
            ChatService::deleteMessage($id, $userId);

            return $this->success("Message deleted successfully.");
        } catch (\Throwable $e) {
            Log::error('Deleting message failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return $this->error("Failed to delete message.", 403);
        }
    }
}
