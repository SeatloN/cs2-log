<?php

namespace CSLog\CS2\Models;

use Carbon\Carbon;
use CSLog\CS2\LogPrefix;
use CSLog\CS2\Traits\ParsesTimestamp;
use CSLog\Model;

class MatchEnd extends Model
{
    use ParsesTimestamp;

    public const PATTERN = '/'.LogPrefix::CLASSIC.'(Game Over: competitive) (?P<mapGroup>[a-z_0-9]*+) (?P<map>[a-z_0-9]*+) score (?P<scoreA>[0-9]{1,2}):(?P<scoreB>[0-9]{1,2}) after (?P<duration>[0-9]{1,4}) min/';

    public string $type = 'MatchEnd';

    public Carbon $timestamp;

    public string $mapGroup;

    public string $map;

    public int $scoreA;

    public int $scoreB;

    public int $duration;
}
