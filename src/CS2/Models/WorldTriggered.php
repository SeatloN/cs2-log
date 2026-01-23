<?php

namespace CSLog\CS2\Models;

use Carbon\Carbon;
use CSLog\CS2\LogPrefix;
use CSLog\CS2\Traits\ParsesTimestamp;
use CSLog\Model;

class WorldTriggered extends Model
{
    use ParsesTimestamp;

    public const PATTERN = '/'.LogPrefix::CLASSIC.'World triggered "(?P<event>[^"]+)"(?: on "(?P<map>[^"]+)")?$/';

    public string $type = 'WorldTriggered';

    public Carbon $timestamp;

    public string $event;

    public ?string $map = null;
}
