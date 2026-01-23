<?php

namespace CSLog\CS2\Models;

use Carbon\Carbon;
use CSLog\CS2\LogPrefix;
use CSLog\CS2\Traits\ParsesTimestamp;
use CSLog\Model;

class Suicide extends Model
{
    use ParsesTimestamp;

    public const PATTERN = '/'.LogPrefix::CLASSIC.'"(?P<playerName>.+?)<(?P<playerId>\d+)><(?P<playerSteamId>[^>]*)><(?P<playerTeam>CT|TERRORIST|Unassigned|Spectator)>" \[(?P<playerX>[\-]?[0-9]+) (?P<playerY>[\-]?[0-9]+) (?P<playerZ>[\-]?[0-9]+)\] committed suicide with "(?P<suicideSource>[^"]+)"/';

    public string $type = 'Suicide';

    public Carbon $timestamp;

    public string $playerName;

    public string $playerId;

    public string $playerSteamId;

    public string $playerTeam;

    public int $playerX;

    public int $playerY;

    public int $playerZ;

    public string $suicideSource;
}
