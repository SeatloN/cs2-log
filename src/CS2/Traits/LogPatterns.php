<?php

namespace CSLog\CS2\Traits;

trait LogPatterns
{
    protected const LOG_PREFIX = '^(?:L )?(?P<timestamp>\d{2}\/\d{2}\/\d{4} - \d{2}:\d{2}:\d{2}(?:\.\d{3})?)(?:: | - )';

    /**
     * Build a complete pattern with the universal log prefix
     */
    protected static function pattern(string $eventPattern): string
    {
        return '/'.self::LOG_PREFIX.$eventPattern.'$/';
    }

    /**
     * Timestamp pattern with optional milliseconds
     */
    protected const TIMESTAMP = '\d{2}\/\d{2}\/\d{4} - \d{2}:\d{2}:\d{2}(?:\.\d{3})?';

    /**
     * Pattern for logs with "L " prefix and ":" separator
     * Example: L 01/19/2026 - 19:03:11: event...
     */
    protected static function patternWithL(string $eventPattern): string
    {
        return '/^L (?P<timestamp>'.self::TIMESTAMP.'): '.$eventPattern.'$/';
    }

    /**
     * Pattern for logs without "L " prefix and " - " separator
     * Example: 01/09/2024 - 03:50:44.170 - event...
     */
    protected static function patternWithoutL(string $eventPattern): string
    {
        return '/^(?P<timestamp>'.self::TIMESTAMP.') - '.$eventPattern.'$/';
    }
}
