<?php

namespace CSLog\CS2;

use RuntimeException;

class PlayerIdentity
{
    public function __construct(
        public string $name,
        public int $id,
        public string $steam,
        public string $team,
    ) {}

    public static function fromString(string $block): self
    {
        if (! preg_match('/'.CommonPatterns::IDENTITY.'/', $block, $m)) {
            throw new RuntimeException("Invalid identity block: {$block}");
        }

        return new self(
            name: $m['name'],
            id: (int) $m['id'],
            steam: $m['steam'],
            team: $m['team'] ?? '',
        );
    }
}
