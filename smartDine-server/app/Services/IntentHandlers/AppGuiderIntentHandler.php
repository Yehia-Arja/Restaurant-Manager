<?php

namespace App\Services\IntentHandlers;

use App\Services\Common\PrismService;
use App\Schemas\MessageSchema;

class AppGuiderIntentHandler
{
    public static function handle(string $userMessage): string
    {
        $guide = <<<GUIDE
            The app allows users to:
            1. Browse dishes by category or tag
            2. Favorite a product by tapping the heart icon
            3. View meals in AR before ordering
            4. Check their previous orders
            5. Ask the assistant for meal recommendations
            6. Place orders directly from the table via QR
            7. Access their profile and settings
            GUIDE;

        $schema = MessageSchema::make('app_guide_explanation', 'Context-aware feature explanation', [
            'reply' => 'Use the guide below to answer the user\'s question. If nothing matches, return a polite fallback message.',
        ]);

        // Engineered prompt
        $prompt = <<<PROMPT
            Act as a smart and friendly assistant inside a restaurant mobile app.

            You will be shown an app user guide and a user question.  
            Use the guide to respond clearly and helpfully.

            Rules:
            - Only answer if the guide includes the answer.
            - If nothing in the guide matches the question, say: "Sorry, I couldn't find anything in the app about that."

            App User Guide:
            {$guide}

            User Question:
            "{$userMessage}"

            Respond with a single helpful sentence if applicable.
        PROMPT;
        $structured = PrismService::generate($schema, $prompt);

        return $structured['reply'] ?? "Sorry, I couldn’t find that in the app guide.";
    }
}
