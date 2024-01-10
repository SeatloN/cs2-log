<?php

namespace CSLog\CS2\Models;

use CSLog\Model;

class MoneyChanged extends Model
{
    public const PATTERN = '/"(?P<userName>.+)[<](?P<userId>\d+)[>][<](?P<steamId>.*)[>][<](?P<userTeam>CT|TERRORIST|Unassigned|Spectator)[>]" money change (?P<before>.\d+)-(?P<cost>.\d+) = \$(?P<bank>.\d+) \(tracked\) \(purchase: (?P<purchase>.*)\)/';

    public string $type = 'MoneyChanged';

    public string $userId;

    public string $userName;

    public string $userTeam;

    public string $steamId;

    public string $before;

    public string $cost;

    public string $bank;

    public string $purchase;
}
