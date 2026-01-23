<?php

namespace CSLog\CS2\Models;

use Carbon\Carbon;
use CSLog\CS2\LogPrefix;
use CSLog\CS2\Traits\ParsesTimestamp;
use CSLog\Model;

class FlashAssistedKill extends Model
{
    use ParsesTimestamp;

    public const PATTERN = '/'.LogPrefix::CLASSIC.'"(?P<assisterName>.+?)[<](?P<assisterId>\d+)[>][<](?P<assisterSteamId>.*)[>][<](?P<assisterTeam>CT|TERRORIST|Unassigned|Spectator)[>]" flash-assisted killing "(?P<killedName>.+?)[<](?P<killedId>\d+)[>][<](?P<killedSteamId>.*)[>][<](?P<killedTeam>CT|TERRORIST|Unassigned|Spectator)[>]"/';

    public string $type = 'FlashAssistedKill';

    public Carbon $timestamp;

    public string $assisterId;

    public string $assisterName;

    public string $assisterTeam;

    public string $assisterSteamId;

    public string $killedId;

    public string $killedName;

    public string $killedTeam;

    public string $killedSteamId;
}
