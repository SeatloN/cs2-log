<?php

namespace CSLog\CS2\Models;

use Carbon\Carbon;
use CSLog\CS2\LogPrefix;
use CSLog\CS2\Traits\ParsesTimestamp;
use CSLog\Model;

class JoinTeam extends Model
{
    use ParsesTimestamp;

    public const PATTERN = '/'.LogPrefix::CLASSIC.'"(?P<userName>.+?)[<](?P<userId>\d+)[>][<](?P<steamId>.*)[>][<](?P<userTeam>CT|TERRORIST|Unassigned|Spectator)[>]" joined team "(?P<joinTeam>CT|TERRORIST|Unassigned|Spectator)"/';

    public string $type = 'JoinTeam';

    public Carbon $timestamp;

    public string $userId;

    public string $userName;

    public string $userTeam;

    public string $steamId;

    public string $joinTeam;
}
