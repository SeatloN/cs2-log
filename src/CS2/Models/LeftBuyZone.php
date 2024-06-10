<?php

namespace CSLog\CS2\Models;

use CSLog\Model;

class LeftBuyZone extends Model
{
    public const PATTERN = '/"(?P<userName>.*)[<](?P<userId>\d+)[>][<](?P<userSteamId>.*)[>][<](?P<userTeam>CT|TERRORIST|Unassigned|Spectator)[>]" left buyzone with \[ (?P<items>[^\]]+) \]/';

    public string $type = 'LeftBuyZone';

    public string $userName;

    public string $userId;

    public string $userSteamId;

    public string $userTeam;

    public string $items;
}
