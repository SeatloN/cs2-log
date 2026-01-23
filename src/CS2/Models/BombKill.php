<?php

namespace CSLog\CS2\Models;

use Carbon\Carbon;
use CSLog\CS2\LogPrefix;
use CSLog\CS2\Traits\ParsesTimestamp;
use CSLog\Model;

class BombKill extends Model
{
    use ParsesTimestamp;

    public const PATTERN = '/'.LogPrefix::CLASSIC.'"(?P<killedName>.+?)[<](?P<killedId>\d+)[>][<](?P<killedSteamId>.*)[>][<](?P<killedTeam>CT|TERRORIST|Unassigned|Spectator)[>]" \[(?P<killedX>[\-]?[0-9]+) (?P<killedY>[\-]?[0-9]+) (?P<killedZ>[\-]?[0-9]+)\] was killed by the bomb/';

    public string $type = 'BombKill';

    public Carbon $timestamp;

    public string $killedId;

    public string $killedName;

    public string $killedTeam;

    public string $killedSteamId;

    public int $killedX;

    public int $killedY;

    public int $killedZ;
}
