<?php

namespace CSLog\CS2\Models;

use Carbon\Carbon;
use CSLog\CS2\LogPrefix;
use CSLog\CS2\Traits\ParsesTimestamp;
use CSLog\Model;

class Threw extends Model
{
    use ParsesTimestamp;

    public const PATTERN = '/'.LogPrefix::CLASSIC.'"(?P<userName>.+?)<(?P<userId>\d+)><(?P<steamId>[^>]*)><(?P<userTeam>CT|TERRORIST|Unassigned|Spectator)>" threw (?P<item>hegrenade|flashbang|smokegrenade|decoy|molotov) \[(?P<posX>[\-]?[0-9]+) (?P<posY>[\-]?[0-9]+) (?P<posZ>[\-]?[0-9]+)\](?: flashbang entindex (?P<entindex>[0-9]+))?/';

    public string $type = 'Threw';

    public Carbon $timestamp;

    public string $userId;

    public string $userName;

    public string $userTeam;

    public string $steamId;

    public int $posX;

    public int $posY;

    public int $posZ;

    public string $item;

    public ?int $entindex = null;
}
