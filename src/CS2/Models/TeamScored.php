<?php

namespace CSLog\CS2\Models;

use Carbon\Carbon;
use CSLog\CS2\CommonPatterns;
use CSLog\CS2\Traits\ParsesTimestamp;
use CSLog\Model;

class TeamScored extends Model
{
    use ParsesTimestamp;

    public const PATTERN = '/'.CommonPatterns::PREFIX_CLASSIC
        .'Team "(?P<team>'.CommonPatterns::TEAM.')" '
        .'scored "(?P<score>\d+)" with "(?P<players>\d+)" players/';

    public string $type = 'TeamScored';

    public Carbon $timestamp;

    public string $team;

    public int $score;

    public int $players;
}
