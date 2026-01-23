<?php

namespace CSLog\CS2\Models;

use Carbon\Carbon;
use CSLog\CS2\LogPrefix;
use CSLog\CS2\Traits\ParsesTimestamp;
use CSLog\Model;

class Purchased extends Model
{
    use ParsesTimestamp;

    public const PATTERN = '/'.LogPrefix::CLASSIC.'"(?P<userName>.+?)<(?P<userId>\d+)><(?P<steamId>[^>]*)><(?P<userTeam>CT|TERRORIST|Unassigned|Spectator)>" purchased "(?P<object>.*)"/';

    public string $type = 'Purchased';

    public Carbon $timestamp;

    public string $userId;

    public string $userName;

    public string $userTeam;

    public string $steamId;

    public string $object;
}
