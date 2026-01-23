<?php

namespace CSLog\CS2\Parsers;

class CVarValueParser
{
    public static function parse(string $value): string|int|float|bool|null
    {
        $trimmed = trim($value);

        // Empty string
        if ($trimmed === '') {
            return '';
        }

        // Boolean
        if ($trimmed === 'true') {
            return true;
        }

        if ($trimmed === 'false') {
            return false;
        }

        // Integer
        if (ctype_digit($trimmed)) {
            return (int) $trimmed;
        }

        // Float
        if (is_numeric($trimmed)) {
            return (float) $trimmed;
        }

        // Default: string
        return $trimmed;
    }
}
