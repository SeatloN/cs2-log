<?php

namespace CSLog\CS2\Models;

use Carbon\Carbon;
use CSLog\CS2\LogPrefix;
use CSLog\CS2\Traits\ParsesTimestamp;
use CSLog\Model;

class PropKill extends Model
{
    use ParsesTimestamp;

    public const PATTERN =
        '/'.LogPrefix::CLASSIC
        .'"(?P<attackerName>.+?)<(?P<attackerId>\d+)><(?P<attackerSteamId>[^>]*)><(?P<attackerTeam>CT|TERRORIST|Unassigned|Spectator)>" '
        .'\[(?P<attackerX>-?\d+) (?P<attackerY>-?\d+) (?P<attackerZ>-?\d+)\] '
        .'killed other "(?P<propName>[a-zA-Z0-9_]+)<(?P<propId>\d+)>" '
        .'\[(?P<propX>-?\d+) (?P<propY>-?\d+) (?P<propZ>-?\d+)\] '
        .'with "(?P<weapon>[a-zA-Z0-9_]+)"(?: \(penetrated\))?$/';

    public string $type = 'PropKill';

    public Carbon $timestamp;

    public string $attackerName;

    public int $attackerId;

    public string $attackerSteamId;

    public string $attackerTeam;

    public int $attackerX;

    public int $attackerY;

    public int $attackerZ;

    public string $propName;

    public int $propId;

    public int $propX;

    public int $propY;

    public int $propZ;

    public string $weapon;

    public bool $penetrated;
}
