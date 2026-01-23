<?php

namespace CSLog\CS2\Models;

use Carbon\Carbon;
use CSLog\CS2\CommonPatterns;
use CSLog\CS2\Traits\ParsesTimestamp;
use CSLog\Model;

class LogFileEvent extends Model
{
    use ParsesTimestamp;

    public const PATTERN = '/'.CommonPatterns::PREFIX_CLASSIC
        .'Log file (?P<event>started|closed)'
        .'(?: \(file "(?P<file>[^"]+)"\) \(game "(?P<game>[^"]+)"\) \(version "(?P<version>[^"]+)"\))?/';

    public string $type = 'LogFileEvent';

    public Carbon $timestamp;

    public string $event; // 'started' or 'closed'

    public ?string $file = null;

    public ?string $game = null;

    public ?string $version = null;

    public function __construct(array $matches)
    {
        parent::__construct($matches);

        $this->event = $matches['event'];

        if (isset($matches['file']) && $matches['file'] !== '') {
            $this->file = $matches['file'];
        }
        if (isset($matches['game']) && $matches['game'] !== '') {
            $this->game = $matches['game'];
        }
        if (isset($matches['version']) && $matches['version'] !== '') {
            $this->version = $matches['version'];
        }
    }

    public function isStarted(): bool
    {
        return $this->event === 'started';
    }

    public function isClosed(): bool
    {
        return $this->event === 'closed';
    }
}
