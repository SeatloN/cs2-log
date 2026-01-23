<?php

namespace CSLog\CS2\Models;

use Carbon\Carbon;
use CSLog\CS2\LogPrefix;
use CSLog\CS2\Traits\ParsesTimestamp;
use CSLog\Model;

class PickedUp extends Model
{
    use ParsesTimestamp;

    public const PATTERN = '/'.LogPrefix::CLASSIC.'"(?P<userName>.+?)<(?P<userId>\d+)><(?P<steamId>[^>]*)><(?P<userTeam>CT|TERRORIST|Unassigned|Spectator)>" picked up "(?P<object>.*)"/';

    public string $type = 'PickedUp';

    public Carbon $timestamp;

    public string $userId;

    public string $userName;

    public string $userTeam;

    public string $steamId;

    public string $object;
}
