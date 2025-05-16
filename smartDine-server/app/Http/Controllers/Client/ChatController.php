<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\Message;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Prism\Prism\Prism;
use Prism\Prism\Enums\Provider;
use Prism\Prism\Schema\ObjectSchema;
use Prism\Prism\Schema\StringSchema;

class ChatController extends Controller
{
    public function getPastChats(Request $request)
    {
        $userId   = $request->user()->id;
        $branchId = $request->query('branch_id');

        $chat = Chat::where('user_id', $userId)
            ->where('restaurant_location_id', $branchId)
            ->latest()
            ->first();

        if (! $chat) {
            return response()->json([]);
        }

        return response()->json(
            Message::where('chat_id', $chat->id)
                ->orderBy('created_at')
                ->get()
        );
    }

    public function handleUserMessage(Request $request)
    {
        $userId      = $request->user()->id;
        $branchId    = $request->input('branch_id');
        $userMessage = $request->input('message');

        // Detect if user wants more details
        $needsMore = preg_match('/\b(explain more|tell me more|more details)\b/i', $userMessage) === 1;

        $chat = Chat::firstOrCreate(
            ['user_id' => $userId, 'restaurant_location_id' => $branchId],
            ['created_at' => now(), 'updated_at' => now()]
        );

        // Save user's message
        Message::create([
            'user_id' => $userId,
            'chat_id' => $chat->id,
            'sender'  => 'user',
            'content' => $userMessage,
        ]);

        // Determine intent
        $intentSchema = new ObjectSchema(
            name: 'intent_detection',
            description: 'Detect user intent: recommendation or other',
            properties: [
                new StringSchema('intent', "Either 'recommendation' or 'other'"),
            ],
            requiredFields: ['intent']
        );

        $intentResp = Prism::structured()
            ->using(Provider::OpenAI, 'gpt-4o')
            ->withSchema($intentSchema)
            ->withPrompt("You are a restaurant AI assistant. Identify the user's intent from this message: '$userMessage'. Reply with 'recommendation' or 'other'.")
            ->asStructured();

        $intent = strtolower(trim($intentResp->structured['intent'] ?? 'other'));

        if ($intent === 'recommendation') {
            $cachedNames = Cache::get("user:{$userId}:branch:{$branchId}:recs", []);
            $userWantsAlternatives = str_contains(strtolower($userMessage), 'other than');
            $recs = collect();

            if ($userWantsAlternatives && !empty($cachedNames)) {
                // user asked "other than these" → fetch different products
                $recs = Product::whereHas('locations', function ($q) use ($branchId) {
                        $q->where('restaurant_location_id', $branchId);
                    })
                    ->whereNotIn('name', $cachedNames)
                    ->latest()
                    ->take(10)
                    ->get();
            } else {
                if (!empty($cachedNames)) {
                    $recs = Product::whereIn('name', $cachedNames)->get();
                }
                if ($recs->isEmpty()) {
                    // fallback to branch products
                    $recs = Product::whereHas('locations', function ($q) use ($branchId) {
                            $q->where('restaurant_location_id', $branchId);
                        })
                        ->latest()
                        ->take(10)
                        ->get();
                }
            }

            // Fetch last 3 messages for context (or fewer if not available)
            $history = Message::where('chat_id', $chat->id)
                ->latest()
                ->take(3)
                ->orderBy('created_at')
                ->get()
                ->map(fn($msg) => ucfirst($msg->sender) . ': ' . $msg->content)
                ->implode("\n");

            // Setup schema for structured reply
            $recSchema = new ObjectSchema(
                name: 'recommendation_response',
                description: 'Structured reply with product recommendations',
                properties: [
                    new StringSchema('reply', 'Bot reply with product suggestions'),
                ],
                requiredFields: ['reply']
            );

            // Build the prompt with conditional detail level
            $prompt = "You are a restaurant assistant. ONLY use the products listed below. Never invent or guess any dish names, and respect any 'other than' requests in the conversation history. ";
            if ($needsMore) {
                $prompt .= "Provide detailed explanations for each dish's ingredients and why the user will like them. ";
            } else {
                $prompt .= "Give each recommendation in a single concise line (1–2 sentences). ";
            }
            $prompt .= "Here is the context (last messages):\n{$history}\n\n";
            $prompt .= "Available products:\n";
            $prompt .= collect($recs)->map(function ($product) {
                return "- **{$product->name}**: {$product->description} (Ingredients: {$product->ingredients}, Price: \${$product->price})";
            })->implode("\n");

            $response = Prism::structured()
                ->using(Provider::OpenAI, 'gpt-4o')
                ->withSchema($recSchema)
                ->withPrompt($prompt)
                ->asStructured();

            $botReply = $response->structured['reply'] ?? "Sorry, I couldn't find recommendations.";
        } else {
            // Generic conversational reply
            $convSchema = new ObjectSchema(
                name: 'conversation_response',
                description: 'A conversational reply to the user message',
                properties: [
                    new StringSchema('reply', 'Bot conversational reply'),
                ],
                requiredFields: ['reply']
            );

            $response = Prism::structured()
                ->using(Provider::OpenAI, 'gpt-4o')
                ->withSchema($convSchema)
                ->withPrompt("You are a friendly restaurant chatbot. Reply conversationally to the user's message: '$userMessage'")
                ->asStructured();

            $botReply = $response->structured['reply'] ?? '';
        }

        // Save bot reply
        Message::create([
            'user_id' => $userId,
            'chat_id' => $chat->id,
            'sender'  => 'bot',
            'content' => $botReply,
        ]);

        return response()->json(['reply' => $botReply]);
    }
}
