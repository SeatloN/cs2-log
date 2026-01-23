<?php

namespace CSLog\CS2\Models;

use Carbon\Carbon;
use CSLog\CS2\CommonPatterns;
use CSLog\CS2\Traits\ParsesTimestamp;
use CSLog\Model;

class ServerCVarBlock extends Model
{
    use ParsesTimestamp;

    public const PATTERN = '/'.CommonPatterns::PREFIX_CLASSIC
        .'server cvars (?P<blockType>start|end)/';

    public string $type = 'ServerCVarBlock';

    public Carbon $timestamp;

    public string $blockType;
}
