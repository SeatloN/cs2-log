<?php

namespace CSLog\CS2\Models;

use Carbon\Carbon;
use CSLog\CS2\CommonPatterns;
use CSLog\CS2\PlayerIdentity;
use CSLog\CS2\Traits\ParsesTimestamp;
use CSLog\CS2\ValueObjects\Vector3;
use CSLog\Model;

class Suicide extends Model
{
    use ParsesTimestamp;

    public const PATTERN = '/'.CommonPatterns::PREFIX_CLASSIC
        .'(?P<player>'.CommonPatterns::IDENTITY_INNER.') '
        .CommonPatterns::PLAYER_VECTOR.' '
        .'committed suicide with "(?P<suicideSource>[^"]+)"/';

    public string $type = 'Suicide';

    public Carbon $timestamp;

    public PlayerIdentity $player;

    public Vector3 $playerPos;

    public string $suicideSource;

    public function __construct(array $matches)
    {
        $playerString = $matches['player'];
        unset($matches['player']);

        parent::__construct($matches);

        $this->player = PlayerIdentity::fromString($playerString);
        $this->playerPos = Vector3::fromMatches($matches, 'player');
    }
}
