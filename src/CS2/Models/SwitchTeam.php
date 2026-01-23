<?php

namespace CSLog\CS2\Models;

use Carbon\Carbon;
use CSLog\CS2\LogPrefix;
use CSLog\CS2\Traits\ParsesTimestamp;
use CSLog\Model;

class SwitchTeam extends Model
{
    use ParsesTimestamp;

    public const PATTERN = '/'.LogPrefix::CLASSIC.'"(?P<userName>.+?)<(?P<userId>\d+)><(?P<steamId>[^>]*)>" switched from team [<](?P<oldTeam>CT|TERRORIST|Unassigned|Spectator)[>] to [<](?P<newTeam>CT|TERRORIST|Unassigned|Spectator)[>]/';

    public string $type = 'SwitchTeam';

    public Carbon $timestamp;

    public string $userId;

    public string $userName;

    public string $oldTeam;

    public string $steamId;

    public string $newTeam;
}
