<?php

namespace CSLog\CS2\Models;

use Carbon\Carbon;
use CSLog\CS2\CommonPatterns;
use CSLog\CS2\PlayerIdentity;
use CSLog\CS2\Traits\ParsesTimestamp;
use CSLog\Model;

class BombPlanted extends Model
{
    use ParsesTimestamp;

    public const PATTERN = '/'.CommonPatterns::PREFIX_CLASSIC
        .'(?P<player>'.CommonPatterns::IDENTITY_INNER.') '
        .'triggered "Planted_The_Bomb" at bombsite (?P<bombsite>A|B)/';

    public string $type = 'BombPlanted';

    public Carbon $timestamp;

    public PlayerIdentity $player;

    public string $bombsite;

    public function __construct(array $matches)
    {
        $playerString = $matches['player'];
        unset($matches['player']);

        parent::__construct($matches);

        $this->player = PlayerIdentity::fromString($playerString);
    }
}
