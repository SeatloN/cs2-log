<?php

namespace CSLog\CS2\Models;

use Carbon\Carbon;
use CSLog\CS2\CommonPatterns;
use CSLog\CS2\PlayerIdentity;
use CSLog\CS2\Traits\ParsesTimestamp;
use CSLog\Model;

class BombEvent extends Model
{
    use ParsesTimestamp;

    public const PATTERN = '/'.CommonPatterns::PREFIX_CLASSIC
        .'(?P<player>'.CommonPatterns::IDENTITY_INNER.') '
        .'triggered "(?P<event>Got_The_Bomb|Dropped_The_Bomb)"/';

    public string $type = 'BombEvent';

    public Carbon $timestamp;

    public PlayerIdentity $player;

    public string $event; // 'Got_The_Bomb' or 'Dropped_The_Bomb'

    public function __construct(array $matches)
    {
        $playerString = $matches['player'];
        unset($matches['player']);

        parent::__construct($matches);

        $this->player = PlayerIdentity::fromString($playerString);
        $this->event = $matches['event'];
    }

    public function isPickup(): bool
    {
        return $this->event === 'Got_The_Bomb';
    }

    public function isDrop(): bool
    {
        return $this->event === 'Dropped_The_Bomb';
    }
}
