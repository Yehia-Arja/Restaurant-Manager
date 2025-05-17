<?php

namespace App\Traits;

use App\Models\Chat;
use App\Models\Message;
use Illuminate\Support\Facades\Cache;

trait BuildChatPromptTrait
{
    public function buildChatPrompt(Chat $chat, string $latestMessage): string
    {
        $user = $chat->user;
        $location = $chat->restaurantLocation;

        $pastMessages = Message::where('chat_id', $chat->id)
            ->latest()->take(10)->get()->reverse()
            ->map(fn($m) => ucfirst($m->sender_type) . ': ' . $m->message)
            ->implode("\n");

        $favorites = Cache::get("user:{$user->id}:favorites", []);
        $recs = Cache::get("user:{$user->id}:recommendations", []);

        $favoritesList = $favorites ? implode(", ", array_column($favorites, 'name')) : 'none';
        $recommendedList = $recs ? implode(", ", array_column($recs, 'name')) : 'none';

        $locationInfo = json_encode($location->toArray());

        return <<<PROMPT
            You are an AI assistant inside a restaurant mobile app.

            User: {$user->name}  
            Branch Info: {$locationInfo}

            Favorites: {$favoritesList}  
            Recommended: {$recommendedList}

            Past 10 messages:
            {$pastMessages}

            Current user message:
            "{$latestMessage}"

            Your job is to:
            - Reply if possible.
            - Or return an intent with any extra details (product name, category, tags).
            PROMPT;
    }
}
