<?php

namespace CSLog\CS2\Models;

use Carbon\Carbon;
use CSLog\CS2\LogPrefix;
use CSLog\CS2\Traits\ParsesTimestamp;
use CSLog\Model;

class TeamScored extends Model
{
    use ParsesTimestamp;

    public const PATTERN = '/'.LogPrefix::CLASSIC.'Team "(?P<team>CT|TERRORIST)" scored "(?P<score>\d+)" with "(?P<players>\d+)" players/';

    public string $type = 'TeamScored';

    public Carbon $timestamp;

    public string $team;

    public int $score;

    public int $players;
}
