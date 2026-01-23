<?php

namespace CSLog\CS2\Models;

use Carbon\Carbon;
use CSLog\CS2\LogPrefix;
use CSLog\CS2\Traits\ParsesTimestamp;
use CSLog\Model;

class Say extends Model
{
    use ParsesTimestamp;

    public const PATTERN = '/'.LogPrefix::CLASSIC.'"(?P<userName>.+?)<(?P<userId>\d+)><(?P<steamId>[^>]*)><(?P<userTeam>CT|TERRORIST|Unassigned|Spectator)>" say "(?P<text>.*)"/';

    public string $type = 'Say';

    public Carbon $timestamp;

    public string $userId;

    public string $userName;

    public string $userTeam;

    public string $steamId;

    public string $text;
}
