<?php

namespace CSLog\CS2\Models;

use Carbon\Carbon;
use CSLog\CS2\LogPrefix;
use CSLog\CS2\Traits\ParsesTimestamp;
use CSLog\Model;

class ServerCVarBlock extends Model
{
    use ParsesTimestamp;

    public const PATTERN = '/'.LogPrefix::CLASSIC.'server cvars (?P<blockType>start|end)/';

    public string $type = 'ServerCVarBlock';

    public Carbon $timestamp;

    public string $blockType;
}
