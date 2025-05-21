<?php

namespace App\Services\AI;

use App\Models\Chat;
use App\Models\Message;
use App\Models\Product;
use Illuminate\Support\Facades\Cache;
use App\Services\AI\Schemas\PromptSchema;

class ChatPromptBuilder
{
    public function build(Chat $chat, string $latestMessage): string
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

        $schema = new PromptSchema([
            'user' => $user->name,
            'branchInfo' => json_encode($location->toArray()),
            'favorites' => $favorites ? implode(', ', array_column($favorites, 'name')) : 'none',
            'recommended' => $recs ? implode(', ', array_column($recs, 'name')) : 'none',
            'pastMessages' => $pastMessages,
            'latestMessage' => $latestMessage
        ]);

        return $schema->toPrompt();
    }
}
