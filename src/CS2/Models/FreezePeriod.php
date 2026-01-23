<?php

namespace CSLog\CS2\Models;

use Carbon\Carbon;
use CSLog\CS2\CommonPatterns;
use CSLog\CS2\Traits\ParsesTimestamp;
use CSLog\Model;

class FreezePeriod extends Model
{
    use ParsesTimestamp;

    public const PATTERN = '/'.CommonPatterns::PREFIX_CLASSIC.'Starting Freeze period/';

    public string $type = 'FreezePeriod';

    public Carbon $timestamp;
}
