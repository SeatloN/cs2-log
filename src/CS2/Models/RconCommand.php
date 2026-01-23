<?php

namespace CSLog\CS2\Models;

use Carbon\Carbon;
use CSLog\CS2\LogPrefix;
use CSLog\CS2\Traits\ParsesTimestamp;
use CSLog\Model;

class RconCommand extends Model
{
    use ParsesTimestamp;

    public const PATTERN = '/'.LogPrefix::CLASSIC.'rcon from "(?P<ip>[^"]+)": command "(?P<command>.+)"/';

    public string $type = 'RconCommand';

    public Carbon $timestamp;

    public string $ip;

    public string $command;
}
