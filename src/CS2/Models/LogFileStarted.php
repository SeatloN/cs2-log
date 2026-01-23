<?php

namespace CSLog\CS2\Models;

use Carbon\Carbon;
use CSLog\CS2\LogPrefix;
use CSLog\CS2\Traits\ParsesTimestamp;
use CSLog\Model;

class LogFileStarted extends Model
{
    use ParsesTimestamp;

    public const PATTERN = '/'.LogPrefix::CLASSIC.'Log file started \(file "(?P<file>[^"]+)"\) \(game "(?P<game>[^"]+)"\) \(version "(?P<version>[^"]+)"\)/';

    public string $type = 'LogFileStarted';

    public Carbon $timestamp;

    public string $file;

    public string $game;

    public string $version;
}
