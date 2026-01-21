<?php

namespace CSLog\CS2\Models;

use CSLog\Model;

class LogFileStarted extends Model
{
    public const PATTERN = '/Log file started \(file "(?P<file>[^"]+)"\) \(game "(?P<game>[^"]+)"\) \(version "(?P<version>[^"]+)"\)/';

    public string $type = 'LogFileStarted';

    public string $file;

    public string $game;

    public string $version;
}
