<?php

namespace CSLog\CS2\Models;

use Carbon\Carbon;
use CSLog\CS2\LogPrefix;
use CSLog\CS2\Traits\ParsesTimestamp;
use CSLog\Model;

class RoundRestart extends Model
{
    use ParsesTimestamp;

    public const PATTERN = '/'.LogPrefix::CLASSIC.'World triggered "Restart_Round_\((?P<seconds>[0-9]{1,2})_(second|seconds)\)"/';

    public string $type = 'RoundRestart';

    public Carbon $timestamp;

    public int $seconds;
}
