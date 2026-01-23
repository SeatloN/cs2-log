<?php

namespace CSLog\CS2\Models;

use Carbon\Carbon;
use CSLog\CS2\CommonPatterns;
use CSLog\CS2\Traits\ParsesTimestamp;
use CSLog\Model;

class RoundDraw extends Model
{
    use ParsesTimestamp;

    public const PATTERN = '/'.CommonPatterns::PREFIX_CLASSIC
        .'World triggered "SFUI_Notice_Round_Draw" '
        .'\(CT "(?P<scoreA>[0-9]{1,2})"\) \(T "(?P<scoreB>[0-9]{1,2})"\)/';

    public string $type = 'RoundDraw';

    public Carbon $timestamp;

    public int $scoreA;

    public int $scoreB;
}
