<?php

namespace CSLog\CS2\Models;

use CSLog\Model;

class BombKill extends Model
{
    public const PATTERN = '/"(?P<killedName>.+)[<](?P<killedId>\d+)[>][<](?P<killedSteamId>.*)[>][<](?P<killedTeam>CT|TERRORIST|Unassigned|Spectator)[>]" \[(?P<killedX>[\-]?[0-9]+) (?P<killedY>[\-]?[0-9]+) (?P<killedZ>[\-]?[0-9]+)\] was killed by the bomb/';

    public string $type = 'BombKill';

    public string $killedId;

    public string $killedName;

    public string $killedTeam;

    public string $killedSteamId;

    public int $killedX;

    public int $killedY;

    public int $killedZ;
}
