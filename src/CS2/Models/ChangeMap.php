<?php

namespace CSLog\CS2\Models;

use Carbon\Carbon;
use CSLog\CS2\LogPrefix;
use CSLog\CS2\Traits\ParsesTimestamp;
use CSLog\Model;

class ChangeMap extends Model
{
    use ParsesTimestamp;

    public const PATTERN = '/'.LogPrefix::CLASSIC.'(Started map|Loading map) "(?P<maps>.*)"/';

    public string $type = 'ChangeMap';

    public Carbon $timestamp;

    public string $maps;
}
