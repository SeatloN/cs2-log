<?php

namespace CSLog\CS2\Traits;

use Carbon\Carbon;

trait ParsesTimestamp
{
    /**
     * Parse CS2 log timestamp format
     * Supports: MM/DD/YYYY - HH:MM:SS and MM/DD/YYYY - HH:MM:SS.mmm
     */
    protected function parseTimestamp(string $timestamp): Carbon
    {
        // Handle both formats: with and without milliseconds
        if (str_contains($timestamp, '.')) {
            // Format: 01/09/2024 - 03:50:44.170
            return Carbon::createFromFormat('m/d/Y - H:i:s.v', $timestamp);
        } else {
            // Format: 01/09/2024 - 03:50:44
            return Carbon::createFromFormat('m/d/Y - H:i:s', $timestamp);
        }
    }
}
