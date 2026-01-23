<?php

namespace CSLog\CS2\Models;

use Carbon\Carbon;
use CSLog\CS2\LogPrefix;
use CSLog\CS2\Traits\ParsesTimestamp;
use CSLog\Model;

class MoneyChanged extends Model
{
    use ParsesTimestamp;

    public const PATTERN = '/'.LogPrefix::CLASSIC.'"(?P<userName>.+?)<(?P<userId>\d+)><(?P<steamId>[^>]*)><(?P<userTeam>CT|TERRORIST|Unassigned|Spectator)>" money change (?P<before>.\d+)-(?P<cost>.\d+) = \$(?P<bank>.\d+) \(tracked\) \(purchase: (?P<purchase>.*)\)/';

    public string $type = 'MoneyChanged';

    public Carbon $timestamp;

    public string $userId;

    public string $userName;

    public string $userTeam;

    public string $steamId;

    public string $before;

    public string $cost;

    public string $bank;

    public string $purchase;
}
