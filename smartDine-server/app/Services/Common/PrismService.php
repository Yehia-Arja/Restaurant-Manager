<?php

namespace App\Services\Common;

use Prism\Prism\Prism;
use Prism\Prism\Enums\Provider;
use Prism\Prism\Schema\ObjectSchema;

class PrismService
{
    public static function generate(ObjectSchema $schema, string $prompt): array
    {
        $response = Prism::structured()
            ->using(Provider::OpenAI, 'gpt-4o')
            ->withSchema($schema)
            ->withPrompt($prompt)
            ->asStructured();

        return $response->structured ?? [];
    }
}
