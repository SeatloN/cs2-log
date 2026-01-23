<?php

namespace CSLog\CS2\Models;

use Carbon\Carbon;
use CSLog\CS2\CommonPatterns;
use CSLog\CS2\Traits\ParsesTimestamp;
use CSLog\Model;

class TeamPlaying extends Model
{
    use ParsesTimestamp;

    public const PATTERN = '/'.CommonPatterns::PREFIX_CLASSIC
        .'(?:MatchStatus:\s*)?Team playing "(?P<side>CT|TERRORIST)": (?P<teamName>.+)$/';

    public string $type = 'TeamPlaying';

    public Carbon $timestamp;

    public string $side;

    public string $teamName;
}
