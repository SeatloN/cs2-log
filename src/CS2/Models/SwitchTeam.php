<?php

namespace CSLog\CS2\Models;

use Carbon\Carbon;
use CSLog\CS2\CommonPatterns;
use CSLog\CS2\PlayerIdentity;
use CSLog\CS2\Traits\ParsesTimestamp;
use CSLog\Model;

class SwitchTeam extends Model
{
    use ParsesTimestamp;

    public const PATTERN = '/'.CommonPatterns::PREFIX_CLASSIC
        .'(?P<player>'.CommonPatterns::IDENTITY_INNER.') '
        .'switched from team [<](?P<oldTeam>'.CommonPatterns::TEAM.')[>] '
        .'to [<](?P<newTeam>'.CommonPatterns::TEAM.')[>]/';

    public string $type = 'SwitchTeam';

    public Carbon $timestamp;

    public PlayerIdentity $player;

    public string $oldTeam;

    public string $newTeam;

    public function __construct(array $matches)
    {
        $playerString = $matches['player'];
        unset($matches['player']);

        parent::__construct($matches);

        $this->player = PlayerIdentity::fromString($playerString);
    }
}
