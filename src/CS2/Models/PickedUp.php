<?php

namespace CSLog\CS2\Models;

use CSLog\Model;

class PickedUp extends Model
{
    public const PATTERN = '/"(?P<userName>.+)[<](?P<userId>\d+)[>][<](?P<steamId>.*)[>][<](?P<userTeam>CT|TERRORIST|Unassigned|Spectator)[>]" picked up "(?P<object>.*)"/';

    public string $type = 'PickedUp';

    public string $userId;

    public string $userName;

    public string $userTeam;

    public string $steamId;

    public string $object;
}
