<?php

namespace CSLog\CS2;

use RuntimeException;

class PlayerIdentity
{
    /**
     * @param  string  $name  Player's name.
     * @param  int  $id  Player's ID.
     * @param  string  $steamId  Player's Steam ID.
     * @param  string  $team  Player's team.
     */
    public function __construct(
        public string $name,
        public int $id,
        public string $steamId,
        public string $team,
    ) {}

    /**
     * Parses identity block into a PlayerIdentity.
     *
     * @param  string  $block  Parsed identity block from CS2.
     * @return PlayerIdentity Parsed PlayerIdentity object.
     *
     * @throws RuntimeException if the line does not match.
     */
    public static function fromString(string $block): self
    {
        if (! preg_match('/'.CommonPatterns::IDENTITY.'/', $block, $m)) {
            throw new RuntimeException("Invalid identity block: {$block}");
        }

        return new self(
            name: $m['name'],
            id: (int) $m['id'],
            steamId: $m['steam'],
            team: $m['team'] ?? '',
        );
    }
}
