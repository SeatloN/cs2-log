<?php

namespace CSLog\CS2\Models;

use Carbon\Carbon;
use CSLog\CS2\LogPrefix;
use CSLog\CS2\Traits\ParsesTimestamp;
use CSLog\Model;

class Connected extends Model
{
    use ParsesTimestamp;

    public const PATTERN = '/'.LogPrefix::CLASSIC.'"(?P<userName>.+?)[<](?P<userId>\d+)[>][<](?P<steamId>.*)[>][<][>]" connected, address "(?P<address>.*)"/';

    public string $type = 'Connected';

    public Carbon $timestamp;

    public string $userId;

    public string $userName;

    public string $steamId;

    public string $address;
}
