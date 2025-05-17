<?php

namespace App\Schemas;

use Prism\Prism\Schema\ObjectSchema;
use Prism\Prism\Schema\StringSchema;

class MessageSchema
{
    public static function make(string $name, string $description, array $fields): ObjectSchema
    {
        $properties = [];
        $required = [];

        foreach ($fields as $key => $desc) {
            $properties[] = new StringSchema($key, $desc);
            $required[] = $key;
        }

        return new ObjectSchema(
            name: $name,
            description: $description,
            properties: $properties,
            requiredFields: $required
        );
    }
}
