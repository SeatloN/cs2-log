<?php

namespace CSLog\CS2\Models;

use Carbon\Carbon;
use CSLog\CS2\LogPrefix;
use CSLog\CS2\Traits\ParsesTimestamp;
use CSLog\Model;

class LeftBuyZone extends Model
{
    use ParsesTimestamp;

    public const PATTERN = '/'.LogPrefix::CLASSIC.'"(?P<userName>.+?)<(?P<userId>\d+)><(?P<userSteamId>[^>]*)><(?P<userTeam>CT|TERRORIST|Unassigned|Spectator)>" left buyzone with \[ (?P<items>[^\]]+) \]/';

    public string $type = 'LeftBuyZone';

    public Carbon $timestamp;

    public string $userName;

    public string $userId;

    public string $userSteamId;

    public string $userTeam;

    public string $items;
}
