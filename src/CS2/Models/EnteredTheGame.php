<?php

namespace CSLog\CS2\Models;

use Carbon\Carbon;
use CSLog\CS2\LogPrefix;
use CSLog\CS2\Traits\ParsesTimestamp;
use CSLog\Model;

class EnteredTheGame extends Model
{
    use ParsesTimestamp;

    public const PATTERN = '/'.LogPrefix::CLASSIC.'"(?P<userName>.+?)[<](?P<userId>\d+)[>][<](?P<steamId>.*)[>][<][>]" entered the game/';

    public string $type = 'EnteredTheGame';

    public Carbon $timestamp;

    public string $userId;

    public string $userName;

    public string $steamId;
}
