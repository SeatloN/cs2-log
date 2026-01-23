<?php

namespace CSLog\CS2\Models;

use Carbon\Carbon;
use CSLog\CS2\LogPrefix;
use CSLog\CS2\Traits\ParsesTimestamp;
use CSLog\Model;

class SteamIdValidated extends Model
{
    use ParsesTimestamp;

    public const PATTERN = '/'.LogPrefix::CLASSIC.'"(?P<userName>.+?)<(?P<userId>\d+)><(?P<steamId>[^>]*)><>"\s+STEAM USERID validated$/';

    public string $type = 'SteamIdValidated';

    public Carbon $timestamp;

    public string $userId;

    public string $userName;

    public string $steamId;

    public string $address;
}
