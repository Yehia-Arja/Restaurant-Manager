<?php

namespace App\Traits;


use App\Models\Product;
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
            ->map(fn($m) => ucfirst($m->sender_type) . ': ' . $m->content)
            ->implode("\n");


        $favorites = Cache::get("user:{$user->id}:favorites", []);
        $recs = Cache::get("user:{$user->id}:recommendations", []);

        if (!$recs) {
            $recs = Product::whereHas('locations', function ($q) use ($location) {
                $q->where('locationable_type', 'App\Models\RestaurantLocation')
                  ->where('locationable_id', $location->id);
            })
            ->latest()->take(10)
            ->get(['name'])
            ->toArray();
        }

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
            - You have access to the past 10 messages.
            - Reply to the user in a friendly and helpful manner.
            - Reply if possible with the given lists if no lists were given return i will be back soon and dont give him any product name from your own.
            - Or return an intent with any extra details (product name, category, tags).
            PROMPT;
    }
}