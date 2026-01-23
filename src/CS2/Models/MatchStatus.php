<?php

namespace CSLog\CS2\Models;

use Carbon\Carbon;
use CSLog\CS2\LogPrefix;
use CSLog\CS2\Traits\ParsesTimestamp;
use CSLog\Model;

class MatchStatus extends Model
{
    use ParsesTimestamp;

    public const PATTERN = '/'.LogPrefix::CLASSIC.'MatchStatus: Score: (?P<scoreA>[0-9]{1,2}):(?P<scoreB>[0-9]{1,2}) on map "(?P<map>[a-z_0-9]*)" RoundsPlayed: (?P<roundsPlayed>-?[0-9])/';

    public string $type = 'MatchStatus';

    public Carbon $timestamp;

    public int $scoreA;

    public int $scoreB;

    public string $map;

    public int $roundsPlayed;
}
