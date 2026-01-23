<?php

namespace CSLog;

use Carbon\Carbon;
use ReflectionProperty;

/**
 * Base model for CS2 log events
 *
 * @method Carbon parseTimestamp(string $timestamp) Available when using ParsesTimestamp trait
 */
abstract class Model
{
    public const PATTERN = null;

    public string $type;

    public function __construct($data = [])
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $reflection = new ReflectionProperty($this, $key);
                $type = $reflection->getType();

                // Auto-parse Carbon timestamps if the parseTimestamp method is available
                if ($type && $type->getName() === 'Carbon\Carbon' && method_exists($this, 'parseTimestamp')) {
                    $this->{$key} = $this->parseTimestamp($value);
                } else {
                    $this->{$key} = $value;
                }
            }
        }
    }
}
