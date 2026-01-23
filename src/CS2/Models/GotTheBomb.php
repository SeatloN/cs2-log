<?php

namespace CSLog\CS2\Models;

use Carbon\Carbon;
use CSLog\CS2\LogPrefix;
use CSLog\CS2\Traits\ParsesTimestamp;
use CSLog\Model;

class GotTheBomb extends Model
{
    use ParsesTimestamp;

    public const PATTERN = '/'.LogPrefix::CLASSIC.'"(?P<userName>.+?)[<](?P<userId>\d+)[>][<](?P<steamId>.*)[>][<](?P<team>CT|TERRORIST|Unassigned|Spectator)[>]" triggered \"Got\_The\_Bomb\"/';

    public string $type = 'GotTheBomb';

    public Carbon $timestamp;

    public string $userName;

    public string $userId;

    public string $steamId;

    public string $team;
}
